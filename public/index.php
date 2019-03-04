<?php

use Fal\Stick\Web\Kernel as Abcd; // -> it is just for fun

$config = require __DIR__.'/../config/bootstrap.php';

Abcd::create($config['env'], $config['debug'], $config['config'])
    ->config($config['file'][$config['env']], true)
    ->run();
