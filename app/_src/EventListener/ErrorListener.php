<?php

namespace App\EventListener;

use Fal\Stick\Fw;
use Fal\Stick\Library\Template\Template;

class ErrorListener
{
    public static function events()
    {
        return array(
            array(Fw::EVENT_ERROR, self::class.'->onError'),
        );
    }

    public function onError(Fw $fw, Template $template, $message, $trace)
    {
        if ($fw->is('AJAX')) {
            return false;
        }

        return $template->render('error.php', compact('message', 'trace'));
    }
}
