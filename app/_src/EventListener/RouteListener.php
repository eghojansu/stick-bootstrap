<?php

namespace App\EventListener;

use Fal\Stick\Fw;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Sql\Connection;
use Fal\Stick\Library\Sql\MapperParameterConverter;

class RouteListener
{
    public static function events()
    {
        return array(
            array(Fw::EVENT_PREROUTE, self::class.'->onPreRoute'),
            array(Fw::EVENT_CONTROLLER_ARGS, self::class.'->onResolveArgs'),
        );
    }

    public function onPreRoute(Auth $auth)
    {
        return $auth->guard();
    }

    public function onResolveArgs(Fw $fw, Connection $db, $controller, $args)
    {
        $converter = new MapperParameterConverter($fw, $db, $controller, $args);

        if ($converter->hasMapper()) {
            return $converter->resolve();
        }
    }
}
