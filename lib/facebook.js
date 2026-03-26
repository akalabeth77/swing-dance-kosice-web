import { sampleEvents, sampleGalleries } from '@/lib/site-data';

const graphVersion = 'v19.0';

async function graphRequest(edge, query) {
  const pageId = process.env.FB_PAGE_ID;
  const accessToken = process.env.FB_ACCESS_TOKEN;

  if (!pageId || !accessToken) {
    return null;
  }

  const url = new URL(`https://graph.facebook.com/${graphVersion}/${pageId}/${edge}`);
  Object.entries({ ...query, access_token: accessToken }).forEach(([key, value]) => {
    url.searchParams.set(key, String(value));
  });

  const response = await fetch(url.toString(), {
    headers: { Accept: 'application/json' },
    next: { revalidate: 3600 }
  });

  if (!response.ok) {
    return null;
  }

  return response.json();
}

export async function getEvents() {
  const response = await graphRequest('events', {
    fields: 'id,name,description,start_time,end_time,place,cover',
    limit: 12
  });

  if (!response?.data?.length) {
    return sampleEvents;
  }

  const mapped = response.data
    .filter((event) => event?.name && event?.start_time)
    .map((event) => ({
      slug: event.name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''),
      title: event.name,
      excerpt: event.description || 'Synchronizované z Facebook udalosti.',
      date: event.start_time,
      endDate: event.end_time,
      location: event.place?.name || 'Košice',
      ctaLabel: 'Otvoriť FB event',
      ctaUrl: `https://www.facebook.com/events/${event.id}`,
      heroImage: event.cover?.source || sampleEvents[0].heroImage,
      source: 'facebook',
      body: [event.description || 'Detaily budú doplnené z Facebook udalosti.'],
      highlights: ['Automaticky načítané z FB stránky', 'Vhodné ako základ landing page', 'Možnosť doplniť registráciu alebo CTA']
    }));

  return mapped.length ? mapped : sampleEvents;
}

export async function getGalleries() {
  const response = await graphRequest('albums', {
    fields: 'id,name,description,photos{images,name}',
    limit: 8
  });

  if (!response?.data?.length) {
    return sampleGalleries;
  }

  const mapped = response.data.map((album) => ({
    title: album.name || 'Facebook album',
    description: album.description || 'Importované z Facebook albumu.',
    photos:
      album.photos?.data?.map((photo) => ({
        src: photo.images?.[0]?.source,
        alt: photo.name || album.name || 'Facebook album'
      })).filter((photo) => photo.src) || [],
    source: 'facebook'
  }));

  return mapped.length ? mapped : sampleGalleries;
}
