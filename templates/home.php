<section class="hero">
    <div>
        <span class="eyebrow">PHP reference starter</span>
        <h1>Nový základ pre swing komunitu v Košiciach.</h1>
        <p>Pripravený na event calendar, Facebook import, galériu, workshop blog, registrácie na kurzy aj samostatné event landing pages.</p>
        <div class="actions">
            <a class="button primary" href="<?= e(url('/events')) ?>">Pozrieť eventy</a>
            <a class="button" href="<?= e(url('/courses')) ?>">Spustiť registrácie</a>
        </div>
    </div>
    <div class="card spotlight">
        <h2>Čo je hotové hneď teraz</h2>
        <ul class="feature-list">
            <li>📅 kalendár eventov so schopnosťou ťahať dáta z FB stránky</li>
            <li>📷 galéria pripravená na FB album feed</li>
            <li>📝 blog sekcia pre workshopy a recapy</li>
            <li>🕺 registračný formulár na kurzy s uložením do storage</li>
            <li>🎟 landing pages pre festivaly, bootcampy a socials</li>
        </ul>
    </div>
</section>

<section class="section-grid three-up">
    <article class="card">
        <h2>Event calendar</h2>
        <p>Kalendár je navrhnutý ako centrálny funnel pre community socials, workshop weekends aj veľké festivaly.</p>
        <a href="<?= e(url('/events')) ?>">Otvoriť eventy →</a>
    </article>
    <article class="card">
        <h2>Galéria</h2>
        <p>Fotky sa dajú načítavať z Facebook albumov alebo nahrádzať vlastným médiovým úložiskom.</p>
        <a href="<?= e(url('/gallery')) ?>">Pozrieť galériu →</a>
    </article>
    <article class="card">
        <h2>Kurzy</h2>
        <p>Registrácie sú pripravené na ďalší krok: e-mail automation, CRM alebo WooCommerce checkout.</p>
        <a href="<?= e(url('/courses')) ?>">Prejsť na kurzy →</a>
    </article>
</section>

<section class="section">
    <div class="section-heading">
        <h2>Najbližšie eventy</h2>
        <a href="<?= e(url('/events')) ?>">Celý kalendár</a>
    </div>
    <div class="card-grid three-up">
        <?php foreach ($events as $event): ?>
            <article class="card event-card">
                <img src="<?= e($event['hero_image']) ?>" alt="<?= e($event['title']) ?>">
                <div class="meta"><?= e(format_datetime($event['date'])) ?> · <?= e($event['location']) ?></div>
                <h3><?= e($event['title']) ?></h3>
                <p><?= e($event['excerpt']) ?></p>
                <a href="<?= e(url('/events/' . $event['slug'])) ?>">Detail eventu →</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section-grid two-up">
    <div class="card">
        <div class="section-heading"><h2>Blog z workshopov</h2><a href="<?= e(url('/blog')) ?>">Všetky články</a></div>
        <?php foreach ($articles as $article): ?>
            <article class="stacked-item">
                <strong><?= e($article['title']) ?></strong>
                <p><?= e($article['excerpt']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
    <div class="card">
        <div class="section-heading"><h2>Event landing pages</h2><a href="<?= e(url('/landing-pages')) ?>">Všetky layouty</a></div>
        <?php foreach ($landingPages as $item): ?>
            <article class="stacked-item">
                <strong><?= e($item['title']) ?></strong>
                <p><?= e($item['subtitle']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
