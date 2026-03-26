import Link from 'next/link';

export default function NotFound() {
  return (
    <section className="card prose article-detail center-card">
      <span className="eyebrow">404</span>
      <h1>Táto stránka zatiaľ neexistuje.</h1>
      <p>Skús sa vrátiť na domovskú stránku alebo otvoriť niektorý z pripravených modulov startera.</p>
      <p>
        <Link className="button primary" href="/">
          Späť domov
        </Link>
      </p>
    </section>
  );
}
