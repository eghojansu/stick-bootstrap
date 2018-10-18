<?php

return array_merge(...array(
    App\EventListener\RouteListener::events(),
    App\EventListener\ErrorListener::events(),
    App\EventListener\MapperListener::events(),
    App\EventListener\TemplateListener::events(),
));
