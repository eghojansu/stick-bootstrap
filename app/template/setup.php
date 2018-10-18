<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <meta name="theme-color" content="#008000">
  <title>Installation Page</title>
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
        <a class="navbar-brand" href="#">Stick Installation Page</a>
      </div>

      <div class="collapse navbar-collapse" id="collapse-one">
        <p class="navbar-text navbar-right">Installed Version: <?= $installed_version ?> | App Version: <?= $app_version ?></p>
      </div>
    </div><!-- /.container -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <p>Please press button below to begin installation process.</p>

        <div class="alert alert-info">
          <strong>Info!</strong><br>
          <ul>
            <li>To be safe, please remove this file <strong><?= $file ?></strong> after installation complete.</li>
            <li>After installation complete you will not be able to see this page again.</li>
          </ul>
        </div>

        <form method="post">
          <button class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-wrench"></span> Start Installation</button>
        </form>
      </div>
    </div>
  </div>

  <script src="<?= $this->baseUrl('assets/jquery.min.js') ?>"></script>
  <script src="<?= $this->baseUrl('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
</body>
</html>
