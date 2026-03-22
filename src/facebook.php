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
        return content_collection('events');
    }

    $events = [];
    foreach ($response['data'] as $event) {
        if (!is_array($event) || empty($event['name']) || empty($event['start_time'])) {
            continue;
        }

        $events[] = [
            'slug' => slugify($event['name']),
            'title' => $event['name'],
            'excerpt' => trim((string) ($event['description'] ?? '')) ?: 'Synchronizovane z Facebook udalosti.',
            'date' => $event['start_time'],
            'end_date' => $event['end_time'] ?? null,
            'location' => $event['place']['name'] ?? 'Kosice',
            'cta_label' => 'Otvorit FB event',
            'cta_url' => 'https://www.facebook.com/events/' . ($event['id'] ?? ''),
            'hero_image' => $event['cover']['source'] ?? media_asset('event-weekender.svg'),
            'source' => 'facebook',
            'body' => nl2br(e((string) ($event['description'] ?? 'Detaily budu doplnene z Facebook udalosti.'))),
            'highlights' => ['Automaticky nacitane z FB stranky', 'Vhodne ako zaklad landing page', 'Moznost doplnit registraciu alebo CTA'],
        ];
    }

    return $events !== [] ? $events : content_collection('events');
}

function facebook_albums_feed(): array
{
    $response = facebook_graph_request('albums', [
        'fields' => 'id,name,description,photos{images,name}',
        'limit' => 8,
    ]);

    if (!isset($response['data']) || !is_array($response['data'])) {
        return content_collection('galleries');
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
            'description' => $album['description'] ?? 'Importovane z Facebook albumu.',
            'cover' => $photos[0]['src'] ?? media_asset('gallery-main.svg'),
            'photos' => $photos !== [] ? $photos : [['src' => media_asset('gallery-main.svg'), 'alt' => 'Galeria']],
            'source' => 'facebook',
        ];
    }

    return $albums !== [] ? $albums : content_collection('galleries');
}

function slugify(string $text): string
{
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text;
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?: '';
    return trim($text, '-') ?: 'item';
}
