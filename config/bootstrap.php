<?php

require __DIR__.'/../vendor/autoload.php';

return Fal\Stick\Fw::createFromGlobals(array(
    'config_dir' => __DIR__,
    'project_dir' => dirname(__DIR__),
    'temp_dir' => dirname(__DIR__).'/var',
))->config(__DIR__.'/config.ini', true);
