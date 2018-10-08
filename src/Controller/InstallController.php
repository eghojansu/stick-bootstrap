<?php

namespace App\Controller;

use App\Mapper\Config;
use App\Mapper\User;
use Fal\Stick\App;
use Fal\Stick\Library\Env;
use Fal\Stick\Library\Security\BcryptPasswordEncoder;
use Fal\Stick\Library\Sql\Connection;
use Fal\Stick\Library\Template\Template;
use Fal\Stick\Util;

class InstallController
{
    private $app;
    private $template;

    public function __construct(App $app, Template $template)
    {
        $this->app = $app;
        $this->template = $template;
    }

    public function home()
    {
        return $this->template->render('install/home.php', array(
            'complete' => $this->app->flash('SESSION.install_complete'),
            'file' => $this->app->get('SERVER.SCRIPT_FILENAME'),
        ));
    }

    public function install(BcryptPasswordEncoder $encoder)
    {
        $db = Env::get('dbpath');

        Util::delete($db);

        $options = array(
            'dsn' => 'sqlite:'.$db,
            'debug' => true,
            'commands' => file_get_contents($this->app->APP_DIR.'db/schema.sql'),
        );
        $db = new Connection($this->app, $options);
        $user = new User($this->app, $db);
        $user->fromArray(array(
            'fullname' => 'Admin',
            'username' => 'admin',
            'password' => $encoder->hash('admin'),
            'roles' => 'ROLE_ADMIN',
        ))->save();

        $config = new Config($this->app, $db);
        foreach ($config->defaultConfig() as $key => $val) {
            $config->fromArray(array(
                'name' => $key,
                'content' => $val,
            ))->save()->reset();
        }

        $this->app->set('SESSION.install_complete', true);

        return $this->app->reroute();
    }
}
