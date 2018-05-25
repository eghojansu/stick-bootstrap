<?php
$items = $arg1 ?? [];
$right = $arg2 ?? false;
$current = $arg3 ?? $app['route'];
?>

<div class="navbar-nav<?= $right ? ' ml-auto' : ''; ?>">
  <?php foreach ($items as $route => $item): ?>
    <?php if (!($item['hidden'] ?? false)): ?>
      <?php if (isset($item['items']) && is_array($item['items'])): ?>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle<?= isset($item['items'][$current]) ? 'active' : ''; ?>" href="#" id="<?= $route; ?>-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $item['label']; ?>
          </a>
          <div class="dropdown-menu<?= $right ? ' dropdown-menu-right' : ''; ?>" aria-labelledby="<?= $route; ?>-menu">
            <?php foreach ($item['items'] as $croute => $citem): ?>
              <a class="dropdown-item<?= $current == $croute ? ' active' : ''; ?>" href="<?= $this->path($croute); ?>"><?= $citem['label']; ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php else: ?>
        <a class="nav-item nav-link<?= $current == $route ? ' active' : ''; ?>" href="<?= $this->path($route); ?>"><?= $item['label']; ?></a>
      <?php endif; ?>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
