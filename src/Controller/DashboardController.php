<?php

namespace App\Controller;

use Fal\Stick\Fw;

class DashboardController
{
    public function home(Fw $fw)
    {
        return $fw->template->render('dashboard.home');
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

            return $fw->app->alertSuccess('Profile has been updated.');
        }

        return $fw->template->render('dashboard.profile', array(
            'form' => $form,
        ));
    }

    public function users(Fw $fw)
    {
        $fw->auth->denyAccessUnlessGranted('ROLE_ADMIN');

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

    public function setting(Fw $fw)
    {
        $fw->auth->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $fw->form('Setting', $fw->store->all());

        if ($form->isSubmitted() && $form->valid()) {
            $fw->store->merge($form->getValidatedData())->commit();

            return $fw->app->alertSuccess('Setting has been updated.');
        }

        return $fw->template->render('dashboard.setting', array(
            'form' => $form,
        ));
    }

    public function maintenance(Fw $fw)
    {
        $fw->auth->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $fw->form('Maintenance', array(
            'long' => 1,
            'for' => null,
            'message' => $fw->store->maintenance_message,
        ));

        if ($form->isSubmitted() && $form->valid()) {
            $add = $form['long'].' '.$form['for'];

            if ($timestamp = strtotime($add)) {
                $fw->store->merge(array(
                    'maintenance' => date('Y-m-d H:i:s', $timestamp),
                    'maintenance_message' => $form['message'],
                ))->commit();

                return $fw->app->alertSuccess('Maintenance has been updated.');
            }

            return $fw->app->alertDanger('Invalid maintenance definition.');
        }

        return $fw->template->render('dashboard.maintenance', array(
            'form' => $form,
        ));
    }
}
