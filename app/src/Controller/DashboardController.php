<?php

namespace App\Controller;

use App\Form\ProfileForm;
use Fal\Stick\Security\Auth;
use Fal\Stick\Util\Crud;

class DashboardController extends Controller
{
    public function home()
    {
        return $this->render('dashboard/home');
    }

    public function profile(ProfileForm $form)
    {
        if ($form->posted(null, $this->user->toArray())) {
            $data = $form->getData();

            if ($data['new_password']) {
                $data['password'] = $this->auth->getEncoder()->hash($data['new_password']);
            }

            $this->user->fromArray($data)->save();

            return $this->notify('Profile has been updated.');
        }

        return $this->render('dashboard/profile', compact('form'));
    }

    public function users(Crud $crud, ...$segments)
    {
        return $crud
            ->segments($segments)
            ->mapper('App\\Mapper\\User')
            ->form('App\\Form\\UserForm')
            ->searchable('fullname ~, |username ~')
            ->field('listing,view,delete', 'fullname,username,roles,active')
            ->filters(array(
                'id <>' => $this->user['id'],
            ))
            ->beforeCreate(function(Crud $crud, Auth $auth) {
                return array(
                    'password' => $auth->getEncoder()->hash($crud->form->password),
                );
            })
            ->beforeUpdate(function(Crud $crud, Auth $auth) {
                $password = $crud->form->password;

                return array(
                    'password' => $password ? $auth->getEncoder()->hash($password) : $crud->mapper['password'],
                );
            })
            ->render()
        ;
    }
}
