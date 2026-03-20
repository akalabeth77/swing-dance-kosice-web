# Swing Dance Košice starter

Starter pre komunitný web Swing Dance Košice so zameraním na:

- 📅 event calendar,
- 📷 galériu,
- 📝 workshop blog,
- 🕺 registrácie na kurzy,
- 🎟 event landing pages.

## Prečo teraz build funguje na Verceli

Predchádzajúca verzia ostala iba ako PHP-only starter, ale Vercel projekt je nakonfigurovaný na `npm run vercel-build`, teda na Next.js build pipeline. Preto je v repozitári teraz opäť **Next.js App Router vrstva**, ktorá zobrazuje rovnaký obsah startera a je deployovateľná na Vercel bez chyby `Couldn't find any pages or app directory`.

## Lokálne spustenie

```bash
npm install
npm run dev
```

Produkčný build:

```bash
npm run vercel-build
```

## Facebook integrácia

Ak chceš ťahať eventy a albumy z Facebooku, nastav env premenné:

```bash
FB_PAGE_ID="..."
FB_ACCESS_TOKEN="..."
```

Ak Facebook dáta nie sú dostupné, automaticky sa použije lokálny demo obsah.

## Registrácie na kurzy

Kurzový formulár ide cez `app/api/register/route.js`.

Voliteľne vieš napojiť webhook:

```bash
REGISTRATION_WEBHOOK_URL="https://..."
```

Keď je webhook nastavený, formulár odošle JSON payload ďalej do CRM, e-mail automation alebo iného backendu.

## Dôležité poznámky

- `app/` obsahuje Vercel-kompatibilný frontend.
- `lib/` obsahuje starter dáta a Facebook fetch logiku.
- Pôvodné PHP súbory ostali v repozitári ako referenčný starter / migračný základ, ale Vercel deployment používa Next.js vrstvu.
