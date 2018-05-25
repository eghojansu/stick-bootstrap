<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <title><?= $error['code'].' - '.$error['status']; ?></title>
  <link href="<?= $asset.'css/vendor-1.bundle.css'; ?>" rel="stylesheet">
  <link href="<?= $asset.'css/error.css'; ?>" rel="stylesheet">
</head>

<body>
  <div class="error">
    <h1><?= $error['status']; ?></h1>

    <main>
      <div class="lead">
        <?= $error['text']; ?>
      </div>

      <a href="<?= $this->path('home'); ?>" class="btn btn-primary home-button"><i class="fas fa-home"></i> Home</a>

      <?php if ($app['debug']): ?>
        <pre><?= $error['trace']; ?></pre>
      <?php endif; ?>
    </main>
  </div>

  <script type="text/javascript" src="<?= $asset.'js/vendor-1.bundle.js'; ?>"></script>
</body>
</html>
