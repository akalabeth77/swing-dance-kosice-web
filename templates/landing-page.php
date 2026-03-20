<section class="hero detail-hero">
    <div>
        <span class="eyebrow">Event landing page</span>
        <h1><?= e($landingPage['title']) ?></h1>
        <p><?= e($landingPage['subtitle']) ?></p>
        <div class="price-badge"><?= e($landingPage['price']) ?></div>
        <div class="actions">
            <a class="button primary" href="<?= e(url($landingPage['cta_url'])) ?>"><?= e($landingPage['cta_label']) ?></a>
            <a class="button" href="<?= e(url('/events')) ?>">Späť na event calendar</a>
        </div>
    </div>
    <img class="hero-image" src="<?= e($landingPage['hero_image']) ?>" alt="<?= e($landingPage['title']) ?>">
</section>

<section class="section-grid two-up">
    <article class="card">
        <h2>Highlights</h2>
        <ul class="feature-list">
            <?php foreach ($landingPage['highlights'] as $highlight): ?>
                <li><?= e($highlight) ?></li>
            <?php endforeach; ?>
        </ul>
    </article>
    <article class="card" id="pricing">
        <h2>Prečo tento layout funguje</h2>
        <p>Je navrhnutý pre rýchle promo kampane: jasný headline, benefit stack, schedule, FAQ a jedno hlavné CTA.</p>
        <p>Pri migrácii do WordPressu sa dá rozložiť na Gutenberg bloky alebo ACF flexible content.</p>
    </article>
</section>

<section class="section-grid two-up">
    <article class="card">
        <h2>Harmonogram</h2>
        <?php foreach ($landingPage['schedule'] as $block): ?>
            <div class="stacked-item">
                <strong><?= e($block['day']) ?></strong>
                <ul class="feature-list compact">
                    <?php foreach ($block['items'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </article>
    <article class="card">
        <h2>FAQ</h2>
        <?php foreach ($landingPage['faq'] as $item): ?>
            <div class="stacked-item">
                <strong><?= e($item['question']) ?></strong>
                <p><?= e($item['answer']) ?></p>
            </div>
        <?php endforeach; ?>
    </article>
</section>
