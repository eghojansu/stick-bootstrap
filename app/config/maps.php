<?php

return array(
    array('App\\Controller\\FrontController', array(
        'GET home /' => 'home',
        'GET|POST login /login' => 'login',
    )),
    array('App\\Controller\\DashboardController', array(
        'GET dashboard /dashboard' => 'home',
        'GET|POST profile /dashboard/profile' => 'profile',
        'GET|POST users /dashboard/user/*' => 'user',
    )),
);
