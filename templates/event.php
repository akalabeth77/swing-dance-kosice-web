<section class="hero detail-hero">
    <div>
        <span class="eyebrow">Event detail / landing starter</span>
        <h1><?= e($event['title']) ?></h1>
        <p><?= e($event['excerpt']) ?></p>
        <ul class="inline-list">
            <li><?= e(format_datetime($event['date'])) ?></li>
            <li><?= e($event['location']) ?></li>
            <li>Zdroj: <?= e($event['source']) ?></li>
        </ul>
        <div class="actions">
            <a class="button primary" href="<?= e(url($event['cta_url'])) ?>"><?= e($event['cta_label']) ?></a>
            <a class="button" href="<?= e(url('/landing-pages')) ?>">Pozrieť landing layouts</a>
        </div>
    </div>
    <img class="hero-image" src="<?= e($event['hero_image']) ?>" alt="<?= e($event['title']) ?>">
</section>

<section class="section-grid two-up">
    <article class="card prose">
        <h2>Popis eventu</h2>
        <?= $event['body'] ?>
    </article>
    <aside class="card">
        <h2>Highlights</h2>
        <ul class="feature-list">
            <?php foreach ($event['highlights'] as $highlight): ?>
                <li><?= e($highlight) ?></li>
            <?php endforeach; ?>
        </ul>
    </aside>
</section>
