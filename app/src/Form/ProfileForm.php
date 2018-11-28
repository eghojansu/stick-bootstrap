<?php

namespace App\Form;

use Fal\Stick\Html\Twbs3Form;

class ProfileForm extends Twbs3Form
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
            ->add('new_password', 'password', array(
                'constraints' => 'trim|lenMin:5',
            ))
            ->add('old_password', 'password', array(
                'constraints' => 'trim|required|password',
            ))
            ->addButton('update', 'submit', null, array(
                'class' => 'btn btn-primary',
            ))
            ->addButton('cancel', 'a', null, array(
                'href' => $this->_fw->path('dashboard'),
            ))
        ;
    }
}
