# Swing Dance Košice Web

Production-ready Next.js 14 web app for the Swing Dance Košice community.

## Tech Stack

- Next.js 14 (App Router)
- TypeScript
- Tailwind CSS
- Supabase (`@supabase/supabase-js`)
- Facebook Graph API integration

## Environment Variables

Copy `.env.example` to `.env.local` and fill in values:

```bash
cp .env.example .env.local
```

- `FB_PAGE_ID`
- `FB_ACCESS_TOKEN`
- `NEXT_PUBLIC_SUPABASE_URL`
- `NEXT_PUBLIC_SUPABASE_ANON_KEY`

## Local development

```bash
npm install
npm run dev
```

## Deploy to Vercel

1. Push this repository to GitHub.
2. Import the repository in Vercel.
3. Set the environment variables in Vercel project settings.
4. Deploy.

The app is configured for direct Vercel deployment.
