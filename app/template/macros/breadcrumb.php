<?php
/* Dashboard Breadcrumb */
$items = $arg1 ?? [];
$root = $arg2 ?? true;

end($items);
$last = key($items);
?>

<ol class="breadcrumb">
  <?php if ($root): ?>
    <li class="breadcrumb-item"><a href="<?= $this->path('dashboard'); ?>"><i class="fas fa-home"></i></a></li>
  <?php endif; ?>
  <?php foreach ($items as $route => $label): ?>
    <?php if ($last === $route): ?>
      <li class="breadcrumb-item active" aria-current="page"><?= $label; ?></li>
    <?php else: ?>
      <li class="breadcrumb-item"><a href="<?= $this->startswith($route, '#') ? '#' : $this->path($route); ?>"><?= $label; ?></a></li>
    <?php endif; ?>
  <?php endforeach; ?>
</ol>
