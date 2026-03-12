import type { Metadata } from 'next';
import './globals.css';
import { Navbar } from '@/components/Navbar';

export const metadata: Metadata = {
  title: 'Swing Dance Košice',
  description: 'Community website for swing dance events, courses, and socials in Košice.'
};

export default function RootLayout({
  children
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body>
        <Navbar />
        <main className="container-page py-8">{children}</main>
      </body>
    </html>
  );
}
