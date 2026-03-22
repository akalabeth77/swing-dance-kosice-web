<section class="section-grid two-up">
    <article class="card">
        <span class="eyebrow">Kurz registracia</span>
        <h1><?= e($course['title']) ?></h1>
        <p><?= e($course['description']) ?></p>
        <ul class="feature-list compact">
            <li><?= e($course['schedule']) ?></li>
            <li><?= e($course['location']) ?></li>
            <li><?= e($course['price']) ?></li>
            <li><?= e($course['spots']) ?></li>
        </ul>
        <h2>Benefity</h2>
        <ul class="feature-list compact">
            <?php foreach ($course['benefits'] as $benefit): ?>
                <li><?= e($benefit) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php if ($checkoutUrl !== ''): ?>
            <div class="integration-note">
                <strong>Checkout pripraveny</strong>
                <p>Po odoslani registracie moze pouzivatel pokracovat priamo na platbu.</p>
            </div>
        <?php endif; ?>
    </article>

    <form class="card form-card" method="post" action="<?= e(url('/courses/' . $course['slug'] . '/submit')) ?>">
        <h2>Prihlaska</h2>
        <?php if ($showSuccess): ?>
            <div class="flash flash-success inline-flash">
                Registracia bola prijata a ulozena.
                <?php if ($checkoutUrl !== ''): ?>
                    <div class="actions">
                        <a class="button primary" href="<?= e($checkoutUrl) ?>">Pokracovat na checkout</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <label>
            Meno a priezvisko
            <input type="text" name="name" required>
        </label>
        <label>
            E-mail
            <input type="email" name="email" required>
        </label>
        <label>
            Telefon
            <input type="text" name="phone">
        </label>
        <label>
            Tanecna rola
            <select name="dance_role">
                <option value="">Vyber si</option>
                <option value="lead">Lead</option>
                <option value="follow">Follow</option>
                <option value="switch">Switch</option>
            </select>
        </label>
        <label>
            Poznamka
            <textarea name="notes" rows="5" placeholder="Partner, skusenosti, otazky..."></textarea>
        </label>
        <button class="button primary" type="submit">Odoslat registraciu</button>
    </form>
</section>
