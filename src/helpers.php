<?php

declare(strict_types=1);

function app_config(): array
{
    return [
        'site_name' => 'Swing Dance Košice',
        'base_url' => rtrim($_ENV['APP_URL'] ?? getenv('APP_URL') ?: '', '/'),
        'facebook_page_id' => $_ENV['FB_PAGE_ID'] ?? getenv('FB_PAGE_ID') ?: '',
        'facebook_access_token' => $_ENV['FB_ACCESS_TOKEN'] ?? getenv('FB_ACCESS_TOKEN') ?: '',
        'facebook_page_url' => $_ENV['FB_PAGE_URL'] ?? getenv('FB_PAGE_URL') ?: 'https://www.facebook.com/swingdancekosice',
        'storage_path' => __DIR__ . '/../storage',
    ];
}

function route_request(string $path): array
{
    $cleanPath = '/' . trim($path, '/');
    if ($cleanPath === '//') {
        $cleanPath = '/';
    }

    return match (true) {
        $cleanPath === '/' => ['type' => 'home'],
        $cleanPath === '/events' => ['type' => 'events'],
        preg_match('#^/events/([a-z0-9-]+)$#', $cleanPath, $matches) === 1 => ['type' => 'event', 'slug' => $matches[1]],
        $cleanPath === '/gallery' => ['type' => 'gallery'],
        $cleanPath === '/blog' => ['type' => 'blog'],
        preg_match('#^/blog/([a-z0-9-]+)$#', $cleanPath, $matches) === 1 => ['type' => 'article', 'slug' => $matches[1]],
        $cleanPath === '/courses' => ['type' => 'courses'],
        preg_match('#^/courses/([a-z0-9-]+)/register$#', $cleanPath, $matches) === 1 => ['type' => 'course_registration', 'slug' => $matches[1]],
        preg_match('#^/courses/([a-z0-9-]+)/submit$#', $cleanPath, $matches) === 1 => ['type' => 'course_registration_submit', 'slug' => $matches[1]],
        $cleanPath === '/landing-pages' => ['type' => 'landing_pages'],
        preg_match('#^/landing-pages/([a-z0-9-]+)$#', $cleanPath, $matches) === 1 => ['type' => 'landing_page', 'slug' => $matches[1]],
        default => ['type' => '404'],
    };
}

function url(string $path): string
{
    $baseUrl = app_config()['base_url'];
    return $baseUrl === '' ? $path : $baseUrl . $path;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function asset(string $path): string
{
    return url('/assets/' . ltrim($path, '/'));
}

function format_date(string $date): string
{
    $timestamp = strtotime($date);
    return $timestamp ? date('j. n. Y', $timestamp) : $date;
}

function format_datetime(string $date): string
{
    $timestamp = strtotime($date);
    return $timestamp ? date('j. n. Y H:i', $timestamp) : $date;
}

function current_flash(): ?array
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return is_array($flash) ? $flash : null;
}

function set_flash(string $type, string $message): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}


function ensure_storage_ready(): void
{
    $storagePath = app_config()['storage_path'];
    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0775, true);
    }

    $registrationsFile = $storagePath . '/registrations.json';
    if (!is_file($registrationsFile)) {
        file_put_contents($registrationsFile, "[]\n");
    }
}

