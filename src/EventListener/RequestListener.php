<?php

declare(strict_types=1);

namespace App\EventListener;

use Fal\Stick\Web\Event\GetResponseEvent;
use Fal\Stick\Web\Security\Auth;

class RequestListener
{
    public function handle(GetResponseEvent $event, Auth $auth)
    {
        if ($response = $auth->guard($event->getRequest())) {
            $event->setResponse($response);
        }
    }
}
