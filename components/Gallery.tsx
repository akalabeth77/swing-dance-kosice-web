const images = [
  {
    src: 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=1200&q=80',
    alt: 'Swing dance social'
  },
  {
    src: 'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?auto=format&fit=crop&w=1200&q=80',
    alt: 'Couple dancing lindy hop'
  },
  {
    src: 'https://images.unsplash.com/photo-1516307365426-bea591f05011?auto=format&fit=crop&w=1200&q=80',
    alt: 'Swing dance workshop'
  }
];

export function Gallery() {
  return (
    <div className="grid gap-4 md:grid-cols-3">
      {images.map((image) => (
        <div key={image.src} className="overflow-hidden rounded-xl border border-slate-800">
          {/* eslint-disable-next-line @next/next/no-img-element */}
          <img src={image.src} alt={image.alt} className="h-64 w-full object-cover transition hover:scale-105" />
        </div>
      ))}
    </div>
  );
}
