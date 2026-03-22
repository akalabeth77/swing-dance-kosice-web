# Swing Dance Kosice PHP Starter

WordPress-like PHP starter pre swing komunitu Swing Dance Kosice.

## Co starter obsahuje

- Event calendar pripraveny na nacitanie dat z Facebook udalosti cez Graph API.
- Galeriu s fallback obsahom a moznostou synchronizacie z Facebook albumov.
- Blog pre workshopy, recapy a komunitny obsah.
- Registracie na kurzy cez PHP formular ukladajuci data do `storage/registrations.json`.
- Event landing pages s hero sekciou, benefitmi, harmonogramom a FAQ.
- Zakladne admin rozhranie na `/admin`.

## Preco "WordPress-like"

Tento repozitar nie je plna instalacia WordPressu. Je to lahky PHP starter s architekturou, ktoru vies neskor presunut do:

- WordPress temy,
- custom pluginu,
- ACF/Gutenberg blokov,
- alebo vlastneho maleho PHP CMS.

## Spustenie lokalne

```bash
php -S 127.0.0.1:8080 router.php
```

Potom otvor:

- `http://127.0.0.1:8080/`
- `http://127.0.0.1:8080/events`
- `http://127.0.0.1:8080/gallery`
- `http://127.0.0.1:8080/blog`
- `http://127.0.0.1:8080/courses`
- `http://127.0.0.1:8080/landing-pages`
- `http://127.0.0.1:8080/admin`

## Facebook integracia

Ak chces tahat eventy a albumy z Facebooku, nastav env premenne:

```bash
export FB_PAGE_ID="..."
export FB_ACCESS_TOKEN="..."
export FB_PAGE_URL="https://www.facebook.com/swingdancekosice"
export APP_URL="http://127.0.0.1:8080"
```

Starter sa pokusi nacitat:

- `/{page-id}/events`
- `/{page-id}/albums`

Ak Facebook data nie su dostupne, automaticky pouzije lokalny obsah zo `storage/content`.

## Registracie a integracie

Registracie sa ukladaju do:

- `storage/registrations.json`

Volitelne integracie sa zapinaju cez env premenne:

```bash
export REGISTRATION_EMAIL="team@example.com"
export CRM_WEBHOOK_URL="https://example.com/webhook"
export DEFAULT_CHECKOUT_URL="https://example.com/checkout"
```

- `REGISTRATION_EMAIL` odosle notifikaciu po novej registracii.
- `CRM_WEBHOOK_URL` odosle JSON payload do externeho CRM alebo automatizacie.
- `DEFAULT_CHECKOUT_URL` nastavi fallback checkout po odoslani formulara.

## Obsah a media workflow

Obsah je teraz rozdeleny do editovatelnych JSON kolekcii:

- `storage/content/events.json`
- `storage/content/galleries.json`
- `storage/content/articles.json`
- `storage/content/courses.json`
- `storage/content/landing-pages.json`

Lokalne media subory su v:

- `assets/media/`

To znamena, ze placeholder obrazky uz nie su zavisle od externych URL a da sa s nimi pracovat ako s jednoduchou media kniznicou v ramci projektu.

## Struktura projektu

- `index.php` - front controller.
- `router.php` - router pre PHP built-in server.
- `src/` - konfiguracia, routovanie, render logika a Facebook integracia.
- `templates/` - jednotlive stranky a reusable layout.
- `assets/styles.css` - vizualny styl startera.
- `assets/media/` - lokalne obrazky a placeholder media.
- `storage/` - obsahove JSON kolekcie a registracie.

## Dalsie logicke kroky

Hotove:

1. Demo arrays su presunute do lokalnej content vrstvy v `storage/content`.
2. Registracie su pripravene na e-mail, CRM webhook a checkout flow.
3. Zakladne admin rozhranie je dostupne na `/admin`.
4. Externe placeholder obrazky su nahradene lokalnym media workflow v `assets/media`.

Najblizsie vhodne kroky:

1. Nahradit JSON content databazou alebo WordPress custom post types.
2. Pridat realne admin editovanie obsahu, nie len prehlad.
3. Napojit checkout na konkretny provider ako WooCommerce alebo Stripe.
4. Doriesit autentifikaciu a opravnenia pre admin cast.
