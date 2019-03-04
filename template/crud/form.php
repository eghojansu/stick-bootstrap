<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
<h1><?= $crud->title ?></h1>

<?= $this->app->alerts() ?>

<?= $crud->form->open() ?>
<?= $crud->form->rows() ?>
<?php if ($button = trim($crud->form->buttons())): ?>
  <?= $button ?>
<?php else: ?>
  <div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="<?= $crud->path() ?>" class="btn btn-default">Cancel</a>
    </div>
  </div>
<?php endif ?>
<?= $crud->form->close() ?>
<?php $this->stop() ?>