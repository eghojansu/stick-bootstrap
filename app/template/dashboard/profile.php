<?php $this->set('pageTitle', 'Profile - '.$app['name']); ?>
<?php $this->set('ptitle', 'Profile'); ?>
<?php $this->set('breadcrumb', ['#' => 'Profile']); ?>

<?= $this->alert('success', $success); ?>

<form method="post">
  <?= $this->grouprow('text', 'fullname', 'Fullname', $app['user']['profile']['fullname'], null, null, $error['fullname']); ?>
  <?= $this->grouprow('text', 'username', 'Username', $app['user']['username'], null, null, $error['username']); ?>
  <?= $this->grouprow('password', 'new_password', 'New Password', null, null, null, $error['new_password']); ?>
  <?= $this->grouprow('password', 'password', 'Password', null, null, null, $error['password']); ?>

  <div class="form-group row">
    <div class="col-10 ml-auto">
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="<?= $this->path('dashboard'); ?>" class="btn btn-secondary">Cancel</a>
    </div>
  </div>
</form>
