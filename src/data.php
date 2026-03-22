<?php

declare(strict_types=1);

function site_navigation(): array
{
    return [
        ['label' => 'Domov', 'href' => '/'],
        ['label' => 'Eventy', 'href' => '/events'],
        ['label' => 'Galeria', 'href' => '/gallery'],
        ['label' => 'Blog', 'href' => '/blog'],
        ['label' => 'Kurzy', 'href' => '/courses'],
        ['label' => 'Landing pages', 'href' => '/landing-pages'],
        ['label' => 'Admin', 'href' => '/admin'],
    ];
}

function content_collection(string $name): array
{
    $path = app_config()['content_path'] . '/' . $name . '.json';
    if (!is_file($path)) {
        return [];
    }

    $decoded = json_decode((string) file_get_contents($path), true);
    if (!is_array($decoded)) {
        return [];
    }

    return array_map(
        static fn (array $item): array => hydrate_content_item($item),
        array_values(array_filter($decoded, 'is_array'))
    );
}

function hydrate_content_item(array $item): array
{
    foreach (['hero_image', 'cover'] as $field) {
        if (isset($item[$field]) && is_string($item[$field])) {
            $item[$field] = normalize_media_reference($item[$field]);
        }
    }

    if (isset($item['photos']) && is_array($item['photos'])) {
        $item['photos'] = array_map(
            static function (array $photo): array {
                if (isset($photo['src']) && is_string($photo['src'])) {
                    $photo['src'] = normalize_media_reference($photo['src']);
                }

                return $photo;
            },
            array_values(array_filter($item['photos'], 'is_array'))
        );
    }

    return $item;
}

function normalize_media_reference(string $value): string
{
    if (preg_match('#^(https?:)?//#', $value) === 1 || str_starts_with($value, '/')) {
        return $value;
    }

    return media_asset($value);
}

function blog_articles(): array
{
    return content_collection('articles');
}

function courses(): array
{
    return content_collection('courses');
}

function landing_pages(): array
{
    return content_collection('landing-pages');
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

function registrations_storage_path(): string
{
    return app_config()['storage_path'] . '/registrations.json';
}

function registrations(): array
{
    $storagePath = registrations_storage_path();
    if (!is_file($storagePath)) {
        return [];
    }

    $decoded = json_decode((string) file_get_contents($storagePath), true);
    return is_array($decoded) ? $decoded : [];
}

function admin_dashboard_data(): array
{
    $registrations = array_reverse(registrations());

    return [
        'contentStats' => [
            ['label' => 'Eventy', 'count' => count(content_collection('events'))],
            ['label' => 'Galerie', 'count' => count(content_collection('galleries'))],
            ['label' => 'Clanky', 'count' => count(blog_articles())],
            ['label' => 'Kurzy', 'count' => count(courses())],
            ['label' => 'Landing pages', 'count' => count(landing_pages())],
            ['label' => 'Registracie', 'count' => count($registrations)],
        ],
        'recentRegistrations' => array_slice($registrations, 0, 8),
        'integrations' => [
            [
                'label' => 'Obsahova vrstva',
                'status' => 'active',
                'description' => 'Web cita eventy, kurzy, clanky a landing pages z JSON kolekcii v storage/content.',
            ],
            [
                'label' => 'E-mail notifikacie',
                'status' => app_config()['registration_email'] !== '' ? 'active' : 'pending',
                'description' => app_config()['registration_email'] !== ''
                    ? 'Registracie sa po odoslani posielaju aj na nastavenu e-mailovu adresu.'
                    : 'Nastav REGISTRATION_EMAIL a admin dostane notifikaciu po odoslani formulara.',
            ],
            [
                'label' => 'CRM webhook',
                'status' => app_config()['crm_webhook_url'] !== '' ? 'active' : 'pending',
                'description' => app_config()['crm_webhook_url'] !== ''
                    ? 'Payload z registracie sa odosiela aj do externeho CRM webhooku.'
                    : 'Nastav CRM_WEBHOOK_URL pre odosielanie registracii do CRM alebo automatizacie.',
            ],
            [
                'label' => 'Checkout flow',
                'status' => app_config()['checkout_url'] !== '' ? 'active' : 'pending',
                'description' => app_config()['checkout_url'] !== ''
                    ? 'Po registracii je pripraveny pokracujuci krok na checkout.'
                    : 'Nastav DEFAULT_CHECKOUT_URL alebo checkout_url priamo ku konkretnemu kurzu.',
            ],
            [
                'label' => 'Media library',
                'status' => 'active',
                'description' => 'Starter pouziva lokalne media subory v assets/media namiesto externych placeholderov.',
            ],
        ],
    ];
}
