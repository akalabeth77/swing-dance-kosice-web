<section class="section-heading page-header">
    <div>
        <span class="eyebrow">Kurzy</span>
        <h1>Registracie na kurzy</h1>
        <p>Kazdy kurz ma vlastny detail, registracny formular a pripraveny follow-up na e-mail, CRM alebo checkout.</p>
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
            <a class="button primary" href="<?= e(url('/courses/' . $course['slug'] . '/register')) ?>">Registrovat sa</a>
        </article>
    <?php endforeach; ?>
</div>
