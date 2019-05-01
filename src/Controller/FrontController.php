<?php

namespace App\Controller;

use Fal\Stick\Fw;

class FrontController
{
    public function home(Fw $fw)
    {
        return $fw->template->render('front/home.html');
    }

    public function login(Fw $fw)
    {
        if ($fw->auth->login($fw->isMethod('post'))) {
            return $fw->reroute('dashboard');
        }

        return $fw->template->render('front/login.html', array(
            'message' => $fw->auth->error(),
        ));
    }

    public function logout(Fw $fw)
    {
        $fw->auth->logout();
        $fw->rem('SESSION');

        return $fw->reroute('home');
    }
}
