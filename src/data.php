<?php

declare(strict_types=1);

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
    return [
        [
            'slug' => 'spring-swing-weekender',
            'title' => 'Spring Swing Weekender',
            'excerpt' => 'Víkend plný social dancingu, workshopov a live music pre komunitu v Košiciach.',
            'date' => '2026-04-17 18:00:00',
            'end_date' => '2026-04-19 23:00:00',
            'location' => 'Kasárne Kulturpark, Košice',
            'cta_label' => 'Kúpiť pass',
            'cta_url' => '/landing-pages/spring-swing-weekender',
            'hero_image' => sample_placeholder('event'),
            'source' => 'local',
            'body' => '<p>Starter obsahuje plnohodnotnú event landing page, CTA bloky, FAQ, harmonogram aj prepojenie na registrácie.</p><p>Ak doplníš Facebook Graph API token, táto sekcia vie ťahať názov, dátum, popis aj cover obrázok priamo z FB eventu.</p>',
            'highlights' => ['3 dni workshopov a parties', 'Live band + taster class', 'Možnosť upsellu na full pass'],
        ],
        [
            'slug' => 'solo-jazz-bootcamp',
            'title' => 'Solo Jazz Bootcamp',
            'excerpt' => 'Intenzívny workshop pre tanečníkov, ktorí chcú zlepšiť rytmus, groove a stage presence.',
            'date' => '2026-05-09 10:00:00',
            'end_date' => '2026-05-10 17:00:00',
            'location' => 'Tabačka Kulturfabrik, Košice',
            'cta_label' => 'Rezervovať miesto',
            'cta_url' => '/landing-pages/solo-jazz-bootcamp',
            'hero_image' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&w=1200&q=80',
            'source' => 'local',
            'body' => '<p>Bootcamp landing page môže obsahovať biá lektorov, video highlighty, cenové balíčky a countdown.</p>',
            'highlights' => ['2 levely', 'Video recap po akcii', 'Early bird pricing'],
        ],
    ];
}

