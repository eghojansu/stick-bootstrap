<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <meta name="theme-color" content="#008000">
  <title><?php $this->block('title') ?><?= $app['name'] ?><?php $this->endBlock() ?></title>
  <link rel="stylesheet" href="<?= $this->baseUrl('assets/bootstrap/css/bootstrap.min.css') ?>">
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
        <a class="navbar-brand" href="<?= $this->path('home') ?>"><?= $app['name'] ?></a>
      </div>

      <div class="collapse navbar-collapse" id="collapse-one">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?= $this->path('home') ?>">Home</a></li>
          <li><a href="<?= $this->path('page', 'page=about') ?>">About</a></li>
          <li><a href="<?= $this->path('page', 'page=contact') ?>">Contact</a></li>
          <li><a href="<?= $this->path('sitemap') ?>">Sitemap</a></li>
          <li><a href="<?= $this->path('login') ?>">Login</a></li>
        </ul>
      </div>
    </div><!-- /.container -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <?php $this->block('content') ?>
          Page content.
        <?php $this->endBlock() ?>
      </div>
      <div class="col-sm-4">
        <?= $this->load('front/widgets.php') ?>
      </div>
    </div>
  </div>

  <script src="<?= $this->baseUrl('assets/jquery.min.js') ?>"></script>
  <script src="<?= $this->baseUrl('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
</body>
</html>