<?php

namespace App\Form;

use Fal\Stick\Library\Html\Twbs3Form;

class LoginForm extends Twbs3Form
{
    /**
     * {@inheritdoc}
     */
    protected function doBuild(array $options)
    {
        $this
            ->setLeftColClass('col-sm-4')
            ->setRightColClass('col-sm-8')
            ->setRightOffsetColClass('col-sm-offset-4')
            ->add('username', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->add('password', 'password', array(
                'constraints' => 'trim|required',
            ))
            ->addButton('login', 'submit', null, array(
                'class' => 'btn btn-primary',
            ))
            ->addButton('cancel', 'a', null, array(
                'href' => $this->_fw->path('home'),
            ))
        ;
    }
}
