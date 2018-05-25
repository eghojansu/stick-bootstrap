<?php

use App\Test\Tools\Context;

require dirname(__DIR__).'/vendor/autoload.php';

$tmp = dirname(__DIR__).'/var/test/';

Context::instance([
    'root' => __DIR__.'/',
    'app' => require(dirname(__DIR__).'/app/bootstrap.php'),
    'scriptPath' => dirname(__DIR__).'/app/db/',
    'fixture' => __DIR__.'/fixture/',
    'temp' => $tmp,
]);

if (!is_dir($tmp)) {
    mkdir($tmp, 0755, true);
}
