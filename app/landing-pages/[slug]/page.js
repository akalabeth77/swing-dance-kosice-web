import Link from 'next/link';
import { notFound } from 'next/navigation';
import { landingPages } from '@/lib/site-data';

export function generateStaticParams() {
  return landingPages.map((item) => ({ slug: item.slug }));
}

export default function LandingPage({ params }) {
  const landingPage = landingPages.find((item) => item.slug === params.slug);

  if (!landingPage) {
    notFound();
  }

  return (
    <>
      <section className="hero detail-hero">
        <div>
          <span className="eyebrow">Event landing page</span>
          <h1>{landingPage.title}</h1>
          <p>{landingPage.subtitle}</p>
          <div className="price-badge">{landingPage.price}</div>
          <div className="actions">
            <Link className="button primary" href={landingPage.ctaUrl}>
              {landingPage.ctaLabel}
            </Link>
            <Link className="button" href="/events">
              Späť na event calendar
            </Link>
          </div>
        </div>
        <img alt={landingPage.title} className="hero-image" src={landingPage.heroImage} />
      </section>

      <section className="section-grid two-up">
        <article className="card">
          <h2>Highlights</h2>
          <ul className="feature-list">
            {landingPage.highlights.map((highlight) => (
              <li key={highlight}>{highlight}</li>
            ))}
          </ul>
        </article>
        <article className="card" id="pricing">
          <h2>Prečo tento layout funguje</h2>
          <p>Je navrhnutý pre rýchle promo kampane: jasný headline, benefit stack, schedule, FAQ a jedno hlavné CTA.</p>
          <p>Pri migrácii do WordPressu sa dá rozložiť na Gutenberg bloky alebo ACF flexible content.</p>
        </article>
      </section>

      <section className="section-grid two-up">
        <article className="card">
          <h2>Harmonogram</h2>
          {landingPage.schedule.map((block) => (
            <div className="stacked-item" key={block.day}>
              <strong>{block.day}</strong>
              <ul className="feature-list compact">
                {block.items.map((item) => (
                  <li key={item}>{item}</li>
                ))}
              </ul>
            </div>
          ))}
        </article>
        <article className="card">
          <h2>FAQ</h2>
          {landingPage.faq.map((item) => (
            <div className="stacked-item" key={item.question}>
              <strong>{item.question}</strong>
              <p>{item.answer}</p>
            </div>
          ))}
        </article>
      </section>
    </>
  );
}
