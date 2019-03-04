<?php

namespace App\Controller;

use App\Form\ProfileForm;
use Fal\Stick\Web\Helper\Crud;
use Fal\Stick\Web\Request;

class DashboardController
{
    public function home(App $app)
    {
        return $app->render('dashboard/home');
    }

    public function profile(App $app, ProfileForm $form, Request $request)
    {
        $form->handle($request, $app->user->toArray(), array(
            'dashboard' => $app->path('dashboard'),
        ));

        if ($form->isSubmitted() && $form->valid()) {
            $data = $form->getValidatedData();

            if ($data['new_password']) {
                $data['password'] = $app->auth->getEncoder()->hash($data['new_password']);
            }

            $app->user->fromArray($data)->save();

            return $app->success('Profile has been updated.');
        }

        return $app->render('dashboard/profile', compact('form'));
    }

    public function users(App $app, Crud $crud)
    {
        return $crud
            ->mapper('App\\Mapper\\User')
            ->form('App\\Form\\UserForm')
            ->searchable('fullname ~, |username ~')
            ->field('listing,view,delete', 'fullname,username,roles,active')
            ->filters(array(
                'id <>' => $app->user['id'],
            ))
            ->beforeCreate(function () use ($app, $crud) {
                return array(
                    'password' => $app->auth->getEncoder()->hash($crud->form['password']),
                );
            })
            ->beforeUpdate(function () use ($app, $crud) {
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
