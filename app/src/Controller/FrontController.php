<?php

namespace App\Controller;

use App\Form\LoginForm;

class FrontController extends Controller
{
    public function home()
    {
        return $this->render('front/home');
    }

    public function login(LoginForm $form)
    {
        $message = null;

        if ($form->posted() && $this->auth->attempt($form->username, $form->password, null, $message)) {
            return $this->notify('Login success.', 'dashboard');
        }

        return $this->render('front/login', compact('form', 'message'));
    }
}
