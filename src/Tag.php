<?php

namespace App;

use Fal\Stick\Template\Environment;

class Tag
{
    public static function alerts(Environment $env, array $node): string
    {
        extract($env->attrib($node, array(
            'type' => null,
            'dismissable' => true,
        )));

        if ($env->fw->cast($dismissable)) {
            $dismiss_class = ' alert-dismissable';
            $dismiss_button = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        } else {
            $dismiss_class = '';
            $dismiss_button = '';
        }

        if ($type) {
            $get = '.'.$type;
            $repeat = "array('$type' => \$__alerts)";
        } else {
            $get = $type;
            $repeat = '$__alerts';
        }

        return
            "<?php if (\$__alerts = \$_->flash('SESSION.alerts$get'))".
            " foreach ($repeat as \$type => \$messages)".
            ' foreach ((array) $messages as $message): ?>'.
            "<div class=\"alert alert-<?= \$type ?>$dismiss_class\" role=\"alert\">".
            "$dismiss_button <?= \$message ?>".
            '</div>'.
            '<?php endforeach ?>';
    }
}
