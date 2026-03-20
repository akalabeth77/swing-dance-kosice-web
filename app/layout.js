import './globals.css';
import { SiteShell } from '@/components/SiteShell';

export const metadata = {
  title: 'Swing Dance Košice',
  description: 'Vercel-compatible starter pre swing komunitu v Košiciach.'
};

export default function RootLayout({ children }) {
  return (
    <html lang="sk">
      <body>
        <SiteShell>{children}</SiteShell>
      </body>
    </html>
  );
}
