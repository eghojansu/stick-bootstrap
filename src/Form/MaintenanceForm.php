<?php

namespace App\Form;

use App\Data;
use Fal\Stick\Form\Form;
use Fal\Stick\Util\Option;

class MaintenanceForm extends Form
{
    protected function build(Option $options)
    {
        $this
            ->add('for', 'choice', array(
                'label' => 'Maintenance For',
                'constraints' => 'required',
                'items' => Data::TIMES,
            ))
            ->add('long', 'text', array(
                'label' => 'Maintenace Time',
                'constraints' => 'required|integer|min:1',
            ))
            ->add('message', 'textarea', array(
                'label' => 'Message',
            ))
        ;
    }
}
