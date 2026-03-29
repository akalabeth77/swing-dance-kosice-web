import Link from 'next/link';
import { PageHeader } from '@/components/SiteShell';
import { getEvents } from '@/lib/facebook';
import { formatDate } from '@/lib/site-data';

export const revalidate = 3600;

export default async function EventsPage() {
  const events = await getEvents();

  return (
    <>
      <PageHeader
        eyebrow="📅 Event calendar"
        title="Kalendár eventov"
        description="Udalosti je možné skladať z lokálnych dát, Facebook eventov a Google Kalendára (cez JSON feed)."
      />

      <div className="timeline">
        {events.map((event) => (
          <article className="card timeline-item" key={event.slug}>
            <div>
              <div className="meta">{formatDate(event.date, { dateStyle: 'medium', timeStyle: 'short' })}</div>
              <h2>{event.title}</h2>
              <p>{event.excerpt}</p>
              <ul className="inline-list">
                <li>{event.location}</li>
                <li>Zdroj: {event.source}</li>
              </ul>
            </div>
            <div className="actions split">
              <Link className="button" href={`/events/${event.slug}`}>
                Detail
              </Link>
              <Link className="button primary" href={event.ctaUrl}>
                {event.ctaLabel}
              </Link>
            </div>
          </article>
        ))}
      </div>
    </>
  );
}
