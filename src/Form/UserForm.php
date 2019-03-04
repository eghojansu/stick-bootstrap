<?php

namespace App\Form;

use Fal\Stick\Web\Form\Form;

class UserForm extends Form
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
            ->addField('password', 'password', array(
                'constraints' => $id ? null : 'required',
            ))
            ->addField('roles', 'choice', array(
                'constraints' => 'required',
                'items' => array(
                    'Administrator' => 'Admin',
                    'Operator' => 'Operator',
                ),
                'expanded' => true,
                'multiple' => true,
                'transformer' => function ($val) {
                    return is_array($val) ? $val : explode(',', (string) $val);
                },
                'reverse_transformer' => function ($val) {
                    return implode(',', (array) $val);
                },
            ))
            ->addField('active', 'checkbox', array(
                'attr' => array(
                    'value' => 1,
                ),
                'reverse_transformer' => function ($val) {
                    return $val ? '1' : '0';
                },
            ))
        ;
    }
}
