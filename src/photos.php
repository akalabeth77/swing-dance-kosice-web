<?php

declare(strict_types=1);

/**
 * Photo and Album Management System
 * Handles manual photo uploads and gallery organization from multiple sources
 */

function load_galleries_data(): array
{
    return load_json_file('galleries.json');
}

function save_galleries_data(array $galleries): bool
{
    $file = __DIR__ . '/../storage/content/galleries.json';
    $json = json_encode($galleries, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }
    return file_put_contents($file, $json) !== false;
}

function create_album(string $title, string $description = '', string $source = 'manual'): array
{
    return [
        'id' => uniqid('album-'),
        'title' => $title,
        'description' => $description,
        'cover' => '',
        'photos' => [],
        'source' => $source,
        'created_at' => gmdate('c'),
        'updated_at' => gmdate('c'),
    ];
}

function add_photo_to_album(array &$album, string $src, string $alt = '', array $metadata = []): bool
{
    if (empty($src)) {
        return false;
    }

    $photo = [
        'id' => uniqid('photo-'),
        'src' => $src,
        'alt' => $alt ?: 'Photo',
        'metadata' => $metadata,
        'added_at' => gmdate('c'),
    ];

    $album['photos'][] = $photo;

    // Set cover if it's the first photo
    if ($album['cover'] === '') {
        $album['cover'] = $src;
    }

    $album['updated_at'] = gmdate('c');

    return true;
}

function remove_photo_from_album(array &$album, string $photoId): bool
{
    $found = false;
    foreach ($album['photos'] as $key => $photo) {
        if ($photo['id'] === $photoId) {
            unset($album['photos'][$key]);
            $found = true;
            break;
        }
    }

    if (!$found) {
        return false;
    }

    // Re-index array
    $album['photos'] = array_values($album['photos']);

    // Update cover if removed photo was the cover
    if ($album['cover'] === ($album['photos'][0]['src'] ?? '') || empty($album['photos'])) {
        $album['cover'] = $album['photos'][0]['src'] ?? '';
    }

    $album['updated_at'] = gmdate('c');

    return true;
}

function find_album(array $galleries, string $albumId): ?array
{
    foreach ($galleries as &$album) {
        if (($album['id'] ?? null) === $albumId) {
            return $album;
        }
    }
    return null;
}

function find_album_by_title(array $galleries, string $title): ?array
{
    foreach ($galleries as &$album) {
        if (($album['title'] ?? null) === $title) {
            return $album;
        }
    }
    return null;
}

function update_album(array &$galleries, string $albumId, array $updates): bool
{
    foreach ($galleries as &$album) {
        if (($album['id'] ?? null) === $albumId) {
            $allowedFields = ['title', 'description', 'source'];
            foreach ($allowedFields as $field) {
                if (isset($updates[$field])) {
                    $album[$field] = $updates[$field];
                }
            }
            $album['updated_at'] = gmdate('c');
            return true;
        }
    }
    return false;
}

function delete_album(array &$galleries, string $albumId): bool
{
    foreach ($galleries as $key => $album) {
        if (($album['id'] ?? null) === $albumId) {
            unset($galleries[$key]);
            $galleries = array_values($galleries);
            return true;
        }
    }
    return false;
}

function validate_image_url(string $url): bool
{
    // Basic validation: check if it's a valid URL
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    // Check for common image extensions or data URIs
    $path = parse_url($url, PHP_URL_PATH) ?: '';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    return in_array($extension, $allowedExtensions, true) || strpos($url, 'data:image') === 0;
}

function get_source_label(string $source): string
{
    return match ($source) {
        'facebook' => '📘 Facebook',
        'instagram' => '📱 Instagram',
        'google-photos' => '🖼️ Google Photos',
        'local-media' => '💾 Lokálne',
        'manual' => '✏️ Manuálne pridané',
        default => '📷 ' . ucfirst($source),
    };
}

function extract_facebook_album_id(string $url): ?string
{
    // Handle URLs like: https://www.facebook.com/media/set/?set=a.1392415856008569&type=3
    if (preg_match('/set=a\.(\d+)/', $url, $matches)) {
        return $matches[1];
    }
    // Handle alternative format: https://www.facebook.com/photo.php?fbid=...&set=a.1392415856008569
    if (preg_match('/set=a\.(\d+)/', $url, $matches)) {
        return $matches[1];
    }
    return null;
}

function import_facebook_album(string $albumId, string $albumTitle = '', string $albumDescription = ''): ?array
{
    $config = app_config();
    $fbPageId = $config['facebook_page_id'] ?? '';
    $fbToken = $config['facebook_access_token'] ?? '';

    if ($fbPageId === '' || $fbToken === '') {
        return null;
    }

    // Query Facebook API for album photos
    $url = sprintf(
        'https://graph.facebook.com/v19.0/%s/photos?fields=id,images,name,picture&access_token=%s&limit=100',
        rawurlencode($albumId),
        urlencode($fbToken)
    );

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 10,
            'ignore_errors' => true,
        ],
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        return null;
    }

    $data = json_decode($response, true);
    if (!isset($data['data']) || !is_array($data['data'])) {
        return null;
    }

    $photos = [];
    foreach ($data['data'] as $photo) {
        if (!isset($photo['images']) || !is_array($photo['images']) || empty($photo['images'])) {
            continue;
        }

        $images = $photo['images'];
        $imageSrc = $images[0]['source'] ?? null;
        if ($imageSrc === null) {
            continue;
        }

        $photos[] = [
            'id' => uniqid('photo-'),
            'src' => $imageSrc,
            'alt' => $photo['name'] ?? 'Facebook photo',
            'metadata' => [
                'source' => 'facebook',
                'fb_photo_id' => $photo['id'] ?? '',
            ],
            'added_at' => gmdate('c'),
        ];
    }

    if (empty($photos)) {
        return null;
    }

    // Create album with imported photos
    $album = [
        'id' => uniqid('album-'),
        'title' => $albumTitle ?: 'Facebook Album ' . gmdate('d.m.Y H:i'),
        'description' => $albumDescription ?: 'Importované z Facebook albumu ID: ' . $albumId,
        'cover' => $photos[0]['src'] ?? '',
        'photos' => $photos,
        'source' => 'facebook',
        'created_at' => gmdate('c'),
        'updated_at' => gmdate('c'),
    ];

    return $album;
}
