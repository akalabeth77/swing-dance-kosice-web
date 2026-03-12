import { Gallery } from '@/components/Gallery';
import { getDictionary } from '@/lib/i18n';
import { getServerLanguage } from '@/lib/i18n-server';

export default function GalleryPage() {
  const t = getDictionary(getServerLanguage());

  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">{t.galleryTitle}</h1>
      <p className="text-slate-300">{t.galleryDescription}</p>
      <Gallery />
    </section>
  );
}
