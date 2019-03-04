<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
<h1><?= $crud->title ?></h1>

<div class="row">
  <div class="col-sm-6">
    <form class="form-inline">
      <div class="form-group">
        <label for="keyword" class="sr-only">Keyword</label>
        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Keyword" value="<?= $crud->keyword ?>">
      </div>
      <div class="form-group">
        <button class="btn btn-default">Search</button>
      </div>
    </form>
  </div>
  <div class="col-sm-6 text-right">
    <div class="btn-group">
      <a href="<?= $crud->path('create') ?>" class="btn btn-primary">Create</a>
    </div>
  </div>
</div>

<br>

<?= $this->app->alerts() ?>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>No</th>
      <?php foreach ($crud->fields as $field): ?>
        <th><?= $field['label'] ?></th>
      <?php endforeach ?>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php $no = $crud->data['start']; foreach ($crud->data['mapper'] as $item): ?>
      <tr>
        <td><?= $no++ ?></td>
        <?php foreach ($crud->fields as $field): ?>
          <td><?= $item[$field['name']] ?></td>
        <?php endforeach ?>
        <td>
          <a href="<?= $crud->path('view/'.$item['id']) ?>" class="btn btn-sm btn-success">Detail</a>
          <a href="<?= $crud->path('update/'.$item['id']) ?>" class="btn btn-sm btn-info">Edit</a>
          <a href="<?= $crud->path('delete/'.$item['id']) ?>" class="btn btn-sm btn-danger">Delete</a>
        </td>
      </tr>
    <?php endforeach ?>
    <?php if ($no === $crud->data['start']): ?>
      <tr><td colspan="<?= count($crud->fields) + 2 ?>">No data.</td></tr>
    <?php endif ?>
  </tbody>
</table>

<div class="text-right">
  <?= $this->pagination->build($crud->data['page'], $crud->data['pages']) ?>
</div>
<?php $this->stop() ?>