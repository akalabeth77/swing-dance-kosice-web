import { PageHeader } from '@/components/SiteShell';
import { getGalleries } from '@/lib/facebook';

export const revalidate = 3600;

export default async function GalleryPage() {
  const galleries = await getGalleries();

  return (
    <>
      <PageHeader
        eyebrow="📷 Galéria"
        title="Fotogaléria komunity"
        description="Albumy sú pripravené na synchronizáciu z Facebook albumov alebo neskôr z WordPress media library."
      />

      {galleries.map((gallery) => (
        <section className="section card" key={gallery.title}>
          <div className="section-heading">
            <div>
              <h2>{gallery.title}</h2>
              <p>{gallery.description}</p>
            </div>
            <span className="meta">Zdroj: {gallery.source}</span>
          </div>
          <div className="photo-grid">
            {gallery.photos.map((photo) => (
              <figure key={photo.src}>
                <img alt={photo.alt} src={photo.src} />
              </figure>
            ))}
          </div>
        </section>
      ))}
    </>
  );
}
