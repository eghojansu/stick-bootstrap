<?php

namespace App\Form;

use Fal\Stick\Library\Html\Twbs3Form;

class ArticleForm extends Twbs3Form
{
    /**
     * {@inheritdoc}
     */
    protected function doBuild(array $options)
    {
        $this
            ->add('title', 'text', array(
                'constraints' => 'required',
            ))
            ->add('content', 'textarea', array(
                'constraints' => 'required',
            ))
        ;
    }
}
