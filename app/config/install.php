<?php

return array(
    'app_version' => 'v0.1.0-alpha',
    'configs' => __DIR__.'/system.php',
    'rules' => require __DIR__.'/services.php',
    'maps' => array(
        array('App\\Controller\\InstallController', array(
            'GET install / sync' => 'home',
            'POST install sync' => 'install',
        )),
    ),
);
