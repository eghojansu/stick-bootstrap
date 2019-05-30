<?php

namespace App\Form;

use App\Data;
use Fal\Stick\Form\Form;
use Fal\Stick\Util\Option;

class UserForm extends Form
{
    /**
     * {@inheritdoc}
     */
    protected function build(Option $options)
    {
        $this
            ->add('fullname', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->add('username', 'text', array(
                'constraints' => 'trim|required|unique:user,username,'.$this['id'],
            ))
            ->add('password', 'password', array(
                'constraints' => $this['id'] ? null : 'required',
            ))
            ->add('roles', 'choice', array(
                'constraints' => 'required',
                'items' => Data::ROLES,
                'expanded' => true,
                'multiple' => true,
                'transformer' => function ($val) {
                    return is_array($val) ? $val : explode(',', (string) $val);
                },
                'reverse_transformer' => function ($val) {
                    return implode(',', (array) $val);
                },
            ))
            ->add('active', 'choice', array(
                'items' => Data::YES,
                'expanded' => true,
                'constraints' => 'required',
            ))
        ;
    }
}
