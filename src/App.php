<?php

declare(strict_types=1);

namespace App;

use Fal\Stick\Container\ContainerInterface;
use Fal\Stick\Helper\ValueStore;
use Fal\Stick\Web\Response;
use Fal\Stick\Web\Security\Auth;

class App
{
    public $container;
    public $auth;
    public $user;
    public $store;

    public function __construct(ContainerInterface $container, Auth $auth, ValueStore $store)
    {
        $this->container = $container;
        $this->store = $store;
        $this->auth = $auth;
        $this->user = $auth->getUser();
    }

    public function __get($service)
    {
        return $this->container->get($service);
    }

    public function load(string $table)
    {
        return $this->container->get('Fal\\Stick\\Database\\Mapper', array(
            'name' => $table,
        ));
    }

    public function render(string $view, array $context = null)
    {
        return Response::create($this->container->get('template')->render($view, $context));
    }

    public function error(int $code = null, string $message = null)
    {
        $codes = array(
            403 => 'Fal\\Stick\\Web\\Exception\\ForbiddenException',
            404 => 'Fal\\Stick\\Web\\Exception\\NotFoundException',
        );

        if (isset($codes[$code])) {
            $exception = $codes[$code];
            $arguments = $message ? array($message) : array();
        } else {
            $exception = 'Fal\\Stick\\Web\\Exception\\HttpException';
            $arguments = array($message, $code ?? 500);
        }

        throw new $exception(...$arguments);
    }

    public function redirect($target = null)
    {
        return $this->container->get('urlGenerator')->redirect($target);
    }

    public function path($route, $parameters = null)
    {
        return $this->container->get('urlGenerator')->generate($route, $parameters);
    }

    public function asset($path)
    {
        return $this->container->get('urlGenerator')->asset('assets/'.$path);
    }

    public function notify(string $message, $target = null, string $alert = 'alerts_success')
    {
        $this->container->get('session')->set($alert, $message);

        return $this->container->get('urlGenerator')->redirect($target);
    }

    public function success(string $message, $target = null)
    {
        return $this->notify($message, $target);
    }

    public function danger(string $message, $target = null)
    {
        return $this->notify($message, $target, 'alerts_danger');
    }

    public function warning(string $message, $target = null)
    {
        return $this->notify($message, $target, 'alerts_warning');
    }

    public function info(string $message, $target = null)
    {
        return $this->notify($message, $target, 'alerts_info');
    }

    public function alerts(array $messages = null)
    {
        if (!$messages) {
            $session = $this->container->get('session');

            $messages = array(
                'success' => $session->flash('alerts_success'),
                'warning' => $session->flash('alerts_warning'),
                'danger' => $session->flash('alerts_danger'),
            );
        }

        $alerts = '';

        foreach (array_filter($messages) as $type => $message) {
            $alerts .= <<<ALERT
<div class="alert alert-$type alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  $message
</div>
ALERT;
        }

        return $alerts;
    }
}
