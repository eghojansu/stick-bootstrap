<?php

namespace App\Mapper;

use Fal\Stick\Library\Sql\Mapper;

class Config extends Mapper
{
    public static function defaultConfig()
    {
        return array(
            'name' => 'App',
            'desc' => 'App',
            'alias' => 'App',
        );
    }

    public function all()
    {
        $config = self::defaultConfig();

        foreach ($this->find(null, null, 60) as $item) {
            $config[$item['name']] = $item['content'];
        }

        return $config;
    }
}
