<?php

namespace App\Controller;

use Fal\Stick\Fw;

class FrontController
{
    public function home(Fw $fw)
    {
        return $fw->template->render('front.home');
    }

    public function login(Fw $fw)
    {
        if ($fw->auth->login($fw->isVerb('post'))) {
            return $fw->reroute('dashboard');
        }

        return $fw->template->render('front.login', array(
            'message' => $fw->auth->error(),
        ));
    }

    public function logout(Fw $fw)
    {
        $fw->auth->logout();

        return $fw->rem('SESSION')->reroute('home');
    }
}
