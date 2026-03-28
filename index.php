<?php

declare(strict_types=1);

require __DIR__ . '/src/bootstrap.php';

$route = route_request(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

if ($route['type'] === 'course_registration_submit' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    handle_course_registration($route['slug']);
    return;
}

// Handle admin photo routes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    match ($route['type']) {
        'admin_photos_create' => handle_admin_photos_create(),
        'admin_photos_update' => handle_admin_photos_update(),
        'admin_photos_add_photo' => handle_admin_photos_add_photo(),
        'admin_photos_remove_photo' => handle_admin_photos_remove_photo(),
        'admin_photos_import_facebook' => handle_admin_photos_import_facebook(),
        default => null,
    };
}

if (in_array($route['type'], ['admin_photos_delete'], true)) {
    match ($route['type']) {
        'admin_photos_delete' => handle_admin_photos_delete(),
        default => null,
    };
}

render_page($route);
