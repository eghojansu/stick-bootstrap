<?php

namespace App\Setup\Setup;

use App\Setup\SetupInterface;
use Fal\Stick\Form\Form;
use Fal\Stick\Fw;

class MysqlSetup implements SetupInterface
{
    protected $requiredDriver = 'mysql';
    protected $commitPrefix = array(
        'db_' => 'DB',
    );
    protected $commit = array();
    protected $initial;
    protected $form;
    protected $pdo;
    protected $fw;

    public function __construct(Fw $fw)
    {
        $this->initial = static::overrideInitial($fw, $this->commitPrefix, array(
            'db_host'  => 'localhost',
            'db_port' => '3306',
            'db_username'  => 'root',
            'db_password' => 'root',
            'db_dbname'  => 'test_stick',
        ));
        $this->fw = $fw;
        $this->form = $fw->form('install', $this->initial);
    }

    /**
     * {@inheritdoc}
     */
    public function prepare(Fw $fw, array $versions)
    {
        $this->prepareInitial();

        foreach ($versions as $version) {
            $version->prepare($fw, $this);
        }

        $this->finishForm();
    }

    /**
     * {@inheritdoc}
     */
    public function install(Fw $fw, array $versions)
    {
        $this->commitInitial();
        $this->connect();

        foreach ($versions as $version) {
            $version->install($fw, $this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup(string $group, array $config)
    {
        $this->commit = array_replace_recursive($this->commit, array($group => $config));
    }

    /**
     * {@inheritdoc}
     */
    public function stringify(): string
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

    /**
     * {@inheritdoc}
     */
    public function isSubmitted(): bool
    {
        return $this->form->isSubmitted() && $this->form->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function installFromBeginning(): bool
    {
        return $this->form['install_from_beginning'] ?? false;
    }

    /**
     * {@inheritdoc}
     */
    public function execSql(string $sql)
    {
        $this->driverCheck();

        $pdo = $this->fw->db->pdo();
        $pdo->exec($sql);
        $error = $pdo->errorInfo();

        if ('00000' !== $error[0]) {
            throw new \LogicException(sprintf('[%s - %s] %s.', ...$error));
        }
    }

    protected static function overrideInitial(Fw $fw, array $commit, array $initial)
    {
        foreach ($commit as $prefix => $group) {
            foreach ($fw[$group] ?? array() as $key => $value) {
                $initial[$prefix.$key] = $value;
            }
        }

        return $initial;
    }

    protected function prepareInitial()
    {
        foreach ($this->commitPrefix as $group) {
            if (!$this->fw[$group]) {
                $this->{'request'.$group.'Form'}();
            }
        }
    }

    protected function commitInitial()
    {
        foreach ($this->form->getValidatedData() as $key => $value) {
            foreach ($this->commitPrefix as $prefix => $group) {
                if (false !== strpos($key, $prefix)) {
                    $this->commit[$group][substr($key, strlen($prefix))] = $value;
                }
            }
        }
    }

    protected function requestDBForm()
    {
        $this->form
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
        ;
    }

    protected function finishForm()
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

    protected function connect()
    {
        try {
            $createDb = isset($this->commit['DB']);

            if ($createDb) {
                $this->fw['DB'] = $this->commit['DB'];
            }

            $db = $this->fw['DB'];

            $dsn = 'mysql:host='.$db['host'].';port='.$db['port'];
            $username = $db['username'];
            $password = $db['password'];
            $dbname = '`'.$db['dbname'].'`';

            $pdo = new \PDO($dsn, $username, $password);

            if ($this->installFromBeginning()) {
                $pdo->exec('DROP DATABASE IF EXISTS '.$dbname);
                $createDb = true;
            }

            if ($createDb) {
                $pdo->exec('CREATE DATABASE IF NOT EXISTS '.$dbname);
            }
        } catch (\PDOException $e) {
            throw new \LogicException('Invalid database configuration ('.$e->getMessage().').');
        }
    }

    protected function driverCheck()
    {
        if (false === stripos($driver = $this->fw->db->driver(), $this->requiredDriver)) {
            throw new \LogicException(sprintf('Required %s driver, given %s driver.', $this->requiredDriver, $driver));
        }
    }
}
