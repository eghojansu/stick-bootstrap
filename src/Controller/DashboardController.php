<?php

namespace App\Controller;

use App\Form\ProfileForm;
use Fal\Stick\Fw;

class DashboardController
{
    public function home(Fw $fw)
    {
        return $fw->template->render('dashboard/home.html');
    }

    public function profile(Fw $fw)
    {
        $form = $fw->form('Profile', $fw->user->toArray());

        if ($form->isSubmitted() && $form->valid()) {
            $data = $form->getValidatedData();

            if ($data['new_password']) {
                $data['password'] = $fw->auth->encoder->hash($data['new_password']);
            }

            $fw->user->fromArray($data)->save();

            return $fw->app->success('Profile has been updated.');
        }

        return $fw->template->render('dashboard/profile.html', array(
            'form' => $form,
        ));
    }

    public function users(Fw $fw)
    {
        return $fw->crud
            ->mapper($fw->mapper('User'))
            ->form($fw->form('User'))
            ->searchable('fullname ~, |username ~')
            ->field('listing,view,delete', 'fullname,username,roles,active')
            ->filters(array(
                'id <>' => $fw->user->id,
            ))
            ->onBeforeCreate(function ($crud) {
                return array(
                    'roles' => $crud->form['roles'] ?? 'ROLE_ADMIN',
                    'password' => $crud->auth->encoder->hash($crud->form['password']),
                );
            })
            ->onBeforeUpdate(function ($crud) {
                if ($password = $crud->form['password']) {
                    $password = $crud->auth->encoder->hash($password);
                } else {
                    $password = $crud->mapper['password'];
                }

                return compact('password');
            })
            ->render()
        ;
    }
}
