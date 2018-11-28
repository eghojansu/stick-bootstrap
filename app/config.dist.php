<?php

return array(
    'db' => array(
        'dsn' => 'sqlite:'.dirname(__DIR__).'/var/app.db',
    ),
    'cache' => 'fallback',
    'debug' => false,
    'log' => dirname(__DIR__).'/var/log/',
    'threshold' => 'error',
    'temp' => dirname(__DIR__).'/var/',
);
