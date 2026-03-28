<?php

declare(strict_types=1);

function facebook_graph_request(string $edge, array $query = []): ?array
{
    $config = app_config();
    if ($config['facebook_page_id'] === '' || $config['facebook_access_token'] === '') {
        return null;
    }

    $query['access_token'] = $config['facebook_access_token'];
    $url = sprintf(
        'https://graph.facebook.com/v19.0/%s/%s?%s',
        rawurlencode($config['facebook_page_id']),
        ltrim($edge, '/'),
        http_build_query($query)
    );

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 8,
            'ignore_errors' => true,
            'header' => "Accept: application/json\r\n",
        ],
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        return null;
    }

    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : null;
}

function facebook_events_feed(): array
{
    $response = facebook_graph_request('events', [
        'fields' => 'id,name,description,start_time,end_time,place,cover',
        'limit' => 12,
    ]);

    if (!isset($response['data']) || !is_array($response['data'])) {
        return sample_events();
    }

    $events = [];
    foreach ($response['data'] as $event) {
        if (!is_array($event) || empty($event['name']) || empty($event['start_time'])) {
            continue;
        }

        $slug = slugify($event['name']);
        $events[] = [
            'slug' => $slug,
            'title' => $event['name'],
            'excerpt' => trim((string)($event['description'] ?? '')) ?: 'Synchronizované z Facebook udalosti.',
            'date' => $event['start_time'],
            'end_date' => $event['end_time'] ?? null,
            'location' => $event['place']['name'] ?? 'Košice',
            'cta_label' => 'Otvoriť FB event',
            'cta_url' => 'https://www.facebook.com/events/' . ($event['id'] ?? ''),
            'hero_image' => $event['cover']['source'] ?? sample_placeholder('event'),
            'source' => 'facebook',
            'body' => nl2br(e((string)($event['description'] ?? 'Detaily budú doplnené z Facebook udalosti.'))),
            'highlights' => ['Automaticky načítané z FB stránky', 'Vhodné ako základ landing page', 'Možnosť doplniť registráciu alebo CTA'],
        ];
    }

    return $events !== [] ? $events : sample_events();
}

function facebook_albums_feed(): array
{
    $response = facebook_graph_request('albums', [
        'fields' => 'id,name,description,photos{images,name}',
        'limit' => 8,
    ]);

    if (!isset($response['data']) || !is_array($response['data'])) {
        return [];
    }

    $albums = [];
    foreach ($response['data'] as $album) {
        $photos = [];
        foreach (($album['photos']['data'] ?? []) as $photo) {
            $image = $photo['images'][0]['source'] ?? null;
            if ($image) {
                $photos[] = [
                    'src' => $image,
                    'alt' => $photo['name'] ?? ($album['name'] ?? 'Facebook album'),
                ];
            }
        }

        $albums[] = [
            'title' => $album['name'] ?? 'Facebook album',
            'description' => $album['description'] ?? 'Importované z Facebook albumu.',
            'cover' => $photos[0]['src'] ?? sample_placeholder('gallery'),
            'photos' => $photos !== [] ? $photos : [['src' => sample_placeholder('gallery'), 'alt' => 'Placeholder galéria']],
            'source' => 'facebook',
        ];
    }

    return $albums;
}

function instagram_feed(): array
{
    $config = app_config();
    $token = $config['instagram_access_token'] ?? '';
    if ($token === '') {
        return [];
    }

    // TODO: Implement Instagram Graph API integration
    // For now, returns empty array - will be expanded with API implementation
    return [];
}

function google_photos_feed(): array
{
    $config = app_config();
    $authFile = $config['google_service_account_file'] ?? '';
    if ($authFile === '' || !file_exists($authFile)) {
        return [];
    }

    // TODO: Implement Google Photos Library API integration
    // For now, returns empty array - will be expanded with API implementation
    return [];
}

function slugify(string $text): string
{
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text;
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?: '';
    return trim($text, '-') ?: 'item';
}

function sample_placeholder(string $type): string
{
    return match ($type) {
        'event' => 'https://images.unsplash.com/photo-1515169067868-5387ec356754?auto=format&fit=crop&w=1200&q=80',
        'gallery' => 'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?auto=format&fit=crop&w=1200&q=80',
        default => 'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?auto=format&fit=crop&w=1200&q=80',
    };
}
