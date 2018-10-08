<?php

return array(
    array('App\\Controller\\FrontController', array(
        'GET home /' => 'home',
        'GET article /article/@slug' => 'article',
        'GET page /page/@page' => 'page',
        'GET sitemap /sitemap' => 'sitemap',
        'GET|POST contact /contact' => 'contact',
        'GET|POST login /login' => 'login',
        'GET logout /logout' => 'logout',
    )),
    array('App\\Controller\\DashboardController', array(
        'GET dashboard /dashboard' => 'home',
        'GET|POST profile /dashboard/profile' => 'profile',
        'GET|POST mpost /dashboard/post/*' => 'post',
        'GET|POST muser /dashboard/user/*' => 'user',
    )),
    array('App\\Controller\\PageController', array(
        'GET mpage /dashboard/page' => 'home',
        'GET|POST mpage_create /dashboard/page/create' => 'create',
        'GET|POST mpage_update /dashboard/page/@article/update' => 'update',
        'GET mpage_delete /dashboard/page/@article/delete' => 'delete',
    )),
);
