<?php

use App\Controller\DashboardController;
use App\Controller\HomeController;
use App\Controller\Master\UserController;

return [
    'groups' => [
        [['prefix' => '/', 'class' => HomeController::class, 'mode' => 'sync'], function ($app) {
            $app->route('GET home /', 'home');
            $app->route('GET login login', 'login');
            $app->route('POST login', 'loginCheck');
            $app->route('GET logout logout', 'logout');
        }],
        [['prefix' => '/dashboard', 'class' => DashboardController::class], function ($app) {
            $app->route('GET dashboard /', 'dashboard');
            $app->route('GET profile /profile', 'profile');
            $app->route('POST profile', 'profileUpdate');

            $app->group(['prefix' => '/user', 'name' => 'user_', 'class' => UserController::class], function ($app) {
                $app->route('GET index /', 'index');
                $app->route('GET create /create', 'create');
                $app->route('POST user_create', 'createCommit');
                $app->route('GET edit /edit/{user}', 'edit');
                $app->route('POST user_edit', 'editCommit');
                $app->route('DELETE delete /delete/{user} ajax', 'delete');
            });
        }],
    ],
];
