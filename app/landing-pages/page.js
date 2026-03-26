import Link from 'next/link';
import { PageHeader } from '@/components/SiteShell';
import { landingPages } from '@/lib/site-data';

export default function LandingPagesIndex() {
  return (
    <>
      <PageHeader
        eyebrow="🎟 Landing pages"
        title="Hotové event landing page šablóny"
        description="Každá landing page má hero sekciu, benefitové bloky, harmonogram, FAQ a CTA na nákup alebo registráciu."
      />

      <div className="card-grid two-up">
        {landingPages.map((item) => (
          <article className="card" key={item.slug}>
            <h2>{item.title}</h2>
            <p>{item.subtitle}</p>
            <ul className="feature-list compact">
              {item.highlights.map((highlight) => (
                <li key={highlight}>{highlight}</li>
              ))}
            </ul>
            <Link className="button primary" href={`/landing-pages/${item.slug}`}>
              Otvoriť landing page
            </Link>
          </article>
        ))}
      </div>
    </>
  );
}
