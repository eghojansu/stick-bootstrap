<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="author" content="Eko Kurniawan">
  <title>Login - <?= $app['name']; ?></title>
  <link href="<?= $asset.'css/vendor-1.bundle.css'; ?>" rel="stylesheet">
  <link href="<?= $asset.'css/login.css'; ?>" rel="stylesheet">
</head>

<body>
  <div class="login">
    <h1 class="ui teal image header">
      Log-in to your account
    </h1>

    <?= $this->alert('danger', $attempt['message'], $attempt['messages'], ['sticky' => true]); ?>

    <form method="POST">
      <?= $this->group('text', 'username', 'Username', $attempt['username'], null, $attempt['error']['username']); ?>
      <?= $this->group('password', 'password', 'Password', null, null, $attempt['error']['password']); ?>

      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
  </div>

  <script type="text/javascript" src="<?= $asset.'js/vendor-1.bundle.js'; ?>"></script>
</body>
</html>
