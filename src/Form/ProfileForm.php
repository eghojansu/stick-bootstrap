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
            ->set('fullname', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->set('username', 'text', array(
                'constraints' => 'trim|required|unique:user,username,id,'.$this['id'],
            ))
            ->set('new_password', 'password', array(
                'constraints' => 'trim|lenMin:5',
            ))
            ->set('old_password', 'password', array(
                'constraints' => 'trim|required|password',
            ))
        ;
    }
}
