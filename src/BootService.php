<?php

declare(strict_types=1);

namespace App;

class BootService
{
    public function crud($crud)
    {
        $crud
            ->views(array(
                'listing' => 'crud/listing',
                'view' => 'crud/view',
                'create' => 'crud/form',
                'update' => 'crud/form',
                'delete' => 'crud/delete',
                'forbidden' => 'crud/forbidden',
            ))
            ->createNew(true)
        ;
    }
}
