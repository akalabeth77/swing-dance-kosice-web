import Link from 'next/link';
import { notFound } from 'next/navigation';
import { getEvents } from '@/lib/facebook';
import { formatDate } from '@/lib/site-data';

export const revalidate = 3600;

export async function generateStaticParams() {
  const events = await getEvents();
  return events.map((event) => ({ slug: event.slug }));
}

export default async function EventDetailPage({ params }) {
  const events = await getEvents();
  const event = events.find((item) => item.slug === params.slug);

  if (!event) {
    notFound();
  }

  return (
    <>
      <section className="hero detail-hero">
        <div>
          <span className="eyebrow">Event detail / landing starter</span>
          <h1>{event.title}</h1>
          <p>{event.excerpt}</p>
          <ul className="inline-list">
            <li>{formatDate(event.date, { dateStyle: 'medium', timeStyle: 'short' })}</li>
            <li>{event.location}</li>
            <li>Zdroj: {event.source}</li>
          </ul>
          <div className="actions">
            <Link className="button primary" href={event.ctaUrl}>
              {event.ctaLabel}
            </Link>
            <Link className="button" href="/landing-pages">
              Pozrieť landing layouts
            </Link>
          </div>
        </div>
        <img alt={event.title} className="hero-image" src={event.heroImage} />
      </section>

      <section className="section-grid two-up">
        <article className="card prose">
          <h2>Popis eventu</h2>
          {event.body.map((paragraph) => (
            <p key={paragraph}>{paragraph}</p>
          ))}
        </article>
        <aside className="card">
          <h2>Highlights</h2>
          <ul className="feature-list">
            {event.highlights.map((highlight) => (
              <li key={highlight}>{highlight}</li>
            ))}
          </ul>
        </aside>
      </section>
    </>
  );
}
