<?php

use Fal\Stick\Fw;
use Fal\Stick\Security\Auth;
use Fal\Stick\Sql\MapperParameterConverter;
use Fal\Stick\Template\Template;

return array(
    array(Fw::EVENT_ERROR, function (Fw $fw, Template $template) {
        if ($fw['AJAX'] || $fw['CLI']) {
            return false;
        }

        return $template->render('error/error', array(
            'error' => $fw['ERROR'],
            'debug' => $fw['DEBUG'],
        ));
    }),
    array(Fw::EVENT_PREROUTE, function (Fw $fw) {
        if ($fw['CLI']) {
            return false;
        }

        return $fw->service(Auth::class)->guard();
    }),
    array(Fw::EVENT_CONTROLLER_ARGS, function(Fw $fw, $controller, $args) {
        if ($fw['CLI'] || !$args) {
            return null;
        }

        return MapperParameterConverter::create($fw, $controller, $args)->resolve();
    }),
);
