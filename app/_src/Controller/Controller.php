<?php

namespace App\Controller;

use Fal\Stick\Fw;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Template\Template;

abstract class Controller
{
    protected $fw;
    protected $auth;
    protected $user;

    public function __construct(Fw $fw, Auth $auth)
    {
        $this->fw = $fw;
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
        return $this->fw->service($serviceId);
    }

    protected function notify($message, $target = null, $type = 'success')
    {
        return $this->fw
            ->set('SESSION.alerts.'.$type, $message)
            ->reroute($target)
        ;
    }

    protected function render($view, array $data = null)
    {
        return $this->get(Template::class)->render($view, $data);
    }
}
