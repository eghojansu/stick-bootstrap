<?php

declare(strict_types=1);

namespace App\EventListener;

use Fal\Stick\Database\ParameterConverter;
use Fal\Stick\Web\Event\FilterControllerArgumentsEvent;

class ControllerArgumentsListener
{
    public function handle(FilterControllerArgumentsEvent $event, ParameterConverter $converter)
    {
        if ($arguments = $event->getArguments()) {
            $event->setArguments($converter->resolve($event->getController(), $arguments));
        }
    }
}
