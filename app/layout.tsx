import type { Metadata } from 'next';
import './globals.css';
import { Navbar } from '@/components/Navbar';
import { LanguageProvider } from '@/components/LanguageProvider';
import { getServerLanguage } from '@/lib/i18n-server';
import { getPublicMenuItems } from '@/lib/content';

export const metadata: Metadata = {
  title: 'Swing Dance Košice',
  description: 'Community website for swing dance events, courses, and socials in Košice.'
};

export default async function RootLayout({
  children
}: Readonly<{
  children: React.ReactNode;
}>) {
  const language = getServerLanguage();
  const menuItems = await getPublicMenuItems();

  return (
    <html lang={language}>
      <body>
        <LanguageProvider initialLanguage={language}>
          <Navbar customMenuItems={menuItems} />
          <main className="container-page py-8">{children}</main>
        </LanguageProvider>
      </body>
    </html>
  );
}