function sample_galleries(): array
{
    return [
        [
            'title' => 'Winter Swing Ball 2025',
            'description' => 'Ukážka albumu prepojeného na Facebook album alebo vlastnú fotogalériu.',
            'cover' => 'https://images.unsplash.com/photo-1521334884684-d80222895322?auto=format&fit=crop&w=1200&q=80',
            'photos' => [
                ['src' => 'https://images.unsplash.com/photo-1516307365426-bea591f05011?auto=format&fit=crop&w=900&q=80', 'alt' => 'Social dancing'],
                ['src' => 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?auto=format&fit=crop&w=900&q=80', 'alt' => 'Band na pódiu'],
                ['src' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=900&q=80', 'alt' => 'Tanec v páre'],
            ],
            'source' => 'local',
        ],
        [
            'title' => 'Workshop Weekend',
            'description' => 'Galéria je pripravená na sekcie highlightov, carousel aj album feed.',
            'cover' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?auto=format&fit=crop&w=1200&q=80',
            'photos' => [
                ['src' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80', 'alt' => 'Workshop skupina'],
                ['src' => 'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=900&q=80', 'alt' => 'Lektori'],
            ],
            'source' => 'local',
        ],
    ];
}

function blog_articles(): array
{
    return [
        [
            'slug' => 'ako-pripravit-workshop-weekend',
            'title' => 'Ako pripraviť workshop weekend pre swing komunitu',
            'date' => '2026-02-10',
            'excerpt' => 'Krátky editorial formát pre recap, promo ďalšieho eventu a SEO obsah.',
            'cover' => sample_placeholder('gallery'),
            'body' => '<p>Tento starter počíta s blog sekciou pre recapy workshopov, rozhovory s lektormi aj evergreen obsah. Články sú pripravené ako statické PHP dáta, ale štruktúra je veľmi blízka WordPress custom post types.</p><p>Môžeš ich neskôr presunúť do databázy, ACF polí alebo headless CMS bez zásadnej zmeny frontendu.</p>',
            'tags' => ['Workshopy', 'Komunita', 'SEO'],
        ],
        [
            'slug' => 'preco-mat-event-landing-pages',
            'title' => 'Prečo mať samostatné landing pages pre eventy',
            'date' => '2026-01-18',
            'excerpt' => 'Landing page zvyšuje konverzie a zjednodušuje zdieľanie eventu na sociálnych sieťach.',
            'cover' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
            'body' => '<p>Každý väčší event by mal mať vlastnú stránku s benefitmi, programom, cenami a FAQ. V tomto starteri sú landing pages oddelené od všeobecného kalendára, aby si vedel rýchlo pripraviť promo pre workshop weekend alebo festival.</p>',
            'tags' => ['Marketing', 'Eventy'],
        ],
    ];
}

function courses(): array
{
    return [
        [
            'slug' => 'lindy-hop-zaciatocnici',
            'title' => 'Lindy Hop Začiatočníci',
            'schedule' => 'Každý utorok 18:00 – 19:15',
            'location' => 'Kulturpark, Košice',
            'price' => '79 € / 8 týždňov',
            'spots' => '12 párov voľných miest',
            'description' => 'Kurz s dôrazom na groove, partnering a komunitnú atmosféru. Registrácia sa zapisuje do JSON storage a dá sa ľahko napojiť na e-mail, CRM alebo WooCommerce.',
            'benefits' => ['8 lekcií', 'Prístup na practice night', 'Checklist pre nováčikov'],
        ],
        [
            'slug' => 'collegiate-shag-open',
            'title' => 'Collegiate Shag Open',
            'schedule' => 'Každý štvrtok 19:30 – 20:45',
            'location' => 'Tabačka Kulturfabrik',
            'price' => '89 € / 8 týždňov',
            'spots' => 'Open level',
            'description' => 'Energetický kurz pre tanečníkov, ktorí chcú rýchle nohy, musicality a show-ready figúry.',
            'benefits' => ['Technika kick-step', 'Partnering drills', 'Mini choreo'],
        ],
    ];
}

function landing_pages(): array
{
    return [
        [
            'slug' => 'spring-swing-weekender',
            'title' => 'Spring Swing Weekender',
            'subtitle' => 'Víkendový event funnel s hero sekciou, benefitmi, harmonogramom a CTA.',
            'hero_image' => sample_placeholder('event'),
            'price' => 'Full pass od 69 €',
            'cta_label' => 'Chcem full pass',
            'cta_url' => '#pricing',
            'highlights' => ['Live band party', '3 tracks workshopov', 'Beginner-friendly onboarding'],
            'schedule' => [
                ['day' => 'Piatok', 'items' => ['Check-in + welcome mixer', 'Taster class', 'Party do 02:00']],
                ['day' => 'Sobota', 'items' => ['Workshop blocks', 'Teacher battle', 'Live music night']],
                ['day' => 'Nedeľa', 'items' => ['Brunch social', 'Final classes', 'Community jam']],
            ],
            'faq' => [
                ['question' => 'Dá sa kúpiť aj party pass?', 'answer' => 'Áno, landing page počíta s viacerými cenovými úrovňami.'],
                ['question' => 'Ako prepojiť checkout?', 'answer' => 'CTA môže smerovať na WooCommerce, Stripe Checkout alebo externý formulár.'],
            ],
        ],
        [
            'slug' => 'solo-jazz-bootcamp',
            'title' => 'Solo Jazz Bootcamp',
            'subtitle' => 'Jednostránkový layout pre intenzívny workshop s lektormi a jasnou konverznou cestou.',
            'hero_image' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&w=1200&q=80',
            'price' => 'Weekend pass od 49 €',
            'cta_label' => 'Rezervovať miesto',
            'cta_url' => '/courses/lindy-hop-zaciatocnici/register',
            'highlights' => ['2 dni tréningu', 'Video feedback', 'Solo challenge showcase'],
            'schedule' => [
                ['day' => 'Sobota', 'items' => ['Warm-up', 'Rhythm lab', 'Combo rehearsal']],
                ['day' => 'Nedeľa', 'items' => ['Groove clinic', 'Stage drills', 'Performance circle']],
            ],
            'faq' => [
                ['question' => 'Je kurz vhodný aj pre začiatočníkov?', 'answer' => 'Áno, ak už máš základný pohybový komfort a chuť makať.'],
            ],
        ],
    ];
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
