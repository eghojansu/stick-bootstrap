<?php $this->extend('layout/dashboard') ?>

<?php $this->start('content') ?>
<h1><?= $crud->title ?></h1>

<a href="<?= $crud->path() ?>" class="btn btn-default">Back</a>
<br>
<br>

<?= $this->alerts() ?>

<table class="table table-bordered">
  <tbody>
    <?php foreach ($crud->fields as $field): ?>
      <tr>
        <th><?= $field['label'] ?></th>
        <td><?= $crud->mapper[$field['name']] ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?php $this->stop() ?>
