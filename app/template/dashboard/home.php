<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
Welcome to the Dashboard, <?= $this->user['fullname'] ?>.
<?php $this->stop() ?>