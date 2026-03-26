<section class="section-heading page-header">
    <div>
        <span class="eyebrow">📷 Galéria</span>
        <h1>Fotogaléria komunity</h1>
        <p>Albumy sú pripravené na synchronizáciu z Facebook albumov alebo neskôr z WordPress media library, s fallback dátami.</p>
    </div>
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
