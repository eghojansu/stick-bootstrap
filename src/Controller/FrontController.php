<?php

namespace App\Controller;

use App\Form\LoginForm;
use Fal\Stick\Web\Request;

class FrontController
{
    public function home(App $app)
    {
        return $app->render('front/home');
    }

    public function login(App $app, LoginForm $form, Request $request)
    {
        $message = null;

        $form->handle($request, null, array(
            'home' => $app->path('home'),
        ));

        if ($form->isSubmitted() && $form->valid() && $app->auth->attempt($form['username'], $form['password'], false, $message)) {
            return $app->success('Login success.', 'dashboard');
        }

        return $app->render('front/login', compact('form', 'message'));
    }
}
