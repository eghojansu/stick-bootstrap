<?php

return array(
    'configs' => __DIR__.'/system.php',
    'rules' => require __DIR__.'/services.php',
    'maps' => array(
        array('App\\Controller\\SetupController', array(
            'GET  install / sync' => 'home',
            'POST install   sync' => 'install',
        )),
    ),
);
