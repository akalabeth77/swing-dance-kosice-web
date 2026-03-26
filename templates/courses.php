<section class="section-heading page-header">
    <div>
        <span class="eyebrow">🕺 Kurzy</span>
        <h1>Registrácie na kurzy</h1>
        <p>Každý kurz má vlastný konverzný detail a registračný formulár. Dáta sa ukladajú do lokálneho storage súboru (merge-safe fallback mimo Vercel runtime).</p>
    </div>
</section>

<div class="card-grid two-up">
    <?php foreach ($courses as $course): ?>
        <article class="card">
            <h2><?= e($course['title']) ?></h2>
            <ul class="feature-list compact">
                <li><?= e($course['schedule']) ?></li>
                <li><?= e($course['location']) ?></li>
                <li><?= e($course['price']) ?></li>
                <li><?= e($course['spots']) ?></li>
            </ul>
            <p><?= e($course['description']) ?></p>
            <a class="button primary" href="<?= e(url('/courses/' . $course['slug'] . '/register')) ?>">Registrovať sa</a>
        </article>
    <?php endforeach; ?>
</div>
