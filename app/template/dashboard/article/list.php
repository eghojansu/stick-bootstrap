<?php $this->extend('dashboard.php') ?>

<?php $this->block('content') ?>
  <h1>Pages</h1>

  <div class="row">
    <div class="col-sm-6">
      <form class="form-inline">
        <div class="form-group">
          <label for="keyword" class="sr-only">Keyword</label>
          <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Keyword" value="<?= $keyword ?>">
        </div>
        <div class="form-group">
          <button class="btn btn-default">Search</button>
        </div>
      </form>
    </div>
    <div class="col-sm-6 text-right">
      <div class="btn-group">
        <a href="<?= $this->path('mpage_create') ?>" class="btn btn-primary">Create</a>
      </div>
    </div>
  </div>

  <br>

  <?= $this->alerts() ?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Title</th>
        <th>Content</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = $data['start']; foreach ($data['subset'] as $item): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $item->title ?></td>
          <td><?= $item->content ?></td>
          <td>
            <a href="<?= $this->path('mpage_update', array('article' => $item->id)) ?>" class="btn btn-sm btn-info">Edit</a>
            <a href="<?= $this->path('mpage_delete', array('article' => $item->id)) ?>" class="btn btn-sm btn-danger">Delete</a>
          </td>
        </tr>
      <?php endforeach ?>
      <?php if ($no === $data['start']): ?>
        <tr><td colspan="4">No data.</td></tr>
      <?php endif ?>
    </tbody>
  </table>

  <div class="text-right">
    <?= $this->html->pagination($data['page'], $data['pages']) ?>
  </div>
<?php $this->endBlock() ?>
