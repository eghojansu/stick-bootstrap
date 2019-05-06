<?php

namespace App;

use Fal\Stick\Fw;

class Listener
{
    public static function onBoot(Fw $fw)
    {
        $requestInstall = 0 === strpos($fw['PATH'], '/install');

        if ($fw->app->isInstalled()) {
            if ($fw->app->isMaintenance() && '/logout' !== $fw['PATH']) {
                $fw->status(503)->expire(0)->set('OUTPUT', $fw->template->render('maintenance.html'));

                return false;
            }

            if ($requestInstall) {
                $fw->reroute('home');

                return false;
            }

            return !$fw->auth->guard();
        }

        if (!$requestInstall) {
            $fw->reroute('install');

            return false;
        }
    }

    public static function onError(Fw $fw, $message)
    {
        if ($fw['AJAX']) {
            return false;
        }

        $fw->set('OUTPUT', $fw->template->render('error.html'));
    }
}
