<section class="section-heading page-header">
    <div>
        <span class="eyebrow">Galeria</span>
        <h1>Fotogaleria komunity</h1>
        <p>Albumy su pripravene na synchronizaciu z Facebook albumov alebo na vlastny lokalny media workflow v `assets/media`.</p>
    </div>
</section>

<section class="card section media-workflow">
    <div class="section-heading">
        <div>
            <h2>Media workflow</h2>
            <p>Namiesto externych placeholderov teraz stranka pouziva lokalne subory a galerie sa daju menit bez zasahu do sablon.</p>
        </div>
        <span class="status-badge status-active">Local media</span>
    </div>
    <p class="meta">Zdroj obrazkov: `assets/media` a odkazy v `storage/content/galleries.json`.</p>
</section>

<?php foreach ($galleries as $gallery): ?>
    <section class="section card">
        <div class="section-heading">
            <div>
                <h2><?= e($gallery['title']) ?></h2>
                <p><?= e($gallery['description']) ?></p>
            </div>
            <span class="meta">Zdroj: <?= e($gallery['source']) ?></span>
        </div>
        <div class="photo-grid">
            <?php foreach ($gallery['photos'] as $photo): ?>
                <figure>
                    <img src="<?= e($photo['src']) ?>" alt="<?= e($photo['alt']) ?>">
                </figure>
            <?php endforeach; ?>
        </div>
    </section>
<?php endforeach; ?>
