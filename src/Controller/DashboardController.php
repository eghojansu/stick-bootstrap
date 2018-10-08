<?php

namespace App\Controller;

use App\Form\ArticleForm;
use App\Form\ProfileForm;
use App\Form\UserForm;
use App\Mapper\Article;
use App\Mapper\User;
use Fal\Stick\Library\Crud;
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

    public function post(Crud $crud, ...$segments)
    {
        return $crud
            ->segments($segments)
            ->mapper(Article::class)
            ->form(ArticleForm::class)
            ->searchable('title')
            ->fields(array(
                'listing' => array(
                    'title' => null,
                    'content' => null,
                ),
            ))
            ->filters(array(
                'category' => Article::CAT_POST,
            ))
            ->beforeCreate(function(Crud $crud, Web $web) {
                return array(
                    'category' => Article::CAT_POST,
                    'author' => $this->user->id,
                    'slug' => $web->slug($crud->getForm()->title),
                    'created_at' => date('y-m-d H:i:s'),
                );
            })
            ->beforeUpdate(function() {
                return array(
                    'updated_at' => date('y-m-d H:i:s'),
                );
            })
            ->render()
        ;
    }

    public function user(Crud $crud, ...$segments)
    {
        $fields = array(
            'fullname' => null,
            'username' => null,
            'roles' => null,
            'active' => null,
        );

        return $crud
            ->segments($segments)
            ->mapper(User::class)
            ->form(UserForm::class)
            ->formOptions(function(Crud $crud) use ($segments) {
                return array(
                    'mode' => reset($segments),
                    'user_id' => $crud->getMapper()->id,
                );
            })
            ->searchable('username')
            ->fields(array(
                'listing' => $fields,
                'delete' => $fields,
            ))
            ->filters(array(
                'id <>' => $this->user->id,
            ))
            ->beforeCreate(function(Crud $crud, Auth $auth) {
                $form = $crud->getForm();

                return array(
                    'password' => $auth->getEncoder()->hash($form->password),
                    'roles' => implode(',', $form->roles),
                );
            })
            ->beforeUpdate(function(Crud $crud, Auth $auth) {
                $form = $crud->getForm();

                return array(
                    'password' => $form->password ? $auth->getEncoder()->hash($form->password) : $crud->getMapper()->password,
                    'roles' => implode(',', $form->roles),
                );
            })
            ->onPrepareData(function(Crud $crud) {
                return array(
                    'roles' => explode(',', $crud->getMapper()->roles),
                );
            })
            ->render()
        ;
    }
}
