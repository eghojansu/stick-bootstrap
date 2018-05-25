<?php
$type = $arg1 ?? null;
$name = $arg2 ?? null;
$label = $arg3 ?? null;
$value = $arg4 ?? null;
$attr = $arg5 ?? [];
$lattr = $arg6 ?? [];
$error = $arg7 ?? null;

$id = $attr['id'] ?? 'i'.$this->filter($name, 'lower|strtr:_,-');
$lclass = $lattr['class'] ?? $this->get('rowlabelwidth') ?? 'col-sm-2';
$lattr['class'] = $lclass.' col-form-label';
preg_match('/\b(col(?:\-(?:sm|md|lg|xl))?\-)(\d+)\b/', $lclass, $match);
?>

<div class="form-group row">
  <?= $this->label($label, $id, $lattr); ?>
  <div class="<?= $match ? $match[1].(12 - $match[2]) : 'col-sm-10'; ?>">
    <?= $this->input($type, $name, $value, array_merge(['id' => $id, 'placeholder' => $label], $attr), $error); ?>
  </div>
</div>
