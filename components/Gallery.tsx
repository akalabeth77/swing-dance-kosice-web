'use client';

import { useI18n } from '@/components/LanguageProvider';

const imageSources = [
  'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=1200&q=80',
  'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?auto=format&fit=crop&w=1200&q=80',
  'https://images.unsplash.com/photo-1516307365426-bea591f05011?auto=format&fit=crop&w=1200&q=80'
] as const;

export function Gallery() {
  const { t } = useI18n();
  const altTexts = [t('galleryImage1Alt'), t('galleryImage2Alt'), t('galleryImage3Alt')];

  return (
    <div className="grid gap-4 md:grid-cols-3">
      {imageSources.map((src, index) => (
        <div key={src} className="overflow-hidden rounded-xl border border-slate-800">
          {/* eslint-disable-next-line @next/next/no-img-element */}
          <img src={src} alt={altTexts[index]} className="h-64 w-full object-cover transition hover:scale-105" />
        </div>
      ))}
    </div>
  );
}
