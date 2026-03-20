<section class="section-heading page-header">
    <div>
        <span class="eyebrow">📅 Event calendar</span>
        <h1>Kalendár eventov</h1>
        <p>Ak je nastavený Facebook Graph API token, zoznam sa automaticky napĺňa z udalostí FB stránky. Inak sa zobrazia ukážkové eventy.</p>
    </div>
</section>

<div class="timeline">
    <?php foreach ($events as $event): ?>
        <article class="card timeline-item">
            <div>
                <div class="meta"><?= e(format_datetime($event['date'])) ?></div>
                <h2><?= e($event['title']) ?></h2>
                <p><?= e($event['excerpt']) ?></p>
                <ul class="inline-list">
                    <li><?= e($event['location']) ?></li>
                    <li>Zdroj: <?= e($event['source']) ?></li>
                </ul>
            </div>
            <div class="actions split">
                <a class="button" href="<?= e(url('/events/' . $event['slug'])) ?>">Detail</a>
                <a class="button primary" href="<?= e(url($event['cta_url'])) ?>"><?= e($event['cta_label']) ?></a>
            </div>
        </article>
    <?php endforeach; ?>
</div>
