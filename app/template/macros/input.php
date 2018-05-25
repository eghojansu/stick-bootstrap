<?php
$type = $arg1 ?? 'text';
$name = $arg2 ?? null;
$value = $arg3 ?? null;
$attr = $arg4 ?? [];
$error = $arg5 ?? null;

$attr['class'] = 'form-control '.($attr['class'] ?? '');
?>

<?php if ($error): $attr['class'] .= ' is-invalid'; endif; ?>
<input <?= $this->attr($attr + ['type' => $type, 'name' => $name, 'value' => $value]); ?>>
<?php if ($error): ?><div class="invalid-feedback"><?= implode(', ', (array) $error); ?></div><?php endif; ?>
