<?php

namespace App\Controller;

use App\Form\LoginForm;
use App\Mapper\User;

class FrontController extends Controller
{
    public function home()
    {
        return $this->render('front/home.php');
    }

    public function login(LoginForm $form)
    {
        $message = null;

        if ($form->build()->isSubmitted() && $form->valid() &&
            $this->auth->attempt($form->username, $form->password, $message)) {

            return $this->fw->reroute('dashboard');
        }

        return $this->render('login.php', array(
            'form' => $form,
            'message' => $message,
        ));
    }
}
