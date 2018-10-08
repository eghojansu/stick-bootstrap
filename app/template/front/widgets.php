<div class="widgets">
  <div class="panel panel-primary">
    <div class="panel-heading">Popular Articles</div>
    <div class="panel-body populars">
      <?php foreach ($popularArticles as $article): ?>
        <a href="<?= $this->path('post', array('slug' => $article->slug)) ?>"><?= $article->title ?></a>
      <?php endforeach ?>
      <?php if (empty($article)): ?>
        <p><em>No articles.</em></p>
      <?php endif ?>
    </div>
  </div>
</div>
