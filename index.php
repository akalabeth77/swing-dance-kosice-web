<?php

declare(strict_types=1);

require __DIR__ . '/src/bootstrap.php';

$route = route_request(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

if ($route['type'] === 'course_registration_submit' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    handle_course_registration($route['slug']);
    return;
}

render_page($route);
