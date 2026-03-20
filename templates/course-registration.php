<section class="section-grid two-up">
    <article class="card">
        <span class="eyebrow">Kurz registrácia</span>
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
    </article>

    <form class="card form-card" method="post" action="<?= e(url('/courses/' . $course['slug'] . '/submit')) ?>">
        <h2>Prihláška</h2>
        <label>
            Meno a priezvisko
            <input type="text" name="name" required>
        </label>
        <label>
            E-mail
            <input type="email" name="email" required>
        </label>
        <label>
            Telefón
            <input type="text" name="phone">
        </label>
        <label>
            Tanečná rola
            <select name="dance_role">
                <option value="">Vyber si</option>
                <option value="lead">Lead</option>
                <option value="follow">Follow</option>
                <option value="switch">Switch</option>
            </select>
        </label>
        <label>
            Poznámka
            <textarea name="notes" rows="5" placeholder="Partner, skúsenosti, otázky..."></textarea>
        </label>
        <button class="button primary" type="submit">Odoslať registráciu</button>
    </form>
</section>
