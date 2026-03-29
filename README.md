# Swing Dance Košice starter

Starter pre komunitný web Swing Dance Košice so zameraním na:

- 📅 event calendar,
- 📷 galériu,
- 📝 workshop blog,
- 🕺 registrácie na kurzy,
- 🎟 event landing pages.

## Runtime model (merge-safe)

Repo dnes drží **2 kompatibilné vrstvy**:

1. **Next.js App Router** (`app/`, `components/`, `lib/`) – primárny deploy target pre Vercel.
2. **PHP starter** (`index.php`, `src/`, `templates/`) – referenčný fallback / migračný základ.

Toto rozdelenie je zámerné, aby sa pri merge nezlievali Vercel build veci a PHP runtime logika do jedného súboru.

## Vercel / Next.js

Lokálne:

```bash
npm install
npm run dev
```

Produkčný build (rovnaký ako na Verceli):

```bash
npm run vercel-build
```

## Logo

- Header používa logo súbor `public/assets/media/logo-swing-dance-kosice.svg` (Next.js) a `assets/media/logo-swing-dance-kosice.svg` (PHP).
- Ak chceš použiť vlastné logo bez zmeny dizajnu, iba vymeň súbor a zachovaj názov.

## Multi-source integrácie eventov a galérií

### Eventy

Nastav poradie zdrojov cez `EVENT_SOURCES`:

```bash
EVENT_SOURCES="local,facebook,google-calendar"
```

Podporované hodnoty:

- `local` – lokálny demo obsah,
- `facebook` – Facebook Graph API (`FB_PAGE_ID`, `FB_ACCESS_TOKEN`),
- `google-calendar` – externý JSON feed (`GOOGLE_CALENDAR_FEED_URL`).

### Galérie / albumy

Nastav poradie zdrojov cez `GALLERY_SOURCES`:

```bash
GALLERY_SOURCES="local,facebook,google-photos,google-drive,instagram"
```

Podporované hodnoty:

- `local` – lokálne demo albumy,
- `facebook` – Facebook albumy,
- `google-photos` – JSON feed (`GOOGLE_PHOTOS_FEED_URL`),
- `google-drive` – JSON feed (`GOOGLE_DRIVE_ALBUMS_FEED_URL`),
- `instagram` – JSON feed (`INSTAGRAM_ALBUMS_FEED_URL`).

Poznámka: Google Photos / Drive / Instagram sú v tomto starteri riešené cez JSON feed endpointy (napr. vlastný backend webhook), aby ostal frontend jednoduchý a Vercel-safe.

## Registrácie na kurzy

- Next.js flow: `app/api/register/route.js` (voliteľný webhook `REGISTRATION_WEBHOOK_URL`).
- PHP flow: `POST /courses/{slug}/submit` s uložením do `storage/registrations.json`.

## Merge tips

Ak Git hlási konflikty, rieš ich v tomto poradí:

1. `package.json`, `next.config.mjs`, `app/globals.css` (Vercel build vrstva),
2. `src/*.php`, `templates/*.php`, `assets/styles.css` (PHP vrstva),
3. `README.md`, `.gitignore` (spoločné meta súbory).

Týmto poriadkom sa minimalizujú opakované konflikty.
