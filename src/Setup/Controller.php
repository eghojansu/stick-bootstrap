<?php

namespace App\Setup;

use App\App;
use Fal\Stick\Fw;

class Controller
{
    private $installers = array();
    private $initial = array(
        'db_path'  => 'app.db',
        /*
        'db_host'  => 'localhost',
        'db_port' => '3306',
        'db_username'  => 'root',
        'db_password' => 'root',
        'db_dbname'  => 'test_stick',
        */
    );
    private $commitPrefix = array(
        'db_' => 'DB',
    );
    private $commit = array();
    private $form;
    private $fw;

    public function __construct(Fw $fw)
    {
        $this->fw = $fw;
        $this->initial['db_path'] = $fw->TEMP.$this->initial['db_path'];

        $this->overrideInitial();
        $this->loadInstaller();
        $this->form = $fw->form('install', $this->initial);
        $fw->prepend('template_dir', __DIR__.'/template/;');
    }

    public function install(Fw $fw)
    {
        if ('yes' === $fw['GET.finish'] && $fw['SESSION.install_finish']) {
            $this->commit();

            return $fw->template->render('install.html', array(
                'finish' => $fw->flash('SESSION.install_finish'),
                'version' => App::VERSION,
            ));
        }

        $this->prepareForm();
        $this->prepareInstaller();
        $this->finishForm();

        if ($this->form->isSubmitted() && $this->form->valid()) {
            $this->initialCommit();
            $this->connect();
            $this->doInstall();
            $this->finish();

            return $fw->set('SESSION.install_finish', true)->reroute('?finish=yes');
        }

        return $fw->rem('SESSION')->template->render('install.html', array(
            'finish' => false,
            'form' => $this->form,
            'version' => $fw->INSTALLED ?? 'none',
            'targetVersion' => App::VERSION,
        ));
    }

    private function allowInstall(SetupInterface $installer)
    {
        $version = $installer->getVersion();
        $passMinimum = !$this->fw->INSTALLED || version_compare($version, $this->fw->INSTALLED, '>');
        $passMaximum = version_compare($version, App::VERSION, '<=');

        return $passMinimum && $passMaximum;
    }

    private function initialCommit()
    {
        foreach ($this->form->getValidatedData() as $key => $value) {
            foreach ($this->commitPrefix as $prefix => $group) {
                if (false !== strpos($key, $prefix)) {
                    $this->commit[$group][substr($key, strlen($prefix))] = $value;
                }
            }
        }
    }

    private function connect()
    {
        try {
            $createDb = isset($this->commit['DB']);

            if ($createDb) {
                $this->fw['DB'] = $this->commit['DB'];
            }

            $db = $this->fw['DB'];

            /*
            $dsn = 'mysql:host='.$db['host'].';port='.$db['port'];
            $username = $db['username'];
            $password = $db['password'];
            $dbname = '`'.$db['dbname'].'`';

            $pdo = new \PDO($dsn, $username, $password);

            if ($this->form['install_from_beginning']) {
                $pdo->exec('DROP DATABASE IF EXISTS '.$dbname);
            }

            if ($createDb) {
                $pdo->exec('CREATE DATABASE IF NOT EXISTS '.$dbname);
            }
            */

            if ($this->form['install_from_beginning'] && !$this->fw->delete($db['path'])) {
                throw new \LogicException('Unable to delete file: '.$db['path']);
            }

            $dsn = 'sqlite:'.$db['path'];
            $pdo = new \PDO($dsn);
        } catch (\PDOException $e) {
            throw new \LogicException('Invalid database configuration ('.$e->getMessage().').');
        }
    }

    private function doInstall()
    {
        $executor = new SqlExecutor($this->fw->db->pdo());

        foreach ($this->installers as $installer) {
            if ($this->form['install_from_beginning'] || $this->allowInstall($installer)) {
                $this->commit += $installer->install($executor);
            }
        }
    }

