<?php

namespace App\EventListener;

use App\Mapper\Config;
use Fal\Stick\App;

class TemplateRenderListener
{
    public function beforeRender(App $app, Config $config, $file, $data)
    {
        $data['app'] = $config->all();
        $app->cut('SESSION.alerts', 'alerts');

        return array(null, $data);
    }
}
