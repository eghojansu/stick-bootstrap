<?php $this->extend('dashboard.php') ?>

<?php $this->block('content') ?>
  <h1 class="page-header">Profile</h1>

  <?= $this->alerts() ?>
  <?= $form->render() ?>
<?php $this->endBlock() ?>