<?php

namespace App\Controller\Master;

use App\Controller\Controller;
use App\Mapper\User;
use Fal\Stick\Security\Auth;
use Fal\Stick\Validation\Validator;

class UserController extends Controller
{
    public function index(User $user, Auth $auth)
    {
        $keyword = $_GET['keyword'] ?? null;

        return $this->_dashboard('master/user/index', [
            'success' => $this->app->flash('SESSION.success'),
            'keyword' => $keyword,
            'users' => $user->page($_GET['page'] ?? 1, $keyword, $auth->getUser()->getId()),
        ]);
    }

    public function create()
    {
        return $this->_dashboard('master/user/form', [
            'error' => $this->app->flash('SESSION.error'),
            'data' => $this->app->flash('SESSION.data') ?? [],
        ]);
    }

    public function createCommit(Validator $validator, Auth $auth, User $user)
    {
        $valid = $validator->validate($_POST, [
            'username' => 'trim|required|lenmin:6|unique:user,username',
            'fullname' => 'trim|required',
            'password' => 'trim|required|lenmin:6',
        ]);

        if ($valid['error']) {
            $this->app->set('SESSION.error', $valid['error']);
            $this->app->set('SESSION.data', $_POST);

            return $this->app->reroute('user_create');
        }

        $data = $valid['data'];
        unset($data['password']);

        if ($valid['data']['password']) {
            $data['password'] = $auth->getEncoder()->hash($valid['data']['password']);
        }

        $user->on('insert', function ($user) use ($data) {
            $user['profile']->fromArray($data)->save();
        })->fromArray($data)->insert();

        $this->app->set('SESSION.success', 'New user has been created.');

        $this->app->reroute('user_index');
    }

    public function edit(User $user)
    {
        return $this->_dashboard('master/user/form', [
            'error' => $this->app->flash('SESSION.error'),
            'data' => $this->app->flash('SESSION.data') ?? ($user->toArray() + $user['profile']->toArray()),
        ]);
    }

    public function editCommit(Validator $validator, Auth $auth, User $user)
    {
        $valid = $validator->validate($_POST, [
            'username' => 'trim|required|lenmin:6|unique:user,username,id,'.$user->getId(),
            'fullname' => 'trim|required',
            'password' => 'trim|lenmin:6',
        ]);

        if ($valid['error']) {
            $this->app->set('SESSION.error', $valid['error']);
            $this->app->set('SESSION.data', $_POST);

            return $this->app->reroute(['user_edit', ['user' => $user->getId()]]);
        }

        $data = $valid['data'];
        unset($data['password']);

        if ($valid['data']['password']) {
            $data['password'] = $auth->getEncoder()->hash($valid['data']['password']);
        }

        $user->on('update', function ($user) use ($data) {
            $user['profile']->fromArray($data)->save();
        })->fromArray($data)->update();

        $this->app->set('SESSION.success', 'User has been updated.');

        $this->app->reroute('user_index');
    }

    public function delete(User $user)
    {
        $user->on('delete', function ($user) {
            $user['profile']->delete();
        })->delete();

        return [
            'success' => true,
            'message' => 'User has been deleted',
        ];
    }
}
