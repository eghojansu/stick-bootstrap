<?php

namespace App\Mapper;

use Fal\Stick\Library\Sql\Mapper;

class Config extends Mapper
{
    public static function defaults()
    {
        return array(
            'name' => 'App',
            'desc' => 'App',
            'alias' => 'App',
        );
    }

    public function all()
    {
        $config = self::defaults();

        foreach ($this->find(null, null, 60) as $item) {
            $config[$item['name']] = $item['content'];
        }

        return $config;
    }
}
