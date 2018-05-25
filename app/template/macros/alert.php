<?php
$type = $arg1 ?? 'primary';
$message = $arg2 ?? null;
$messages = $arg3 ?? null;
$attr = $arg4 ?? [];
?>

<?php if (isset($message) or isset($messages)): ?>
  <?php $attr += ['extra' => null, 'sticky' => false, 'shout' => null]; ?>
  <div class="alert alert-<?= $type.($attr['extra'] ? ' '.$attr['extra'] : '').($attr['sticky'] ? '' : ' alert-dismissible fade show'); ?>" role="alert">
    <?php if ($attr['shout']): ?><strong><?= $attr['shout']; ?></strong><br><?php endif; ?>
    <?php if (isset($message)): ?><?= $message; ?><?php endif; ?>
    <?php if (isset($messages) and $messages): ?>
      <ul>
        <?php foreach ($messages as $item): ?>
          <li><?= $item; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <?php if (!$attr['sticky']): ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    <?php endif; ?>
  </div>
<?php endif; ?>
