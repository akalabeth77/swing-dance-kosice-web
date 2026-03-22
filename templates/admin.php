<section class="section-heading page-header">
    <div>
        <span class="eyebrow">Admin</span>
        <h1>Zakladne admin rozhranie</h1>
        <p>Prehlad obsahu, registracii a integracii na jednom mieste. Vhodne ako medzikrok pred WordPress adminom alebo custom CMS.</p>
    </div>
</section>

<section class="section">
    <div class="card-grid three-up">
        <?php foreach ($contentStats as $stat): ?>
            <article class="card stat-card">
                <div class="meta"><?= e($stat['label']) ?></div>
                <strong class="stat-value"><?= e((string) $stat['count']) ?></strong>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section-grid two-up">
    <article class="card">
        <div class="section-heading">
            <h2>Stav integracii</h2>
        </div>
        <div class="stack-list">
            <?php foreach ($integrations as $integration): ?>
                <div class="stacked-item integration-item">
                    <div class="section-heading">
                        <strong><?= e($integration['label']) ?></strong>
                        <span class="status-badge status-<?= e($integration['status']) ?>"><?= e($integration['status']) ?></span>
                    </div>
                    <p><?= e($integration['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="card">
        <div class="section-heading">
            <h2>Kde sa co spravuje</h2>
        </div>
        <ul class="feature-list compact">
            <li>Obsah kolekcii: `storage/content/*.json`</li>
            <li>Prihlasky: `storage/registrations.json`</li>
            <li>Media subory: `assets/media/*`</li>
            <li>E-mail notifikacie: `REGISTRATION_EMAIL`</li>
            <li>CRM webhook: `CRM_WEBHOOK_URL`</li>
            <li>Checkout fallback: `DEFAULT_CHECKOUT_URL`</li>
        </ul>
    </article>
</section>

<section class="section">
    <div class="section-heading">
        <h2>Posledne registracie</h2>
    </div>
    <div class="card">
        <?php if ($recentRegistrations === []): ?>
            <p class="meta">Zatial tu nie su ziadne registracie.</p>
        <?php else: ?>
            <div class="stack-list">
                <?php foreach ($recentRegistrations as $registration): ?>
                    <article class="stacked-item registration-item">
                        <div class="section-heading">
                            <strong><?= e($registration['name'] ?? 'Bez mena') ?></strong>
                            <span class="meta"><?= e(format_datetime($registration['submitted_at'] ?? '')) ?></span>
                        </div>
                        <p><?= e($registration['course'] ?? '') ?> · <?= e($registration['email'] ?? '') ?></p>
                        <?php if (($registration['checkout_url'] ?? '') !== ''): ?>
                            <a href="<?= e($registration['checkout_url']) ?>">Checkout link</a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
