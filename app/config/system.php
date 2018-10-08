<?php

use Fal\Stick\Library\Env;

$tmp = Env::get('temp', './var/');

return array(
    'APP_DIR' => dirname(__DIR__).'/',
    'DEBUG' => Env::get('debug', false),
    'LOG' => Env::get('log', $tmp.'logs/'),
    'TEMP' => $tmp,
    'CACHE' => Env::get('cache', 'auto'),
    'THRESHOLD' => Env::get('threshold', Fal\Stick\App::LOG_LEVEL_ERROR),
    'LOCALES' => dirname(__DIR__).'/dict/',
);
