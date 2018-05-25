<?php
$res = $arg1;
$class = $arg2 ?? null;
$adjacent = $arg3 ?? 3;

$onFirstPage = $res['page'] <= 1;
$onLastPage = $res['page'] >= $res['pages'];
$rangeStart = $res['page'] <= $adjacent ? 1 : $res['page'] - $adjacent;
$rangeEnd = $res['page'] > $res['pages'] - $adjacent ? $res['pages'] : $res['page'] + $adjacent;
$prevGap = $rangeStart > 1;
$nextGap = $rangeEnd < $res['pages'];

$firstClass = $onFirstPage ? 'disabled' : null;
$lastClass = $onLastPage ? 'disabled' : null;

if (!$res['pages']) {
    return;
}

?>

<nav aria-label="Page navigation">
  <ul class="pagination <?= $class; ?>">
    <li class="page-item <?= $firstClass; ?>">
      <a class="page-link" href="<?= $onFirstPage ? '#' : $this->path(null, null, $_GET + ['page' => 1]); ?>" aria-label="First">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">First</span>
      </a>
    </li>
    <li class="page-item <?= $firstClass; ?>">
      <a class="page-link" href="<?= $onFirstPage ? '#' : $this->path(null, null, $_GET + ['page' => $res['page'] - 1]); ?>" aria-label="Prev">
        <span aria-hidden="true">&lsaquo;</span>
        <span class="sr-only">Prev</span>
      </a>
    </li>
    <?php for ($page = $rangeStart; $page <= $rangeEnd; ++$page): ?>
      <li class="page-item <?= $page === $res['page'] ? 'active' : null; ?>"><a class="page-link" href="<?= $this->path(null, null, $_GET + ['page' => $page]); ?>"><?= $page; ?></a></li>
    <?php endfor; ?>
    <li class="page-item <?= $lastClass; ?>">
      <a class="page-link" href="<?= $onLastPage ? '#' : $this->path(null, null, $_GET + ['page' => $res['page'] + 1]); ?>" aria-label="Next">
        <span aria-hidden="true">&rsaquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
    <li class="page-item <?= $lastClass; ?>">
      <a class="page-link" href="<?= $onLastPage ? '#' : $this->path(null, null, $_GET + ['page' => $res['pages']]); ?>" aria-label="Last">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Last</span>
      </a>
    </li>
  </ul>
</nav>
