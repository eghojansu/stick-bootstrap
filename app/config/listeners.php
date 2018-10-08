<?php

use Fal\Stick\App;
use Fal\Stick\Library\Template\Template;

return array(
    array(App::EVENT_PREROUTE, 'App\\EventListener\\RouteListener->preRoute'),
    array(App::EVENT_CONTROLLER_ARGS, 'App\\EventListener\\RouteListener->resolveArgs'),
    array(App::EVENT_ERROR, 'App\\EventListener\\ErrorListener->handle'),
    array(Template::EVENT_BEFORE_RENDER, 'App\\EventListener\\TemplateRenderListener->beforeRender'),
);
