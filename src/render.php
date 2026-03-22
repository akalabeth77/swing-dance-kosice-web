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
        'gallery' => ['title' => 'Galeria', 'template' => 'gallery', 'galleries' => all_galleries()],
        'blog' => ['title' => 'Blog', 'template' => 'blog', 'articles' => blog_articles()],
        'article' => article_view($route['slug']),
        'courses' => ['title' => 'Registracie na kurzy', 'template' => 'courses', 'courses' => courses()],
        'course_registration' => course_registration_view($route['slug']),
        'landing_pages' => ['title' => 'Event landing pages', 'template' => 'landing-pages', 'landingPages' => landing_pages()],
        'landing_page' => landing_page_view($route['slug']),
        'admin' => admin_view(),
        default => ['title' => 'Stranka neexistuje', 'template' => '404'],
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
        : ['title' => 'Event nenajdeny', 'template' => '404'];
}

function article_view(string $slug): array
{
    $article = find_by_slug(blog_articles(), $slug);
    return $article
        ? ['title' => $article['title'], 'template' => 'article', 'article' => $article]
        : ['title' => 'Clanok nenajdeny', 'template' => '404'];
}

function course_registration_view(string $slug): array
{
    $course = find_by_slug(courses(), $slug);
    $showSuccess = ($_GET['submitted'] ?? '') === '1';
    $checkoutUrl = course_checkout_url($course ?? []);

    return $course
        ? [
            'title' => 'Registracia: ' . $course['title'],
            'template' => 'course-registration',
            'course' => $course,
            'showSuccess' => $showSuccess,
            'checkoutUrl' => $checkoutUrl,
        ]
        : ['title' => 'Kurz nenajdeny', 'template' => '404'];
}

function landing_page_view(string $slug): array
{
    $landingPage = find_by_slug(landing_pages(), $slug);
    return $landingPage
        ? ['title' => $landingPage['title'], 'template' => 'landing-page', 'landingPage' => $landingPage]
        : ['title' => 'Landing page nenajdena', 'template' => '404'];
}

function admin_view(): array
{
    return [
        'title' => 'Admin rozhranie',
        'template' => 'admin',
        ...admin_dashboard_data(),
    ];
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
        'id' => uniqid('reg_', true),
        'course' => $course['title'],
        'slug' => $slug,
        'name' => trim((string) ($_POST['name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
        'phone' => trim((string) ($_POST['phone'] ?? '')),
        'dance_role' => trim((string) ($_POST['dance_role'] ?? '')),
        'notes' => trim((string) ($_POST['notes'] ?? '')),
        'checkout_url' => course_checkout_url($course),
        'status' => 'new',
        'submitted_at' => gmdate('c'),
    ];

    if ($payload['name'] === '' || $payload['email'] === '') {
        set_flash('error', 'Meno a e-mail su povinne.');
        header('Location: ' . url('/courses/' . $slug . '/register'));
        exit;
    }

    $registrations = registrations();
    $registrations[] = $payload;
    file_put_contents(registrations_storage_path(), json_encode($registrations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $emailDelivered = send_registration_email($payload);
    $crmDelivered = send_registration_to_crm($payload);

    $message = 'Registracia bola ulozena do local storage.';
    if ($emailDelivered) {
        $message .= ' Notifikacia bola odoslana e-mailom.';
    }
    if ($crmDelivered) {
        $message .= ' Registracia bola odoslana aj do CRM webhooku.';
    }
    if ($payload['checkout_url'] !== '') {
        $message .= ' Dalsi krok moze pokracovat na checkout.';
    }

    set_flash('success', $message);
    header('Location: ' . url('/courses/' . $slug . '/register?submitted=1'));
    exit;
}

function course_checkout_url(array $course): string
{
    if (($course['checkout_url'] ?? '') !== '') {
        return (string) $course['checkout_url'];
    }

    return app_config()['checkout_url'];
}

function send_registration_email(array $payload): bool
{
    $recipient = app_config()['registration_email'];
    if ($recipient === '') {
        return false;
    }

    $subject = 'Nova registracia na kurz: ' . ($payload['course'] ?? 'Kurz');
    $message = implode("\n", [
        'Kurz: ' . ($payload['course'] ?? ''),
        'Meno: ' . ($payload['name'] ?? ''),
        'E-mail: ' . ($payload['email'] ?? ''),
        'Telefon: ' . ($payload['phone'] ?? ''),
        'Rola: ' . ($payload['dance_role'] ?? ''),
        'Poznamka: ' . ($payload['notes'] ?? ''),
        'Odoslane: ' . ($payload['submitted_at'] ?? ''),
    ]);

    return @mail($recipient, $subject, $message);
}

function send_registration_to_crm(array $payload): bool
{
    $url = app_config()['crm_webhook_url'];
    if ($url === '') {
        return false;
    }

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'timeout' => 8,
            'ignore_errors' => true,
            'header' => "Content-Type: application/json\r\nAccept: application/json\r\n",
            'content' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ],
    ]);

    $response = @file_get_contents($url, false, $context);
    return $response !== false;
}
