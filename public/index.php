<?php

require __DIR__.'/../vendor/autoload.php';

Fal\Stick\Fw::createFromGlobals()
    ->registerShutdownHandler()
    ->config(__DIR__.'/../app/env.php')
    ->run()
;
