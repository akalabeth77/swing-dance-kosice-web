<section class="section-heading page-header">
    <div>
        <span class="eyebrow">📷 Galéria</span>
        <h1>Fotogaléria komunity</h1>
        <p>Albumy sú pripravené na synchronizáciu z Facebook albumov, Instagram albumu, Google Photos a neskôr z vlastnej media library.</p>
    </div>
</section>

<?php foreach ($galleries as $gallery): ?>
    <section class="section card">
        <div class="section-heading">
            <div>
                <h2><?= e($gallery['title']) ?></h2>
                <p><?= e($gallery['description']) ?></p>
            </div>
            <span class="meta">
                <?php 
                    $sourceLabel = match($gallery['source'] ?? 'local') {
                        'facebook' => '📘 Facebook',
                        'instagram' => '📱 Instagram',
                        'google-photos' => '🖼️ Google Photos',
                        'local-media' => '💾 Lokálne',
                        default => e($gallery['source'] ?? 'Neznámy zdroj'),
                    };
                    echo $sourceLabel;
                ?>
            </span>
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
