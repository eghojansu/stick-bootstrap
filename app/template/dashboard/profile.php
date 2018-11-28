<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
<h1 class="page-header">Profile</h1>

<?= $this->alerts($this->alerts) ?>
<?= $form->render() ?>
<?php $this->stop() ?>
