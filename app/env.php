<?php

$config = is_file(__DIR__.'/config.dist.php') ? require __DIR__.'/config.dist.php' : array();

if (is_file(__DIR__.'/config.php')) {
    $config = array_replace_recursive($config, require __DIR__.'/config.php');
}

return array(
    'APP_DIR' => __DIR__.'/',
    'DB_DSN' => $config['db']['dsn'] ?? null,
    'DB_USERNAME' => $config['db']['username'] ?? null,
    'DB_PASSWORD' => $config['db']['password'] ?? null,
    'CACHE' => $config['cache'] ?? null,
    'DEBUG' => $config['debug'] ?? false,
    'LOG' => $config['log'] ?? null,
    'THRESHOLD' => $config['threshold'] ?? 'error',
    'TEMP' => $config['temp'] ?? dirname(__DIR__).'/var/',
    'controllers' => require __DIR__.'/controllers.php',
    'events' => require __DIR__.'/events.php',
    // 'routes' => require __DIR__.'/routes.php',
    'rules' => require __DIR__.'/services.php',
);
