<?php

namespace App\EventListener;

use Fal\Stick\App;
use Fal\Stick\Library\Template\Template;

class ErrorListener
{
    public function handle(App $app, Template $template, $message, $trace)
    {
        if ($app->is('AJAX')) {
            return false;
        }

        return $template->render('error.php', compact('message', 'trace'));
    }
}
