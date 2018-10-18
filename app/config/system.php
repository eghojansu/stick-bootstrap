<?php

use Fal\Stick\Library\Env as e;

return array(
    'APP_DIR' => dirname(__DIR__).'/',
    'DB_OPTIONS' => array(
        'debug' => e::get('debug', false),
        'dsn' => sprintf('sqlite:%s', e::get('db_path')),
    ),
    'DB_PATH' => e::get('db_path'),
    'CACHE' => e::get('cache', null),
    'DEBUG' => e::get('debug', false),
    'LOG' => e::get('log', null),
    'LOCALES' => array(dirname(__DIR__).'/dict/'),
    'THRESHOLD' => e::get('threshold', 'error'),
    'TEMP' => e::get('temp', './var/'),
);
