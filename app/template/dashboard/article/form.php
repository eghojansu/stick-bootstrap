<?php $this->extend('dashboard.php') ?>

<?php $this->block('content') ?>
  <h1>Page</h1>

  <?= $this->alerts() ?>

  <?= $form->open() ?>
  <?= $form->rows() ?>
  <div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="<?= $this->path('mpage') ?>" class="btn btn-default">Cancel</a>
    </div>
  </div>
  <?= $form->close() ?>
<?php $this->endBlock() ?>
