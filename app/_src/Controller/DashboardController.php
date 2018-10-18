<?php

namespace App\Controller;

use App\Form\ProfileForm;
use App\Form\UserForm;
use App\Mapper\User;
use Fal\Stick\Library\Crud\Crud;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Web;

class DashboardController extends Controller
{
    public function home()
    {
        return $this->render('dashboard/home.php');
    }

    public function profile(ProfileForm $form)
    {
        $form->build(array(
            'user_id' => $this->user->id,
        ), $this->user->toArray());

        if ($form->isSubmitted() && $form->valid()) {
            $data = $form->getData();

            if ($data['new_password']) {
                $data['password'] = $this->auth->getEncoder()->hash($data['new_password']);
            }

            $this->user->fromArray($data)->save();

            return $this->notify('Profile has been updated.');
        }

        return $this->render('dashboard/profile.php', array(
            'form' => $form,
        ));
    }

    public function user(Crud $crud, ...$segments)
    {
        return $crud
            ->segments($segments)
            ->mapper(User::class)
            ->form(UserForm::class)
            ->formOptions(function(Crud $crud) use ($segments) {
                return array(
                    'mode' => reset($segments),
                    'user_id' => $crud->mapper()->id,
                );
            })
            ->searchable('username ~')
            ->fields('listing,view,delete', 'fullname,username,roles,active')
            ->filters(array(
                'id <>' => $this->user->id,
            ))
            ->beforeCreate(function(Crud $crud, Auth $auth) {
                $form = $crud->form();

                return array(
                    'password' => $auth->getEncoder()->hash($form->password),
                    'roles' => implode(',', $form->roles),
                );
            })
            ->beforeUpdate(function(Crud $crud, Auth $auth) {
                $form = $crud->form();

                return array(
                    'password' => $form->password ? $auth->getEncoder()->hash($form->password) : $crud->mapper()->password,
                    'roles' => implode(',', $form->roles),
                );
            })
            ->onPrepareData(function(Crud $crud) {
                return array(
                    'roles' => explode(',', $crud->mapper()->roles),
                );
            })
            ->render()
        ;
    }
}
