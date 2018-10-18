<?php

declare(strict_types=1);

namespace App\Form;

use Fal\Stick\Library\Html\Twbs3Form;

class UserForm extends Twbs3Form
{
    /**
     * {@inheritdoc}
     */
    protected function doBuild(array $options)
    {
        $this
            ->add('fullname', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->add('username', 'text', array(
                'constraints' => 'trim|required|unique:user,username,id,'.$options['user_id'],
            ))
            ->add('password', 'password', array(
                'constraints' => $options['mode'] === 'create' ? 'required' : null,
            ))
            ->add('roles', 'choice', array(
                'items' => array(
                    'Administrator' => 'Admin',
                    'Operator' => 'Operator',
                ),
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('active', 'choice', array(
                'items' => array(
                    'Active' => 1,
                    'Not Active' => 0,
                ),
                'expanded' => true,
            ))
        ;
    }
}
