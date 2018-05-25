<?php

if ('cli' !== PHP_SAPI) {
    echo 'Please run via console';

    exit;
}

require dirname(__DIR__).'/vendor/autoload.php';

(new App\Setup(require __DIR__.'/bootstrap.php', [
    __DIR__.'/db/100-create.sql',
], true))->execute();
