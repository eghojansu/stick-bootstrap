<?php $this->extend('dashboard.php') ?>

<?php $this->block('content') ?>
  <h1><?= $crud['title'] ?></h1>

  <?= $this->alerts() ?>

  <?= $crud['form']->open() ?>
  <?= $crud['form']->rows() ?>
  <?php if ($crud['form']->getButtons()): ?>
    <?= $crud['form']->buttons() ?>
  <?php else: ?>
    <div class="form-group">
      <div class="col-sm-10 col-sm-offset-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= $this->crudLink() ?>" class="btn btn-default">Cancel</a>
      </div>
    </div>
  <?php endif ?>
  <?= $crud['form']->close() ?>
<?php $this->endBlock() ?>
