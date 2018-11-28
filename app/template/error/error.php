<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <title><?= $error['code'].' - '.$error['status']; ?></title>
  <link rel="stylesheet" href="<?= $this->asset('assets/bootstrap/css/bootstrap.min.css') ?>">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1><?= $error['status']; ?></h1>

        <div class="lead">
          <?= $error['text']; ?>
        </div>

        <a href="<?= $this->path('home'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Home</a>

        <?php if ($debug): ?>
          <br>
          <br>
          <pre><?= $error['trace']; ?></pre>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>