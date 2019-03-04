<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
<h1 class="page-header">Profile</h1>

<?= $this->app->alerts() ?>
<?= $form->render() ?>
<?php $this->stop() ?>