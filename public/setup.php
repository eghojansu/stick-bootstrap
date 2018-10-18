<?php

$root = dirname(__DIR__).'/';

require $root.'vendor/autoload.php';

Fal\Stick\Library\Env::load($root.'.env.dist', $root.'.env');
Fal\Stick\Fw::create()->config($root.'app/config/setup.php')->run();
