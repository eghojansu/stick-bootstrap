<?php

namespace App\EventListener;

use Fal\Stick\Library\Sql\Mapper;

class MapperListener
{
    public static function events()
    {
        return array(
            array(Mapper::EVENT_BEFORE_INSERT, self::class.'->onBeforeInsert'),
            array(Mapper::EVENT_BEFORE_UPDATE, self::class.'->onBeforeUpdate'),
        );
    }

    public function onBeforeInsert(Mapper $mapper)
    {
        if ($mapper->exists('created_at')) {
            $mapper->set('created_at', date('Y-m-d H:i:s'));
        }
    }

    public function onBeforeUpdate(Mapper $mapper)
    {
        if ($mapper->exists('updated_at')) {
            $mapper->set('updated_at', date('Y-m-d H:i:s'));
        }
    }
}
