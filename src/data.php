<?php

declare(strict_types=1);

function load_json_file(string $filename): array
{
    $file = __DIR__ . '/../storage/content/' . $filename;
    if (file_exists($file)) {
        try {
            $json = file_get_contents($file);
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            return is_array($data) ? $data : [];
        } catch (JsonException $e) {
            error_log('JSON decode error in ' . $filename . ': ' . $e->getMessage());
            return [];
        }
    }
    return [];
}

function site_navigation(): array
{
    return [
        ['label' => 'Domov', 'href' => '/'],
        ['label' => 'Eventy', 'href' => '/events'],
        ['label' => 'Galéria', 'href' => '/gallery'],
        ['label' => 'Blog', 'href' => '/blog'],
        ['label' => 'Kurzy', 'href' => '/courses'],
        ['label' => 'Landing pages', 'href' => '/landing-pages'],
    ];
}

function sample_events(): array
{
    return load_json_file('events.json');
}

function sample_galleries(): array
{
    return load_json_file('galleries.json');
}

function blog_articles(): array
{
    return load_json_file('articles.json');
}

function courses(): array
{
    return load_json_file('courses.json');
}

function landing_pages(): array
{
    return load_json_file('landing-pages.json');
}

function find_by_slug(array $items, string $slug): ?array
{
    foreach ($items as $item) {
        if (($item['slug'] ?? null) === $slug) {
            return $item;
        }
    }

    return null;
}

function all_events(): array
{
    return facebook_events_feed();
}

function all_galleries(): array
{
    return facebook_albums_feed();
}
