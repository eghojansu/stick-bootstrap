<?php

namespace App\Form;

use Fal\Stick\Form\Form;
use Fal\Stick\Util\Option;

class SettingForm extends Form
{
    protected function build(Option $options)
    {
        $this
            ->add('name', 'text', array(
                'label' => 'Application Name',
                'constraints' => 'required',
            ))
            ->add('desc', 'text', array(
                'label' => 'Application Description',
                'constraints' => 'required',
            ))
            ->add('company', 'text', array(
                'label' => 'Company',
                'constraints' => 'required',
            ))
            ->add('year', 'text', array(
                'label' => 'Launch Year',
                'constraints' => 'required',
            ))
        ;
    }
}
