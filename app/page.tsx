import Link from 'next/link';
import { getDictionary } from '@/lib/i18n';
import { getServerLanguage } from '@/lib/i18n-server';
import { getPublishedArticles } from '@/lib/content';

export default async function HomePage() {
  const t = getDictionary(getServerLanguage());
  const articles = await getPublishedArticles(3);

  return (
    <section className="space-y-10">
      <div className="rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 p-10 text-slate-950 shadow-xl">
        <h1 className="text-4xl font-bold md:text-6xl">{t.siteName}</h1>
        <p className="mt-4 max-w-2xl text-lg">{t.homeLead}</p>
        <div className="mt-6 flex gap-4">
          <Link href="/events" className="rounded-md bg-slate-950 px-4 py-2 font-semibold text-white">
            {t.homeUpcomingEvents}
          </Link>
          <Link href="/courses" className="rounded-md border border-slate-950 px-4 py-2 font-semibold">
            {t.homeExploreCourses}
          </Link>
        </div>
      </div>

      <div className="grid gap-6 md:grid-cols-3">
        <FeatureCard title={t.featureEventsTitle} description={t.featureEventsDescription} href="/events" />
        <FeatureCard title={t.featureGalleryTitle} description={t.featureGalleryDescription} href="/gallery" />
        <FeatureCard title={t.featureCoursesTitle} description={t.featureCoursesDescription} href="/courses" />
      </div>

      <section className="space-y-4 rounded-xl border border-slate-800 bg-slate-900 p-6">
        <h2 className="text-2xl font-semibold">Články</h2>
        {articles.length === 0 ? (
          <p className="text-slate-300">Zatiaľ nie sú publikované žiadne články.</p>
        ) : (
          <div className="grid gap-4 md:grid-cols-3">
            {articles.map((article) => (
              <article key={article.id} className="rounded-lg border border-slate-700 bg-slate-950 p-4">
                <h3 className="font-semibold">{article.title}</h3>
                <p className="mt-2 text-sm text-slate-300">{article.excerpt || article.content.slice(0, 120)}</p>
              </article>
            ))}
          </div>
        )}
      </section>
    </section>
  );
}

function FeatureCard({ title, description, href }: { title: string; description: string; href: string }) {
  return (
    <Link href={href} className="rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-accent">
      <h2 className="text-xl font-semibold">{title}</h2>
      <p className="mt-2 text-slate-300">{description}</p>
    </Link>
  );
}
