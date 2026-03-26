<?php

declare(strict_types=1);

function render_page(array $route): void
{
    $flash = current_flash();
    $navigation = site_navigation();

    $viewData = match ($route['type']) {
        'home' => [
            'title' => 'PHP starter pre swing komunitu',
            'template' => 'home',
            'events' => array_slice(all_events(), 0, 3),
            'galleries' => array_slice(all_galleries(), 0, 2),
            'articles' => array_slice(blog_articles(), 0, 2),
            'courses' => array_slice(courses(), 0, 2),
            'landingPages' => array_slice(landing_pages(), 0, 2),
        ],
        'events' => ['title' => 'Event calendar', 'template' => 'events', 'events' => all_events()],
        'event' => event_view($route['slug']),
        'gallery' => ['title' => 'Galéria', 'template' => 'gallery', 'galleries' => all_galleries()],
        'blog' => ['title' => 'Blog', 'template' => 'blog', 'articles' => blog_articles()],
        'article' => article_view($route['slug']),
        'courses' => ['title' => 'Registrácie na kurzy', 'template' => 'courses', 'courses' => courses()],
        'course_registration' => course_registration_view($route['slug']),
        'landing_pages' => ['title' => 'Event landing pages', 'template' => 'landing-pages', 'landingPages' => landing_pages()],
        'landing_page' => landing_page_view($route['slug']),
        default => ['title' => 'Stránka neexistuje', 'template' => '404'],
    };

    $template = $viewData['template'];
    unset($viewData['template']);

    if ($template === '404') {
        http_response_code(404);
    }

    extract($viewData, EXTR_SKIP);
    $pageTitle = $title ?? app_config()['site_name'];

    include __DIR__ . '/../templates/layout.php';
}

function event_view(string $slug): array
{
    $event = find_by_slug(all_events(), $slug);
    return $event
        ? ['title' => $event['title'], 'template' => 'event', 'event' => $event]
        : ['title' => 'Event nenájdený', 'template' => '404'];
}

function article_view(string $slug): array
{
    $article = find_by_slug(blog_articles(), $slug);
    return $article
        ? ['title' => $article['title'], 'template' => 'article', 'article' => $article]
        : ['title' => 'Článok nenájdený', 'template' => '404'];
}

function course_registration_view(string $slug): array
{
    $course = find_by_slug(courses(), $slug);
    return $course
        ? ['title' => 'Registrácia: ' . $course['title'], 'template' => 'course-registration', 'course' => $course]
        : ['title' => 'Kurz nenájdený', 'template' => '404'];
}

function landing_page_view(string $slug): array
{
    $landingPage = find_by_slug(landing_pages(), $slug);
    return $landingPage
        ? ['title' => $landingPage['title'], 'template' => 'landing-page', 'landingPage' => $landingPage]
        : ['title' => 'Landing page nenájdená', 'template' => '404'];
}

function handle_course_registration(string $slug): void
{
    $course = find_by_slug(courses(), $slug);
    if (!$course) {
        http_response_code(404);
        echo 'Kurz neexistuje.';
        return;
    }

    $payload = [
        'course' => $course['title'],
        'slug' => $slug,
        'name' => trim((string)($_POST['name'] ?? '')),
        'email' => trim((string)($_POST['email'] ?? '')),
        'phone' => trim((string)($_POST['phone'] ?? '')),
        'dance_role' => trim((string)($_POST['dance_role'] ?? '')),
        'notes' => trim((string)($_POST['notes'] ?? '')),
        'submitted_at' => gmdate('c'),
    ];

    if ($payload['name'] === '' || $payload['email'] === '') {
        set_flash('error', 'Meno a e-mail sú povinné.');
        header('Location: ' . url('/courses/' . $slug . '/register'));
        exit;
    }

    ensure_storage_ready();
    $storagePath = app_config()['storage_path'] . '/registrations.json';
    $registrations = [];

    if (is_file($storagePath)) {
        $decoded = json_decode((string)file_get_contents($storagePath), true);
        if (is_array($decoded)) {
            $registrations = $decoded;
        }
    }

    $registrations[] = $payload;
    $written = file_put_contents($storagePath, json_encode($registrations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    if ($written === false) {
        set_flash('error', 'Registráciu sa nepodarilo uložiť, skús to prosím znova.');
        header('Location: ' . url('/courses/' . $slug . '/register'));
        exit;
    }

    set_flash('success', 'Registrácia bola uložená do starter storage.');
    header('Location: ' . url('/courses/' . $slug . '/register'));
    exit;
}
