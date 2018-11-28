<?php

namespace App\Form;

use Fal\Stick\Html\Twbs3Form;

class UserForm extends Twbs3Form
{
    /**
     * {@inheritdoc}
     */
    protected function build(array $options)
    {
        $this
            ->add('fullname', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->add('username', 'text', array(
                'constraints' => 'trim|required|unique:user,username,id,'.$this->id,
            ))
            ->add('password', 'password', array(
                'constraints' => $this->id ? null : 'required',
            ))
            ->add('roles', 'choice', array(
                'constraints' => 'required',
                'items' => array(
                    'Administrator' => 'Admin',
                    'Operator' => 'Operator',
                ),
                'expanded' => true,
                'multiple' => true,
                'transformer' => function($val) {
                    return explode(',', (string) $val);
                },
                'reverse_transformer' => function($val) {
                    return implode(',', (array) $val);
                },
            ))
            ->add('active', 'checkbox', null, array(
                'value' => 1,
            ))
        ;
    }
}
