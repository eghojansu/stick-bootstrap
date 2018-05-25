<?php
$label = $arg1 ?? null;
$id = $arg2 ?? null;
$attr = $arg3 ?? [];
?>

<label <?= $this->attr($attr + ['for' => $id]); ?>><?= $label; ?></label>
