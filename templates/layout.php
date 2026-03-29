<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | <?= e(app_config()['site_name']) ?></title>
    <meta name="description" content="WordPress-like PHP starter pre Swing Dance Košice.">
    <link rel="stylesheet" href="<?= e(asset('styles.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= e(url('/')) ?>" aria-label="Swing Dance Košice">
            <img class="brand-logo" src="<?= e(asset('media/logo-swing-dance-kosice.svg')) ?>" alt="Swing Dance Košice logo">
        </a>
        <nav>
            <?php foreach ($navigation as $item): ?>
                <a href="<?= e(url($item['href'])) ?>"><?= e($item['label']) ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>

<main class="container page-shell">
    <?php if ($flash): ?>
        <div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>

    <?php include __DIR__ . '/' . $template . '.php'; ?>
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h3>Starter smerovanie</h3>
            <p>Architektúra je pripravená na migráciu do WordPress témy, custom pluginu alebo ľahkého PHP CMS a súbežnú prevádzku s Next.js vrstvou.</p>
        </div>
        <div>
            <h3>Integrácie zdrojov</h3>
            <p>Galérie: <code>local</code>, <code>facebook</code>, <code>google-photos</code>, <code>google-drive</code>, <code>instagram</code>. Eventy: <code>local</code>, <code>facebook</code>, <code>google-calendar</code>.</p>
        </div>
        <div>
            <h3>Komunita</h3>
            <a href="<?= e(app_config()['facebook_page_url']) ?>" target="_blank" rel="noreferrer">Facebook stránka</a>
        </div>
    </div>
</footer>
</body>
</html>
