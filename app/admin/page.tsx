import { revalidatePath } from 'next/cache';
import { getDictionary } from '@/lib/i18n';
import { getServerLanguage } from '@/lib/i18n-server';
import { getSupabaseAdminClient } from '@/lib/supabase-admin';
import { getCourses, getPublishedArticles, getPublicMenuItems } from '@/lib/content';

export const dynamic = 'force-dynamic';

async function addMenuItem(formData: FormData) {
  'use server';

  const label = String(formData.get('label') ?? '').trim();
  const href = String(formData.get('href') ?? '').trim();
  const sortOrder = Number(formData.get('sort_order') ?? 100);

  if (!label || !href) {
    return;
  }

  const supabase = getSupabaseAdminClient();

  await supabase.from('menu_items').insert({
    label,
    href,
    sort_order: Number.isFinite(sortOrder) ? sortOrder : 100
  });

  revalidatePath('/');
  revalidatePath('/admin');
}

async function addArticle(formData: FormData) {
  'use server';

  const title = String(formData.get('title') ?? '').trim();
  const slug = String(formData.get('slug') ?? '').trim();
  const excerpt = String(formData.get('excerpt') ?? '').trim();
  const content = String(formData.get('content') ?? '').trim();

  if (!title || !slug || !content) {
    return;
  }

  const supabase = getSupabaseAdminClient();

  await supabase.from('articles').insert({
    title,
    slug,
    excerpt,
    content,
    published_at: new Date().toISOString()
  });

  revalidatePath('/');
  revalidatePath('/admin');
}

async function addCourse(formData: FormData) {
  'use server';

  const name = String(formData.get('name') ?? '').trim();
  const level = String(formData.get('level') ?? '').trim();
  const schedule = String(formData.get('schedule') ?? '').trim();
  const description = String(formData.get('description') ?? '').trim();
  const sortOrder = Number(formData.get('sort_order') ?? 100);

  if (!name || !schedule || !description) {
    return;
  }

  const supabase = getSupabaseAdminClient();

  await supabase.from('courses').insert({
    name,
    level,
    schedule,
    description,
    sort_order: Number.isFinite(sortOrder) ? sortOrder : 100
  });

  revalidatePath('/courses');
  revalidatePath('/admin');
}

export default async function AdminPage() {
  const language = getServerLanguage();
  const t = getDictionary(language);
  const locale = language === 'sk' ? 'sk-SK' : 'en-US';

  const [menuItems, articles, courses] = await Promise.all([getPublicMenuItems(), getPublishedArticles(10), getCourses()]);

  return (
    <section className="space-y-8">
      <h1 className="text-3xl font-bold">{t.adminTitle}</h1>
      <p className="text-slate-300">Jednoduchý redakčný systém pre menu, články a kurzy (Supabase).</p>

      <div className="grid gap-6 lg:grid-cols-3">
        <article className="rounded-xl border border-slate-800 bg-slate-900 p-5">
          <h2 className="text-lg font-semibold">Pridať položku menu</h2>
          <form action={addMenuItem} className="mt-4 space-y-3 text-sm">
            <input name="label" required placeholder="Názov položky" className="w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
            <input name="href" required placeholder="/clanky alebo externý URL" className="w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
            <input name="sort_order" type="number" defaultValue={100} className="w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
            <button className="rounded-md bg-accent px-4 py-2 font-semibold text-slate-950">Uložiť menu</button>
          </form>
        </article>

        <article className="rounded-xl border border-slate-800 bg-slate-900 p-5 lg:col-span-2">
          <h2 className="text-lg font-semibold">Pridať článok</h2>
          <form action={addArticle} className="mt-4 grid gap-3 text-sm md:grid-cols-2">
            <input name="title" required placeholder="Názov článku" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 md:col-span-2" />
            <input name="slug" required placeholder="slug-clanku" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
            <input name="excerpt" placeholder="Krátky perex" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
            <textarea name="content" required rows={4} placeholder="Obsah článku" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 md:col-span-2" />
            <button className="rounded-md bg-accent px-4 py-2 font-semibold text-slate-950 md:col-span-2">Uložiť článok</button>
          </form>
        </article>
      </div>

      <article className="rounded-xl border border-slate-800 bg-slate-900 p-5">
        <h2 className="text-lg font-semibold">Pridať kurz</h2>
        <form action={addCourse} className="mt-4 grid gap-3 text-sm md:grid-cols-2">
          <input name="name" required placeholder="Lindy Hop Beginners 1" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
          <input name="level" placeholder="Beginners" defaultValue="Beginners" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
          <input name="schedule" required placeholder="Pondelok 18:00" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
          <input name="sort_order" type="number" defaultValue={100} className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2" />
          <textarea name="description" required rows={3} placeholder="Popis kurzu" className="rounded-md border border-slate-700 bg-slate-950 px-3 py-2 md:col-span-2" />
          <button className="rounded-md bg-accent px-4 py-2 font-semibold text-slate-950 md:col-span-2">Uložiť kurz</button>
        </form>
      </article>

      <div className="grid gap-6 lg:grid-cols-3">
        <article className="rounded-xl border border-slate-800 bg-slate-900 p-5">
          <h2 className="font-semibold">Aktuálne menu položky</h2>
          <ul className="mt-3 space-y-2 text-sm text-slate-300">
            {menuItems.length === 0 ? <li>Žiadne vlastné položky menu.</li> : menuItems.map((item) => <li key={item.id}>{item.label} → {item.href}</li>)}
          </ul>
        </article>
        <article className="rounded-xl border border-slate-800 bg-slate-900 p-5 lg:col-span-2">
          <h2 className="font-semibold">Posledné články</h2>
          <ul className="mt-3 space-y-2 text-sm text-slate-300">
            {articles.length === 0 ? <li>Žiadne články.</li> : articles.map((item) => <li key={item.id} className="flex justify-between gap-2"><span>{item.title}</span><span>{new Date(item.published_at).toLocaleDateString(locale)}</span></li>)}
          </ul>
        </article>
      </div>

      <article className="rounded-xl border border-slate-800 bg-slate-900 p-5">
        <h2 className="font-semibold">Aktuálne kurzy</h2>
        <ul className="mt-3 space-y-2 text-sm text-slate-300">
          {courses.map((item) => (
            <li key={item.id}>
              {item.name} ({item.schedule})
            </li>
          ))}
        </ul>
      </article>
    </section>
  );
}
