'use client';

import Link from 'next/link';
import { useI18n } from '@/components/LanguageProvider';

export function Navbar() {
  const { language, setLanguage, t } = useI18n();

  const links = [
    { href: '/', label: t('navHome') },
    { href: '/events', label: t('navEvents') },
    { href: '/gallery', label: t('navGallery') },
    { href: '/courses', label: t('navCourses') },
    { href: '/admin', label: t('navAdmin') }
  ];

  return (
    <header className="border-b border-slate-800 bg-slate-950/90 backdrop-blur">
      <nav className="container-page flex flex-col gap-3 py-4 md:flex-row md:items-center md:justify-between">
        <Link href="/" className="text-lg font-bold text-accent">
          {t('siteName')}
        </Link>

        <div className="flex flex-wrap items-center gap-4">
          <ul className="flex gap-4 text-sm md:text-base">
            {links.map((link) => (
              <li key={link.href}>
                <Link href={link.href} className="text-slate-200 transition hover:text-accent">
                  {link.label}
                </Link>
              </li>
            ))}
          </ul>

          <div className="flex items-center gap-2 text-xs md:text-sm">
            <span className="text-slate-300">{t('navLanguage')}:</span>
            <button
              type="button"
              className={`rounded-md px-2 py-1 font-medium transition ${
                language === 'en' ? 'bg-accent text-slate-950' : 'bg-slate-800 text-slate-200 hover:bg-slate-700'
              }`}
              onClick={() => setLanguage('en')}
            >
              EN
            </button>
            <button
              type="button"
              className={`rounded-md px-2 py-1 font-medium transition ${
                language === 'sk' ? 'bg-accent text-slate-950' : 'bg-slate-800 text-slate-200 hover:bg-slate-700'
              }`}
              onClick={() => setLanguage('sk')}
            >
              SK
            </button>
          </div>
        </div>
      </nav>
    </header>
  );
}
