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
        <a class="brand" href="<?= e(url('/')) ?>">
            <img src="<?= e(asset('media/logo-swing-dance.svg')) ?>" alt="Swing Dance Košice">
            <span>Swing Dance Košice</span>
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
            <h3>🎉 Swing Dance Košice</h3>
            <p>Komunita swing tanečníkov z Košíc. Spolu sa učíme, tancujeme a zabávame sa!</p>
        </div>
        <div>
            <h3>📱 Nasleduj nás</h3>
            <p><a href="<?= e(app_config()['facebook_page_url']) ?>" target="_blank" rel="noreferrer">Facebook stránka</a></p>
            <p>Prihlás sa na naše akcie a buď súčasťou komunity.</p>
        </div>
        <div>
            <h3>🎵 Aktuálne</h3>
            <p>Sleduj najnovšie eventy, kurzy a galérie z našich stretnutí.</p>
        </div>
    </div>
</footer>
</body>
</html>
