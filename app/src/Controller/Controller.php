<?php

namespace App\Controller;

use Fal\Stick\Fw;
use Fal\Stick\Security\Auth;
use Fal\Stick\Template\Template;

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
        // do children boot logic
    }

    protected function notify($message, $target = null, string $type = 'success')
    {
        $this->fw['SESSION']['alerts'][$type] = $message;

        return $this->fw->reroute($target);
    }

    protected function render(string $template, array $context = null, string $mime = 'text/html')
    {
        $this->fw['MIME'] = $mime;

        return $this->fw->service(Template::class)->render($template, $context);
    }
}
