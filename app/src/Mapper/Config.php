<?php

namespace App\Mapper;

use Fal\Stick\Sql\Mapper;

class Config extends Mapper
{
    public static function defaults()
    {
        return array(
            'name' => 'App name',
            'desc' => 'App desc',
            'company' => 'Your company',
            'year' => 2018,
        );
    }

    public function all()
    {
        $config = self::defaults();

        foreach ($this->findAll(null, null, 60) as $item) {
            $config[$item['name']] = $item['content'];
        }

        return $config;
    }
}
