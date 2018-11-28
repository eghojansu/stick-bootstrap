<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <meta name="theme-color" content="#008000">
  <title><?php $this->start('title') ?>Dashboard - <?= $this->app['name'] ?><?php $this->stop() ?></title>
  <link rel="stylesheet" href="<?= $this->asset('assets/bootstrap/css/bootstrap.min.css') ?>">
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-one" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= $this->path('home') ?>"><?= $this->app['name'] ?></a>
      </div>

      <div class="collapse navbar-collapse" id="collapse-one">
        <ul class="nav navbar-nav">
          <li><a href="<?= $this->path('dashboard') ?>">Dashboard</a></li>
          <li><a href="<?= $this->path('users', array('index')) ?>">Manage User</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?= $this->path('profile') ?>">Profile</a></li>
          <li><a href="<?= $this->path('logout') ?>">Logout</a></li>
        </ul>
      </div>
    </div><!-- /.container -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <?php $this->start('content') ?>
          Page content.
        <?php $this->stop() ?>
      </div>
    </div>
  </div>

  <script src="<?= $this->asset('assets/jquery.min.js') ?>"></script>
  <script src="<?= $this->asset('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
</body>
</html>