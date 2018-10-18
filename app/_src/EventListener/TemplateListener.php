<?php

namespace App\EventListener;

use App\Mapper\Config;
use Fal\Stick\Fw;
use Fal\Stick\Library\Template\Template;

class TemplateListener
{
    public static function events()
    {
        return array(
            array(Template::EVENT_BEFORE_RENDER, self::class.'->onBeforeRender'),
        );
    }

    public function onBeforeRender(Fw $app, Config $config, $file, $data)
    {
        $data['app'] = $config->all();
        $app->cut('SESSION.alerts', 'alerts');

        return array(null, $data);
    }
}
