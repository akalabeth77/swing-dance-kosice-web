<section class="section-heading page-header">
    <div>
        <span class="eyebrow">📝 Blog</span>
        <h1>Workshop blog a community updates</h1>
        <p>Sekcia pre recapy, rozhovory s lektormi, SEO články aj long-form obsah po eventoch.</p>
    </div>
</section>

<div class="card-grid two-up">
    <?php foreach ($articles as $article): ?>
        <article class="card article-card">
            <img src="<?= e($article['cover']) ?>" alt="<?= e($article['title']) ?>">
            <div class="meta"><?= e(format_date($article['date'])) ?></div>
            <h2><?= e($article['title']) ?></h2>
            <p><?= e($article['excerpt']) ?></p>
            <a href="<?= e(url('/blog/' . $article['slug'])) ?>">Čítať článok →</a>
        </article>
    <?php endforeach; ?>
</div>
