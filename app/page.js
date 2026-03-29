import Link from 'next/link';
import { getEvents, getGalleries } from '@/lib/facebook';
import { blogArticles, courses, landingPages, formatDate } from '@/lib/site-data';

export const revalidate = 3600;

export default async function HomePage() {
  const [events, galleries] = await Promise.all([getEvents(), getGalleries()]);

  return (
    <>
      <section className="hero">
        <div>
          <span className="eyebrow">Vercel-ready starter</span>
          <h1>Nový základ pre swing komunitu v Košiciach.</h1>
          <p>App Router vrstva vracia späť funkčný Vercel build a zároveň ponecháva event calendar, FB import, galériu, blog, kurzy a landing pages.</p>
          <div className="actions">
            <Link className="button primary" href="/events">
              Pozrieť eventy
            </Link>
            <Link className="button" href="/courses">
              Spustiť registrácie
            </Link>
          </div>
        </div>
        <div className="card spotlight">
          <h2>Hotové moduly</h2>
          <ul className="feature-list">
            <li>📅 kalendár eventov pre local, Facebook a Google Kalendár feed</li>
            <li>📷 galéria pre local, FB, Google Photos, Google Disk a Instagram album feed</li>
            <li>📝 blog sekcia pre workshopy a recapy</li>
            <li>🕺 kurzové registrácie cez Vercel-safe endpoint</li>
            <li>🎟 landing pages pre socials, bootcampy a festivaly</li>
          </ul>
        </div>
      </section>

      <section className="section-grid three-up">
        <article className="card">
          <h2>Event calendar</h2>
          <p>Centrálny funnel pre community socials, workshop weekends aj veľké festivaly.</p>
          <Link href="/events">Otvoriť eventy →</Link>
        </article>
        <article className="card">
          <h2>Galéria</h2>
          <p>Fotky sa dajú načítavať z Facebook albumov, Google Photos, Google Disku, Instagramu alebo lokálneho rozhrania.</p>
          <Link href="/gallery">Pozrieť galériu →</Link>
        </article>
        <article className="card">
          <h2>Kurzy</h2>
          <p>Registrácie sú pripravené na webhook, CRM alebo checkout integráciu.</p>
          <Link href="/courses">Prejsť na kurzy →</Link>
        </article>
      </section>

      <section className="section">
        <div className="section-heading">
          <h2>Najbližšie eventy</h2>
          <Link href="/events">Celý kalendár</Link>
        </div>
        <div className="card-grid three-up">
          {events.slice(0, 3).map((event) => (
            <article className="card event-card" key={event.slug}>
              <img alt={event.title} src={event.heroImage} />
              <div className="meta">{formatDate(event.date, { dateStyle: 'medium', timeStyle: 'short' })} · {event.location}</div>
              <h3>{event.title}</h3>
              <p>{event.excerpt}</p>
              <Link href={`/events/${event.slug}`}>Detail eventu →</Link>
            </article>
          ))}
        </div>
      </section>

      <section className="section-grid two-up">
        <div className="card">
          <div className="section-heading">
            <h2>Blog z workshopov</h2>
            <Link href="/blog">Všetky články</Link>
          </div>
          {blogArticles.map((article) => (
            <article className="stacked-item" key={article.slug}>
              <strong>{article.title}</strong>
              <p>{article.excerpt}</p>
            </article>
          ))}
        </div>
        <div className="card">
          <div className="section-heading">
            <h2>Galérie z viacerých zdrojov</h2>
            <Link href="/gallery">Pozrieť všetko</Link>
          </div>
          {galleries.slice(0, 2).map((gallery) => (
            <article className="stacked-item" key={gallery.title}>
              <strong>{gallery.title}</strong>
              <p>{gallery.description}</p>
            </article>
          ))}
        </div>
      </section>

      <section className="section-grid two-up">
        <div className="card">
          <div className="section-heading">
            <h2>Kurzy</h2>
            <Link href="/courses">Registrácie</Link>
          </div>
          {courses.map((course) => (
            <article className="stacked-item" key={course.slug}>
              <strong>{course.title}</strong>
              <p>{course.schedule} · {course.price}</p>
            </article>
          ))}
        </div>
        <div className="card">
          <div className="section-heading">
            <h2>Event landing pages</h2>
            <Link href="/landing-pages">Všetky layouty</Link>
          </div>
          {landingPages.map((item) => (
            <article className="stacked-item" key={item.slug}>
              <strong>{item.title}</strong>
              <p>{item.subtitle}</p>
            </article>
          ))}
        </div>
      </section>
    </>
  );
}
