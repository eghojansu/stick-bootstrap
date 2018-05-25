<div class="row mt-2">
  <div class="col">
    Displaying <?= $arg1['start']; ?> &ndash; <?= $arg1['end']; ?> of <?= $arg1['total']; ?> records
  </div>
  <div class="col">
    <?= $this->pagination($arg1, 'justify-content-end'); ?>
  </div>
</div>
