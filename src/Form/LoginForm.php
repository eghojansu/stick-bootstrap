<?php

namespace App\Form;

use Fal\Stick\Web\Form\Form;

class LoginForm extends Form
{
    /**
     * {@inheritdoc}
     */
    protected function build(array $options, array $data)
    {
        $this->formBuilder->setOptions(array(
            'left' => 'col-sm-4',
            'right' => 'col-sm-8',
            'offset' => 'col-sm-offset-4',
        ));

        $this
            ->addField('username', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->addField('password', 'password', array(
                'constraints' => 'trim|required',
            ))
            ->addButton('login', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-primary',
                ),
            ))
            ->addButton('cancel', 'link', array(
                'attr' => array(
                    'href' => $options['home'],
                ),
            ))
        ;
    }
}
