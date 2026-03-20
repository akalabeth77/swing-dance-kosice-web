# Swing Dance Košice PHP Starter

WordPress-like PHP starter pre swing komunitu Swing Dance Košice.

## Čo starter obsahuje

- 📅 **Event calendar** pripravený na načítanie dát z Facebook udalostí cez Graph API.
- 📷 **Galériu** s fallback obsahom a možnosťou synchronizácie z Facebook albumov.
- 📝 **Blog** pre workshopy, recapy a komunitný obsah.
- 🕺 **Registrácie na kurzy** cez jednoduchý PHP formulár ukladajúci dáta do `storage/registrations.json`.
- 🎟 **Event landing pages** s hero sekciou, benefitmi, harmonogramom a FAQ.

## Prečo „WordPress-like"

Tento repozitár nie je plná inštalácia WordPressu. Je to ľahký PHP starter s architektúrou, ktorú vieš neskôr presunúť do:

- WordPress témy,
- custom pluginu,
- ACF/Gutenberg blokov,
- alebo vlastného malého PHP CMS.

## Spustenie lokálne

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

## Facebook integrácia

Ak chceš ťahať eventy a albumy z Facebooku, nastav env premenné:

```bash
export FB_PAGE_ID="..."
export FB_ACCESS_TOKEN="..."
export FB_PAGE_URL="https://www.facebook.com/swingdancekosice"
export APP_URL="http://127.0.0.1:8080"
```

Starter sa pokúsi načítať:

- `/{page-id}/events`
- `/{page-id}/albums`

Ak Facebook dáta nie sú dostupné, automaticky použije lokálny demo obsah.

## Štruktúra projektu

- `index.php` – front controller.
- `router.php` – router pre PHP built-in server.
- `src/` – konfigurácia, routovanie, render logika a Facebook integrácia.
- `templates/` – jednotlivé stránky a reusable layout.
- `assets/styles.css` – vizuálny štýl startera.
- `storage/` – jednoduché lokálne úložisko pre registrácie.

## Ďalšie logické kroky

1. Prehodiť demo arrays do databázy alebo WordPress custom post types.
2. Napojiť registrácie na e-mail, CRM alebo checkout.
3. Doplniť admin rozhranie.
4. Nahradiť externé placeholder obrázky vlastným media library workflow.
