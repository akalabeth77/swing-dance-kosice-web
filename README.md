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

## Facebook integrácia

Ak chceš ťahať eventy a albumy z Facebooku, nastav env premenné:

```bash
FB_PAGE_ID="..."
FB_ACCESS_TOKEN="..."
```

Ak Facebook dáta nie sú dostupné, použije sa lokálny demo obsah.

## Registrácie na kurzy

- Next.js flow: `app/api/register/route.js` (voliteľný webhook `REGISTRATION_WEBHOOK_URL`).
- PHP flow: `POST /courses/{slug}/submit` s uložením do `storage/registrations.json`.

## Merge tips

Ak Git hlási konflikty, rieš ich v tomto poradí:

1. `package.json`, `next.config.mjs`, `app/globals.css` (Vercel build vrstva),
2. `src/*.php`, `templates/*.php`, `assets/styles.css` (PHP vrstva),
3. `README.md`, `.gitignore` (spoločné meta súbory).

Týmto poriadkom sa minimalizujú opakované konflikty.
