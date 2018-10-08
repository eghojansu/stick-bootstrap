<?php if ($arg1): ?>
  <div class="alert alert-<?= isset($arg2) ? $arg2 : 'info' ?> alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <?= $arg1 ?>
  </div>
<?php endif ?>

