<?php
$type = $arg1 ?? null;
$name = $arg2 ?? null;
$label = $arg3 ?? null;
$value = $arg4 ?? null;
$attr = $arg5 ?? [];
$error = $arg6 ?? null;

$id = $attr['id'] ?? 'i'.$this->filter($name, 'lower|strtr:_,-');
?>

<div class="form-group">
  <?= $this->label($label, $id); ?>
  <?= $this->input($type, $name, $value, array_merge(['id' => $id, 'placeholder' => $label], $attr), $error); ?>
</div>
