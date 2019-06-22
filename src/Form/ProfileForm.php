<?php

namespace App\Form;

use Fal\Stick\Form\Form;
use Fal\Stick\Util\Option;

class ProfileForm extends Form
{
    /**
     * {@inheritdoc}
     */
    protected function build(Option $option)
    {
        $this
            ->add('fullname', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->add('username', 'text', array(
                'constraints' => 'trim|required|unique:user,'.$this['id'],
            ))
            ->add('new_password', 'password', array(
                'constraints' => 'trim|optional|min:5',
            ))
            ->add('old_password', 'password', array(
                'constraints' => 'trim|required|password',
            ))
        ;
    }
}
