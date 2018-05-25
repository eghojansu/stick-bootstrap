<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <title><?= $pageTitle ?? $app['name']; ?></title>
  <link href="<?= $asset.'css/vendor-1.bundle.css'; ?>" rel="stylesheet">
  <link href="<?= $asset.'css/dashboard.css'; ?>" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="<?= $this->path('home'); ?>"><?= $app['name']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-main" aria-controls="nav-main" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav-main">
      <?= $this->navbar([
        'dashboard' => ['label' => 'Home'],
        '#master' => ['label' => 'Master', 'items' => [
          'user_index' => ['label' => 'User'],
        ]],
      ]); ?>

      <?= $this->navbar([
        '#account' => ['label' => 'Account', 'items' => [
          'profile' => ['label' => 'Profile'],
          'logout' => ['label' => 'Logout'],
        ]],
      ], true); ?>
    </div>
  </nav>

  <main class="mcontent">
    <div class="container-fluid">
        <div class="row">
          <div class="col">
            <nav aria-label="breadcrumb">
              <?php if (isset($breadcrumb)): ?>
                <?= $this->breadcrumb($breadcrumb, $breadcrumbRoot ?? null); ?>
              <?php else: ?>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-home"></i></li>
                </ol>
              <?php endif; ?>
            </nav>

            <h1 class="page-header"><?= $pTitle ?? 'Dashboard'; ?></h1>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <?php if (isset($content)): ?>
              <?= trim($content); ?>
            <?php else: ?>
              <p><em>No available content.</em></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
  </main>

  <footer class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom">
    <p class="navbar-text"><?= $app['name']; ?> &ndash; 2018</p>
  </footer>

  <script type="text/javascript" src="<?= $asset.'js/vendor-1.bundle.js'; ?>"></script>
  <script type="text/javascript" src="<?= $asset.'js/vendor-2.bundle.js'; ?>"></script>
  <script type="text/javascript" src="<?= $asset.'js/dashboard.js'; ?>"></script>
</body>
</html>
