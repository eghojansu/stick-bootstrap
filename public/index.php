<?php

require __DIR__.'/../vendor/autoload.php';

Fal\Stick\Library\Env::load(array(
    __DIR__.'/../.env.php.dist',
    __DIR__.'/../.env.php',
));
Fal\Stick\App::createFromGlobals()
    ->config(__DIR__.'/../app/config/web.php')
    ->run()
;
