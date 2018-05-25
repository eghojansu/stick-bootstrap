<?php

namespace App\Controller;

use Fal\Stick\Security\Auth;
use Fal\Stick\Validation\Validator;

class HomeController extends Controller
{
    public function home()
    {
        return $this->_front('home/home');
    }

    public function login()
    {
        return $this->_render('home/login', [
            'attempt' => $this->app->flash('SESSION.attempt'),
        ]);
    }

    public function loginCheck(Validator $validator, Auth $auth)
    {
        $rules = [
            'username' => 'trim|required',
            'password' => 'trim|required',
        ];
        $valid = $validator->validate($_POST, $rules);

        if ($valid['error']) {
            $this->app->set('SESSION.attempt', [
                'error' => $valid['error'],
                'username' => $valid['data']['username'],
            ]);

            return $this->app->reroute();
        }

        if ($auth->attempt($valid['data']['username'], $valid['data']['password'], $message)) {
            return $this->app->reroute('dashboard');
        }

        $this->app->set('SESSION.attempt', [
            'message' => $message,
            'username' => $valid['data']['username'],
        ]);

        $this->app->reroute();
    }

    public function logout(Auth $auth)
    {
        $auth->logout();

        $this->app->reroute('home');
    }
}
