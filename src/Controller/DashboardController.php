<?php

namespace App\Controller;

use Fal\Stick\Security\Auth;
use Fal\Stick\Validation\Validator;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return $this->_dashboard('dashboard/index');
    }

    public function profile()
    {
        return $this->_dashboard('dashboard/profile', [
            'success' => $this->app->flash('SESSION.success'),
            'error' => $this->app->flash('SESSION.error'),
        ]);
    }

    public function profileUpdate(Auth $auth, Validator $validator)
    {
        $user = $auth->getUser();
        $valid = $validator->validate($_POST, [
            'username' => 'trim|required|lenmin:6|unique:user,username,id,'.$user->getId(),
            'fullname' => 'trim|required',
            'new_password' => 'trim|lenmin:6',
            'password' => 'trim|required|password',
        ]);

        if ($valid['error']) {
            $this->app->set('SESSION.error', $valid['error']);

            return $this->app->reroute();
        }

        $data = $valid['data'];
        unset($data['new_password'], $data['password']);

        if ($valid['data']['new_password']) {
            $data['password'] = $auth->getEncoder()->hash($valid['data']['new_password']);
        }

        $user->on('update', function ($user) use ($data) {
            $user['profile']->fromArray($data)->save();
        })->fromArray($data)->update();

        $this->app->set('SESSION.success', 'Your profile has been updated.');

        return $this->app->reroute();
    }
}
