<?php

namespace App\Controller;

use App\App;
use App\Form\LoginForm;

class FrontController
{
    public function home(App $app)
    {
        return $app->render('front/home');
    }

    public function login(App $app, LoginForm $form)
    {
        $message = null;

        $form->handle($app->currentRequest, null, array(
            'home' => $app->path('home'),
        ));

        if ($form->isSubmitted() && $form->valid() && $app->auth->attempt($form['username'], $form['password'], false, $message)) {
            return $app->success('Login success.', 'dashboard');
        }

        return $app->render('front/login', compact('form', 'message'));
    }
}
