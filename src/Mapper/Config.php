<?php

declare(strict_types=1);

namespace App\Mapper;

use Fal\Stick\Sql\Mapper;

class Config extends Mapper
{
    public static function defaultConfig(): array
    {
        return [
            ['name' => 'name', 'content' => 'App'],
            ['name' => 'desc', 'content' => 'App'],
            ['name' => 'alias', 'content' => 'App'],
        ];
    }

    public function getConfig(): array
    {
        $config = self::defaultConfig();

        foreach ($this->findAll(null, null, 60) as $item) {
            $config[$item['name']] = $item['content'];
        }

        return $config;
    }
}
