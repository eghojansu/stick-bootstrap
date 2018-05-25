<?php

return (new Fal\Stick\App())
    ->config(__DIR__.'/../.env.dist')
    ->config(__DIR__.'/../.env')
    ->config(__DIR__.'/config/all.php')
;
