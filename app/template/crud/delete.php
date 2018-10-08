<?php $this->extend('dashboard.php') ?>

<?php $this->block('content') ?>
  <h1><?= $crud['title'] ?></h1>

  <?= $this->alerts() ?>

  <table class="table table-bordered">
    <tbody>
      <?php foreach ($crud['fields'] as $field => $def): ?>
        <tr>
          <th><?= $def['label'] ?></th>
          <td><?= $crud['item'][$field] ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>

  <p><em>Are you sure?</em></p>

  <form method="post">
    <button type="submit" class="btn btn-danger">Delete</button>
    <a href="<?= $this->crudLink() ?>" class="btn btn-default">Cancel</a>
  </form>
<?php $this->endBlock() ?>
