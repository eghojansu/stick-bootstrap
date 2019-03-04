<?php

require __DIR__.'/../vendor/autoload.php';

return array_replace_recursive(array(
    'config' => array(
        'config_dir' => __DIR__,
        'project_dir' => dirname(__DIR__),
        'tmp_dir' => dirname(__DIR__).'/var',
    ),
    'debug' => false,
    'env' => 'prod',
    'file' => array(
        'dev' => __DIR__.'/config.dev.ini',
        'prod' => __DIR__.'/config.ini',
        'test' => __DIR__.'/config.test.ini',
    ),
), is_file(__DIR__.'/../.env.php') ? require __DIR__.'/../.env.php' : array());
