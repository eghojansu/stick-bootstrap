<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <title><?= $pageTitle ?? $app['name']; ?></title>
  <link href="<?= $asset.'css/vendor-1.bundle.css'; ?>" rel="stylesheet">
  <link href="<?= $asset.'css/front.css'; ?>" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="<?= $this->path('home'); ?>"><?= $app['name']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-main" aria-controls="nav-main" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav-main">
      <?= $this->navbar([
        'home' => ['label' => 'Home'],
      ]); ?>

      <?= $this->navbar([
        'login' => ['label' => 'Login', 'hidden' => $app['logged']],
        'dashboard' => ['label' => 'Dashboard', 'hidden' => !$app['logged']],
      ], true); ?>
    </div>
  </nav>

  <main class="mcontent">
    <?php if (isset($content)): ?>
      <?= trim($content); ?>
    <?php else: ?>
      <p><em>No available content.</em></p>
    <?php endif; ?>
  </main>

  <footer class="mfooter">
    <?= $app['name']; ?> &ndash; 2018
  </footer>

  <script type="text/javascript" src="<?= $asset.'js/vendor-1.bundle.js'; ?>"></script>
  <script type="text/javascript" src="<?= $asset.'js/vendor-2.bundle.js'; ?>"></script>
</body>
</html>
