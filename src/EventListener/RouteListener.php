<?php

namespace App\EventListener;

use Fal\Stick\App;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Sql\Connection;
use Fal\Stick\Library\Sql\MapperParameterConverter;

class RouteListener
{
    public function preRoute(Auth $auth)
    {
        return $auth->guard();
    }

    public function resolveArgs(App $app, Connection $db, $controller, $args)
    {
        $converter = new MapperParameterConverter($app, $db, $controller, $args);

        if ($converter->hasMapper()) {
            return $converter->resolve();
        }
    }
}
