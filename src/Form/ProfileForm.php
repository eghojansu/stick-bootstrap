<?php

namespace App\Form;

use Fal\Stick\Web\Form\Form;

class ProfileForm extends Form
{
    /**
     * {@inheritdoc}
     */
    protected function build(array $options, array $data)
    {
        $id = $data['id'] ?? null;

        $this
            ->addField('fullname', 'text', array(
                'constraints' => 'trim|required',
            ))
            ->addField('username', 'text', array(
                'constraints' => 'trim|required|unique:user,username,id,'.$id,
            ))
            ->addField('new_password', 'password', array(
                'constraints' => 'trim|lenMin:5',
            ))
            ->addField('old_password', 'password', array(
                'constraints' => 'trim|required|password',
            ))
        ;
    }
}
