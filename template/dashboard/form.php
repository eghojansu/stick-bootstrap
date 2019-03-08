<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
<h1 class="page-header"><?= $title ?></h1>

<?= $this->app->alerts() ?>

<?= $form->open() ?>
<?= $form->rows() ?>
<?php if ($button = trim($form->buttons())): ?>
  <?= $button ?>
<?php else: ?>
  <div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="<?= $this->app->path('dashboard') ?>" class="btn btn-default">Cancel</a>
    </div>
  </div>
<?php endif ?>
<?= $form->close() ?>
<?php $this->stop() ?>