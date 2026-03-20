import Link from 'next/link';
import { navigation } from '@/lib/site-data';

export function SiteShell({ children }) {
  return (
    <>
      <header className="site-header">
        <div className="container header-inner">
          <Link className="brand" href="/">
            Swing Dance Košice
          </Link>
          <nav>
            {navigation.map((item) => (
              <Link key={item.href} href={item.href}>
                {item.label}
              </Link>
            ))}
          </nav>
        </div>
      </header>

      <main className="container page-shell">{children}</main>

      <footer className="site-footer">
        <div className="container footer-grid">
          <div>
            <h3>Starter smerovanie</h3>
            <p>Architektúra je pripravená na migráciu do WordPress témy, custom pluginu alebo ľahkého CMS.</p>
          </div>
          <div>
            <h3>Facebook integrácie</h3>
            <p>Eventy a galérie vedia siahať na Facebook Graph API, ak doplníš <code>FB_PAGE_ID</code> a <code>FB_ACCESS_TOKEN</code>.</p>
          </div>
          <div>
            <h3>Deploy</h3>
            <p>Tento layer je pripravený na Vercel build cez Next.js App Router.</p>
          </div>
        </div>
      </footer>
    </>
  );
}

export function PageHeader({ eyebrow, title, description }) {
  return (
    <section className="section-heading page-header">
      <div>
        {eyebrow ? <span className="eyebrow">{eyebrow}</span> : null}
        <h1>{title}</h1>
        {description ? <p>{description}</p> : null}
      </div>
    </section>
  );
}
