<?php

namespace App\Controller;

use App\Mapper\Config;
use App\Mapper\User;
use Fal\Stick\Fw;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Sql\Connection;
use Fal\Stick\Library\Template\Template;

class SetupController
{
    const VERSION = '0.1.0-alpha';
    const FILE = 'VERSION';

    private $version = '0.0.0';
    private $file;

    public function __construct(Fw $fw)
    {
        $this->fw = $fw;
        $this->file = $fw->get('TEMP').self::FILE;
        $content = $fw->read($this->file, true);

        if ($content) {
            $this->version = strstr($content, "\n", true);
        }
    }

    public function home(Template $template)
    {
        if ($this->isComplete()) {
            return $this->fw->reroute($this->fw->get('BASEURL'));
        }

        return $template->render('setup.php', array(
            'app_version' => self::VERSION,
            'installed_version' => $this->version,
            'file' => $this->fw->get('SERVER.SCRIPT_FILENAME'),
        ));
    }

    public function install()
    {
        if (!$this->isComplete()) {
            $this->fw->cacheReset();

            foreach ($this->getInstallers() as $install) {
                $this->$install();
            }

            $this->commit();
        }

        return $this->fw->reroute();
    }

    private function isComplete(): bool
    {
        return $this->version === self::VERSION;
    }

    private function commit()
    {
        $content = self::VERSION."\n".'installation complete at '.date('Y-m-d G:i:s.u');

        $this->fw->write($this->file, $content);
    }

    private function getInstallers()
    {
        $installers = preg_grep('/^__version.+$/i', get_class_methods($this));
        usort($installers, 'version_compare');
        $ndx = array_search($this->version, $installers);

        if (false !== $ndx) {
            $installers = array_slice($installers, $ndx);
        }

        return $installers;
    }

    private function importSchemas(array $files)
    {
        $dir = $this->fw->get('APP_DIR').'db/';
        $pdo = $this->fw->service(Connection::class)->pdo();

        foreach ($files as $file) {
            $pdo->exec(file_get_contents($dir.$file));
        }
    }

    private function __version010Alpha()
    {
        $this->fw->delete($this->fw->get('DB_PATH'));

        $this->importSchemas(array(
            '100-schema.sql',
        ));

        $users = array(
            array(
                'fullname' => 'Administrator',
                'username' => 'adminku',
                'password' => $this->fw->service(Auth::class)->getEncoder()->hash('admin123'),
                'roles' => 'Admin',
            ),
        );
        $user = $this->fw->instance(User::class);
        $config = $this->fw->instance(Config::class);

        foreach ($users as $data) {
            $user->reset()->fromArray($data)->save();
        }

        foreach ($config->defaults() as $name => $content) {
            $config->reset()->fromArray(compact('name', 'content'))->save();
        }
    }
}
