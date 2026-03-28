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
        'admin_photos' => ['title' => 'Správa Galérií', 'template' => 'admin-photos', 'galleries' => load_galleries_data(), 'editingAlbum' => null],
        'admin_photos_edit' => admin_photos_edit_view(),
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

function admin_photos_edit_view(): array
{
    $galleries = load_galleries_data();
    $albumId = $_GET['id'] ?? '';
    $album = null;

    foreach ($galleries as $gal) {
        if (($gal['id'] ?? null) === $albumId) {
            $album = $gal;
            break;
        }
    }

    return [
        'title' => $album ? 'Edit: ' . $album['title'] : 'Správa Galérií',
        'template' => 'admin-photos',
        'galleries' => $galleries,
        'editingAlbum' => $album,
    ];
}

function handle_admin_photos_create(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $title = trim((string)($_POST['title'] ?? ''));
    $description = trim((string)($_POST['description'] ?? ''));
    $source = trim((string)($_POST['source'] ?? 'manual'));

    if ($title === '') {
        set_flash('error', 'Názov albumu je povinný.');
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $galleries = load_galleries_data();
    $newAlbum = create_album($title, $description, $source);
    $galleries[] = $newAlbum;

    if (save_galleries_data($galleries)) {
        set_flash('success', 'Album bol vytvorený: ' . $title);
        header('Location: ' . url('/admin/photos/edit?id=' . urlencode($newAlbum['id'])));
    } else {
        set_flash('error', 'Nepodarilo sa uložiť album.');
        header('Location: ' . url('/admin/photos'));
    }
    exit;
}

function handle_admin_photos_update(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $albumId = trim((string)($_POST['id'] ?? ''));
    $title = trim((string)($_POST['title'] ?? ''));
    $description = trim((string)($_POST['description'] ?? ''));

    if ($albumId === '' || $title === '') {
        set_flash('error', 'Album ID a názov sú povinné.');
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $galleries = load_galleries_data();
    $updated = update_album($galleries, $albumId, [
        'title' => $title,
        'description' => $description,
    ]);

    if ($updated && save_galleries_data($galleries)) {
        set_flash('success', 'Album bol aktualizovaný.');
    } else {
        set_flash('error', 'Nepodarilo sa aktualizovať album.');
    }

    header('Location: ' . url('/admin/photos/edit?id=' . urlencode($albumId)));
    exit;
}

function handle_admin_photos_add_photo(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $albumId = trim((string)($_POST['album_id'] ?? ''));
    $src = trim((string)($_POST['src'] ?? ''));
    $alt = trim((string)($_POST['alt'] ?? ''));
    $source = trim((string)($_POST['source'] ?? 'manual'));

    if ($albumId === '' || $src === '' || !validate_image_url($src)) {
        set_flash('error', 'Album ID a validní URL fotky jsou povinné.');
        header('Location: ' . url('/admin/photos/edit?id=' . urlencode($albumId)));
        exit;
    }

    $galleries = load_galleries_data();
    $found = false;

    foreach ($galleries as &$album) {
        if (($album['id'] ?? null) === $albumId) {
            $metadata = ['source' => $source];
            if (add_photo_to_album($album, $src, $alt, $metadata)) {
                $found = true;
            }
            break;
        }
    }

    if ($found && save_galleries_data($galleries)) {
        set_flash('success', 'Fotka bola pridaná do albumu.');
    } else {
        set_flash('error', 'Nepodarilo sa pridať fotku.');
    }

    header('Location: ' . url('/admin/photos/edit?id=' . urlencode($albumId)));
    exit;
}

function handle_admin_photos_remove_photo(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $albumId = trim((string)($_POST['album_id'] ?? ''));
    $photoId = trim((string)($_POST['photo_id'] ?? ''));

    if ($albumId === '' || $photoId === '') {
        set_flash('error', 'Album ID a photo ID sú povinné.');
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $galleries = load_galleries_data();
    $found = false;

    foreach ($galleries as &$album) {
        if (($album['id'] ?? null) === $albumId) {
            if (remove_photo_from_album($album, $photoId)) {
                $found = true;
            }
            break;
        }
    }

    if ($found && save_galleries_data($galleries)) {
        set_flash('success', 'Fotka bola odstránená z albumu.');
    } else {
        set_flash('error', 'Nepodarilo sa odstrániť fotku.');
    }

    header('Location: ' . url('/admin/photos/edit?id=' . urlencode($albumId)));
    exit;
}

function handle_admin_photos_delete(): void
{
    $albumId = $_GET['id'] ?? '';
    $confirm = $_GET['confirm'] ?? '';

    if ($albumId === '') {
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    if ($confirm !== '1') {
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $galleries = load_galleries_data();

    if (delete_album($galleries, $albumId) && save_galleries_data($galleries)) {
        set_flash('success', 'Album bol odstránený.');
    } else {
        set_flash('error', 'Nepodarilo sa odstrániť album.');
    }

    header('Location: ' . url('/admin/photos'));
    exit;
}

function handle_admin_photos_import_facebook(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $fbUrl = trim((string)($_POST['fb_album_url'] ?? ''));
    $albumTitle = trim((string)($_POST['album_title'] ?? ''));
    $albumDescription = trim((string)($_POST['album_description'] ?? ''));

    if ($fbUrl === '') {
        set_flash('error', 'Facebook Album URL je povinný.');
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $albumId = extract_facebook_album_id($fbUrl);
    if ($albumId === null) {
        set_flash('error', 'Nepodarilo sa extrahovať ID albumu z URL. Skúste URL formátu: https://www.facebook.com/media/set/?set=a.XXXXX&type=3');
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $album = import_facebook_album($albumId, $albumTitle, $albumDescription);
    if ($album === null) {
        set_flash('error', 'Nepodarilo sa importovať Facebook album. Skontrolujte, či je FB token nakonfigurovaný a album je verejný.');
        header('Location: ' . url('/admin/photos'));
        exit;
    }

    $galleries = load_galleries_data();
    $galleries[] = $album;

    if (save_galleries_data($galleries)) {
        set_flash('success', 'Facebook album bol importovaný! Foto: ' . count($album['photos']));
        header('Location: ' . url('/admin/photos/edit?id=' . urlencode($album['id'])));
    } else {
        set_flash('error', 'Nepodarilo sa uložiť importovaný album.');
        header('Location: ' . url('/admin/photos'));
    }
    exit;
}
