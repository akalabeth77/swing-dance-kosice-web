import Link from 'next/link';

const links = [
  { href: '/', label: 'Home' },
  { href: '/events', label: 'Events' },
  { href: '/gallery', label: 'Gallery' },
  { href: '/courses', label: 'Courses' },
  { href: '/admin', label: 'Admin' }
];

export function Navbar() {
  return (
    <header className="border-b border-slate-800 bg-slate-950/90 backdrop-blur">
      <nav className="container-page flex items-center justify-between py-4">
        <Link href="/" className="text-lg font-bold text-accent">
          Swing Dance Košice
        </Link>
        <ul className="flex gap-4 text-sm md:text-base">
          {links.map((link) => (
            <li key={link.href}>
              <Link href={link.href} className="text-slate-200 transition hover:text-accent">
                {link.label}
              </Link>
            </li>
          ))}
        </ul>
      </nav>
    </header>
  );
}
