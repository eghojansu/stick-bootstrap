<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <meta name="theme-color" content="#008000">
  <title>Login - <?= $this->app->name; ?></title>
  <link rel="stylesheet" href="<?= $this->app->asset('assets/bootstrap/css/bootstrap.min.css') ?>">
</head>
<body>
  <div style="max-width: 400px; margin: 40px auto">
    <div class="panel panel-primary">
      <div class="panel-heading">Please login</div>
      <div class="panel-body">
        <?= $this->app->alerts(array('danger' => $message)) ?>
        <?= $form->render() ?>
      </div>
    </div>
  </div>

  <script src="<?= $this->app->asset('assets/jquery.min.js') ?>"></script>
  <script src="<?= $this->app->asset('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
</body>
</html>