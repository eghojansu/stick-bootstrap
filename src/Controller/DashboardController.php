<?php

namespace App\Controller;

use App\App;
use App\Form\ProfileForm;

class DashboardController
{
    public function home(App $app)
    {
        return $app->render('dashboard/home');
    }

    public function profile(App $app, ProfileForm $form)
    {
        $form->handle($app->currentRequest, $app->user->toArray());

        if ($form->isSubmitted() && $form->valid()) {
            $data = $form->getValidatedData();

            if ($data['new_password']) {
                $data['password'] = $app->auth->getEncoder()->hash($data['new_password']);
            }

            $app->user->fromArray($data)->save();

            return $app->success('Profile has been updated.');
        }

        return $app->render('dashboard/form', array(
            'title' => 'Profile',
            'form' => $form,
        ));
    }

    public function users(App $app)
    {
        return $app->crud
            ->mapper('App\\Mapper\\User')
            ->form('App\\Form\\UserForm')
            ->searchable('fullname ~, |username ~')
            ->field('listing,view,delete', 'fullname,username,roles,active')
            ->filters(array(
                'id <>' => $app->user['id'],
            ))
            ->onBeforeCreate(function ($crud) use ($app) {
                return array(
                    'password' => $app->auth->getEncoder()->hash($crud->form['password']),
                );
            })
            ->onBeforeUpdate(function ($crud) use ($app) {
                if ($password = $crud->form['password']) {
                    $password = $app->auth->getEncoder()->hash($password);
                } else {
                    $password = $crud->mapper['password'];
                }

                return compact('password');
            })
            ->render()
        ;
    }
}
