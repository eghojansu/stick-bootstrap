<?php

namespace App\Form;

use Fal\Stick\Html\Twbs3Form;

class LoginForm extends Twbs3Form
{
    /**
     * {@inheritdoc}
     */
    protected function build(array $options)
    {
        $this
            ->setOptions(array(
                'left' => 'col-sm-4',
                'right' => 'col-sm-8',
                'offset' => 'col-sm-offset-4',
            ))
            ->add('username', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->add('password', 'password', array(
                'constraints' => 'trim|required',
            ))
            ->addButton('login', 'submit', null, array(
                'class' => 'btn btn-primary',
            ))
            ->addButton('cancel', 'link', null, array(
                'href' => $this->_fw->path('home'),
            ))
        ;
    }
}
