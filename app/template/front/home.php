<?php $this->extend('front.php') ?>

<?php $this->block('content') ?>
  <?php foreach ($latestArticles['subset'] as $article): ?>
    <div class="post">
      <h3><a href="<?= $this->path('post', array('slug' => $article->slug)) ?>"><?= $article->title ?></a></h3>
      <hr>
      <div>
        <?= $this->e($article->content) ?>
      </div>
    </div>
  <?php endforeach ?>
  <?php if (empty($article)): ?>
    <p><em>No articles.</em></p>
  <?php endif ?>
<?php $this->endBlock() ?>
