<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
<?= $this->app->alerts() ?>
Welcome to the Dashboard, <?= $this->app->user['fullname'] ?>.
<?php $this->stop() ?>