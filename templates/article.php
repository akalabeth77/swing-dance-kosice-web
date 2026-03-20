<article class="card prose article-detail">
    <div class="meta"><?= e(format_date($article['date'])) ?></div>
    <h1><?= e($article['title']) ?></h1>
    <p class="lead"><?= e($article['excerpt']) ?></p>
    <?= $article['body'] ?>
    <ul class="inline-list tags">
        <?php foreach ($article['tags'] as $tag): ?>
            <li><?= e($tag) ?></li>
        <?php endforeach; ?>
    </ul>
</article>
