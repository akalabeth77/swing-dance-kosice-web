import type { Metadata } from 'next';
import './globals.css';
import { Navbar } from '@/components/Navbar';
import { LanguageProvider } from '@/components/LanguageProvider';
import { getServerLanguage } from '@/lib/i18n-server';

export const metadata: Metadata = {
  title: 'Swing Dance Košice',
  description: 'Community website for swing dance events, courses, and socials in Košice.'
};

export default function RootLayout({
  children
}: Readonly<{
  children: React.ReactNode;
}>) {
  const language = getServerLanguage();

  return (
    <html lang={language}>
      <body>
        <LanguageProvider initialLanguage={language}>
          <Navbar />
          <main className="container-page py-8">{children}</main>
        </LanguageProvider>
      </body>
    </html>
  );
}
