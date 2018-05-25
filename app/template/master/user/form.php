<?php $title = 'Form User'; ?>
<?php $this->set('pageTitle', $title); ?>
<?php $this->set('pTitle', $title); ?>
<?php $this->set('breadcrumb', [
    '#master' => 'Master',
    'user_index' => 'Data User',
    '#active' => $title,
]); ?>

<form method="post">
  <?= $this->grouprow('text', 'fullname', 'Fullname', $data['fullname'] ?? null, null, null, $error['fullname']); ?>
  <?= $this->grouprow('text', 'username', 'Username', $data['username'] ?? null, null, null, $error['username']); ?>
  <?= $this->grouprow('text', 'password', 'Password', null, null, null, $error['password']); ?>

  <div class="form-group row">
    <div class="col-10 ml-auto">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="<?= $this->path('user_index'); ?>" class="btn btn-secondary">Cancel</a>
    </div>
  </div>
</form>
