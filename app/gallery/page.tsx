import { Gallery } from '@/components/Gallery';

export default function GalleryPage() {
  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">Gallery</h1>
      <p className="text-slate-300">Moments from our swing dance nights in Košice.</p>
      <Gallery />
    </section>
  );
}
