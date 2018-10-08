<?php

namespace App\Controller;

use Fal\Stick\App;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Template\Template;

abstract class Controller
{
    protected $app;
    protected $auth;
    protected $user;

    public function __construct(App $app, Auth $auth)
    {
        $this->app = $app;
        $this->auth = $auth;
        $this->user = $auth->getUser();
        $this->boot();
    }

    protected function boot()
    {
        // to be overriden by children.
    }

    protected function get($serviceId)
    {
        return $this->app->service($serviceId);
    }

    protected function notify($message, $target = null, $type = 'success')
    {
        return $this->app
            ->set('SESSION.alerts.'.$type, $message)
            ->reroute($target)
        ;
    }

    protected function render($view, array $data = null)
    {
        return $this->get(Template::class)->render($view, $data);
    }
}
