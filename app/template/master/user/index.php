<?php $this->set('pageTitle', 'Data User'); ?>
<?php $this->set('pTitle', 'Data User'); ?>
<?php $this->set('breadcrumb', [
    '#master' => 'Master',
    '#active' => 'Data User',
]); ?>

<div class="row mb-2">
  <div class="col">
    <form class="form-inline">
      <label for="i-keyword" class="sr-only">Keyword</label>
      <input type="text" class="form-control" id="i-keyword" name="keyword" value="<?= $keyword; ?>" placeholder="Search...">

      <button class="btn btn-info ml-2"><i class="fas fa-search"></i></button>
    </form>
  </div>
  <div class="col text-right">
    <div class="btn-group" role="group" aria-label="Controls">
      <a href="<?= $this->path('user_create'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New</a>
    </div>
  </div>
</div>

<?= $this->alert('success', $success); ?>

<table class="table">
<thead>
  <tr>
    <th>#</th>
    <th>Fullname</th>
    <th>Username</th>
    <th></th>
  </tr>
</thead>
<tbody>
  <?php $ctr = -1; foreach ($users['subset'] as $user): $ctr++; ?>
    <tr>
      <td><?= $users['start'] + $ctr; ?></td>
      <td><?= $user['profile']['fullname']; ?></td>
      <td><?= $user['username']; ?></td>
      <td>
        <a href="<?= $this->path('user_edit', ['user' => $user['id']]); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
        <a href="#" data-target="<?= $this->path('user_delete', ['user' => $user['id']]); ?>" data-delete="record" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!isset($user)): ?>
    <tr><td colspan="4">No data</td></tr>
  <?php endif; ?>
</tbody>
</table>

<?= $this->tablefooter($users); ?>
