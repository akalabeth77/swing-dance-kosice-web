<section class="hero">
    <div>
        <span class="eyebrow">Starter s content vrstvou</span>
        <h1>Web pre swing komunitu uz bezi na lokalnom obsahu, registraciach a admin prehlade.</h1>
        <p>Demo arrays su presunute do editovatelnych JSON kolekcii, registracie maju pripravene integracie a galerie uz pouzivaju lokalne media subory.</p>
        <div class="actions">
            <a class="button primary" href="<?= e(url('/events')) ?>">Pozriet eventy</a>
            <a class="button" href="<?= e(url('/admin')) ?>">Otvorit admin</a>
        </div>
    </div>
    <div class="card spotlight">
        <h2>Co je hotove teraz</h2>
        <ul class="feature-list">
            <li>obsah sa nacitava z JSON kolekcii v `storage/content`</li>
            <li>registracie sa ukladaju do `storage/registrations.json` a vedia posielat e-mail</li>
            <li>CRM webhook a checkout su pripravene cez konfiguraciu</li>
            <li>admin stranka ukazuje stav obsahu, integracii a poslednych prihlasok</li>
            <li>vsetky placeholder media idu lokalne z `assets/media`</li>
        </ul>
    </div>
</section>

<section class="section-grid three-up">
    <article class="card">
        <h2>Event calendar</h2>
        <p>Kalendar je navrhnuty ako centralny funnel pre community socials, workshop weekends aj vacsie festivaly.</p>
        <a href="<?= e(url('/events')) ?>">Otvorit eventy →</a>
    </article>
    <article class="card">
        <h2>Galeria</h2>
        <p>Fotky sa mozu nacitavat z Facebook albumov alebo spravovat lokalne ako vlastna media kniznica.</p>
        <a href="<?= e(url('/gallery')) ?>">Pozriet galeriu →</a>
    </article>
    <article class="card">
        <h2>Kurzy</h2>
        <p>Registracie su pripravene na dalsi krok: e-mail automation, CRM webhook alebo checkout flow.</p>
        <a href="<?= e(url('/courses')) ?>">Prejst na kurzy →</a>
    </article>
</section>

<section class="section">
    <div class="section-heading">
        <h2>Najblizsie eventy</h2>
        <a href="<?= e(url('/events')) ?>">Cely kalendar</a>
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
        <div class="section-heading"><h2>Blog z workshopov</h2><a href="<?= e(url('/blog')) ?>">Vsetky clanky</a></div>
        <?php foreach ($articles as $article): ?>
            <article class="stacked-item">
                <strong><?= e($article['title']) ?></strong>
                <p><?= e($article['excerpt']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
    <div class="card">
        <div class="section-heading"><h2>Admin a landing pages</h2><a href="<?= e(url('/admin')) ?>">Otvorit admin</a></div>
        <?php foreach ($landingPages as $item): ?>
            <article class="stacked-item">
                <strong><?= e($item['title']) ?></strong>
                <p><?= e($item['subtitle']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
