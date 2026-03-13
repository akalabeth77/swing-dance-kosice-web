-- CMS schema for Swing Dance Košice web

create extension if not exists pgcrypto;

create table if not exists public.menu_items (
  id uuid primary key default gen_random_uuid(),
  label text not null,
  href text not null,
  sort_order integer not null default 100,
  created_at timestamptz not null default now()
);

create table if not exists public.articles (
  id uuid primary key default gen_random_uuid(),
  title text not null,
  slug text not null unique,
  excerpt text not null default '',
  content text not null,
  published_at timestamptz not null default now(),
  created_at timestamptz not null default now()
);

create table if not exists public.courses (
  id uuid primary key default gen_random_uuid(),
  name text not null,
  level text not null default 'Beginners',
  schedule text not null,
  description text not null,
  sort_order integer not null default 100,
  created_at timestamptz not null default now()
);

alter table public.menu_items enable row level security;
alter table public.articles enable row level security;
alter table public.courses enable row level security;

do $$
begin
  if not exists (select 1 from pg_policies where schemaname = 'public' and tablename = 'menu_items' and policyname = 'Public can read menu_items') then
    create policy "Public can read menu_items" on public.menu_items for select using (true);
  end if;

  if not exists (select 1 from pg_policies where schemaname = 'public' and tablename = 'articles' and policyname = 'Public can read articles') then
    create policy "Public can read articles" on public.articles for select using (true);
  end if;

  if not exists (select 1 from pg_policies where schemaname = 'public' and tablename = 'courses' and policyname = 'Public can read courses') then
    create policy "Public can read courses" on public.courses for select using (true);
  end if;
end $$;

-- Seed starter courses requested by client
insert into public.courses (name, level, schedule, description, sort_order)
values
  ('Lindy Hop Beginners 1', 'Beginners', 'Pondelok 18:00', 'Úplné základy Lindy Hopu pre nových tanečníkov.', 1),
  ('Collegiate Shag Beginners 1', 'Beginners', 'Streda 19:00', 'Rýchly, hravý a energický kurz Collegiate Shag od nuly.', 2)
on conflict do nothing;
