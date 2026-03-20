<section class="section-heading page-header">
    <div>
        <span class="eyebrow">🎟 Landing pages</span>
        <h1>Hotové event landing page šablóny</h1>
        <p>Každá landing page má hero sekciu, benefitové bloky, harmonogram, FAQ a CTA na nákup alebo registráciu.</p>
    </div>
</section>

<div class="card-grid two-up">
    <?php foreach ($landingPages as $item): ?>
        <article class="card">
            <h2><?= e($item['title']) ?></h2>
            <p><?= e($item['subtitle']) ?></p>
            <ul class="feature-list compact">
                <?php foreach ($item['highlights'] as $highlight): ?>
                    <li><?= e($highlight) ?></li>
                <?php endforeach; ?>
            </ul>
            <a class="button primary" href="<?= e(url('/landing-pages/' . $item['slug'])) ?>">Otvoriť landing page</a>
        </article>
    <?php endforeach; ?>
</div>