    private function finish()
    {
        $this->fw->write($this->fw['TEMP'].'parameters.ini', $this->stringify());
    }

    private function commit()
    {
        $this->fw->write($this->fw['TEMP'].'version.ini', 'INSTALLED = '.App::VERSION);
    }

    private function stringify()
    {
        $str = '';
        $globals = "[GLOBALS]\n";
        $line = function($key, $arg) {
            if (is_string($arg)) {
                $arg = str_replace(array('"', "'"), '', $arg);
            } elseif (is_array($arg)) {
                $arg = implode(',', $arg);
            }

            return sprintf("%s = %s\n", $key, $arg);
        };

        foreach ($this->commit as $key => $value) {
            if (is_array($value)) {
                $tmp = sprintf("[%s]\n", $key);

                foreach ($value as $key2 => $value2) {
                    $tmp .= $line($key2, $value2);
                }

                $str .= $tmp;
            } else {
                $globals .= $line($key, $value);
            }
        }

        return $str.$globals;
    }

    private function overrideInitial()
    {
        foreach ($this->commitPrefix as $prefix => $group) {
            foreach ($this->fw[$group] ?? array() as $key => $value) {
                $this->initial[$prefix.$key] = $value;
            }
        }
    }

    private function loadInstaller()
    {
        $installers = array();

        foreach ($this->fw->files(__DIR__) as $file) {
            if (preg_match('~(/v\d{3}/.+)\.php$~', $file, $match)) {
                $class = 'App\\Setup'.str_replace('/', '\\', $match[1]);
                $installer = new $class();

                if (!$installer instanceof SetupInterface) {
                    throw new \LogicException('Setup class should implements App\\Setup\\SetupInterface.');
                }

                $installers[$installer->getVersion()] = $installer;
            }
        }

        ksort($installers);

        $this->installers = $installers;
    }

    private function prepareForm()
    {
        if (!$this->fw['DB']) {
            $this->requestDbInformation();
        }
    }

    private function prepareInstaller()
    {
        foreach ($this->installers as $installer) {
            if ($this->form['install_from_beginning'] || $this->allowInstall($installer)) {
                $installer->prepare($this->fw, $this->form);
            }
        }
    }

    private function finishForm()
    {
        $this->form
            ->set('install_from_beginning', 'checkbox', array(
                'label' => 'Install from beginning? (This will remove database and install from first available version)',
            ))
            ->set('confirm', 'submit', array(
                'label' => 'Confirm Installation',
                'attr' => array(
                    'class' => 'btn btn-primary btn-lg'
                ),
            ))
            ->set('reset', 'reset', array(
                'attr' => array(
                    'class' => 'btn btn-default',
                ),
            ))
        ;
    }

    private function requestDbInformation()
    {
        $this->form
            ->set('db_path', 'text', array(
                'label' => 'DB path',
                'attr' => array(
                    'placeholder' => 'Database path',
                ),
                'constraints' => 'trim|required',
            ))
            /*
            ->set('db_host', 'text', array(
                'label' => 'Host',
                'attr' => array(
                    'placeholder' => 'Database Host',
                ),
                'constraints' => 'trim|required',
            ))
            ->set('db_port', 'text', array(
                'label' => 'Port',
                'attr' => array(
                    'placeholder' => 'Database Port',
                ),
                'constraints' => 'trim|required',
            ))
            ->set('db_username', 'text', array(
                'label' => 'Username',
                'attr' => array(
                    'placeholder' => 'Database Username',
                ),
                'constraints' => 'trim|required',
            ))
            ->set('db_password', 'text', array(
                'label' => 'Password',
                'attr' => array(
                    'placeholder' => 'Database Password',
                ),
                'constraints' => 'trim|required',
            ))
            ->set('db_dbname', 'text', array(
                'label' => 'Database Name',
                'attr' => array(
                    'placeholder' => 'Database Name',
                ),
                'constraints' => 'trim|required',
            ))
            */
        ;
    }
}
