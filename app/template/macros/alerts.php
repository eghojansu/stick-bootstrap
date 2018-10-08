<?php foreach (isset($alerts) ? $alerts : array() as $type => $message): ?>
  <?= $this->alert($message, $type) ?>
<?php endforeach ?>

