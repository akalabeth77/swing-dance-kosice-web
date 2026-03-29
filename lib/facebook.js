import { sampleEvents, sampleGalleries } from '@/lib/site-data';

const graphVersion = 'v19.0';

function parseSources(value, fallback) {
  if (!value) {
    return fallback;
  }

  const parsed = value
    .split(',')
    .map((source) => source.trim().toLowerCase())
    .filter(Boolean);

  return parsed.length ? parsed : fallback;
}

function normalizeEvent(event, source, index) {
  if (!event?.title || !event?.date) {
    return null;
  }

  const slugBase = event.slug || `${event.title}-${source}-${index}`;
  const slug = slugBase.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '') || `event-${index + 1}`;

  return {
    slug,
    title: event.title,
    excerpt: event.excerpt || 'Synchronizované z externého zdroja.',
    date: event.date,
    endDate: event.endDate || event.end_date,
    location: event.location || 'Košice',
    ctaLabel: event.ctaLabel || event.cta_label || 'Viac info',
    ctaUrl: event.ctaUrl || event.cta_url || '/events',
    heroImage: event.heroImage || event.hero_image || sampleEvents[0].heroImage,
    source,
    body: Array.isArray(event.body) ? event.body : [event.excerpt || 'Detaily budú doplnené neskôr.'],
    highlights: Array.isArray(event.highlights) && event.highlights.length ? event.highlights : ['Importované z externého feedu']
  };
}

function normalizeGallery(gallery, source, index) {
  const photos = (gallery?.photos || [])
    .map((photo) => ({
      src: photo?.src,
      alt: photo?.alt || gallery?.title || 'Album'
    }))
    .filter((photo) => Boolean(photo.src));

  if (!gallery?.title || photos.length === 0) {
    return null;
  }

  return {
    title: gallery.title,
    description: gallery.description || 'Importované z externého zdroja.',
    photos,
    source,
    slug: `${gallery.title}-${source}-${index}`.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')
  };
}

async function fetchJsonFeed(url) {
  if (!url) {
    return null;
  }

  try {
    const response = await fetch(url, {
      headers: { Accept: 'application/json' },
      next: { revalidate: 3600 }
    });

    if (!response.ok) {
      return null;
    }

    const payload = await response.json();
    return Array.isArray(payload) ? payload : null;
  } catch {
    return null;
  }
}

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

async function getFacebookEvents() {
  const response = await graphRequest('events', {
    fields: 'id,name,description,start_time,end_time,place,cover',
    limit: 12
  });

  if (!response?.data?.length) {
    return [];
  }

  return response.data
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
}

async function getFacebookGalleries() {
  const response = await graphRequest('albums', {
    fields: 'id,name,description,photos{images,name}',
    limit: 8
  });

  if (!response?.data?.length) {
    return [];
  }

  return response.data
    .map((album) => ({
      title: album.name || 'Facebook album',
      description: album.description || 'Importované z Facebook albumu.',
      photos:
        album.photos?.data
          ?.map((photo) => ({
            src: photo.images?.[0]?.source,
            alt: photo.name || album.name || 'Facebook album'
          }))
          .filter((photo) => photo.src) || [],
      source: 'facebook'
    }))
    .filter((album) => album.photos.length);
}

export async function getEvents() {
  const configuredSources = parseSources(process.env.EVENT_SOURCES, ['local', 'facebook']);
  const events = [];

  for (const source of configuredSources) {
    if (source === 'local') {
      events.push(...sampleEvents.map((event) => ({ ...event, source: 'local' })));
    }

    if (source === 'facebook') {
      events.push(...(await getFacebookEvents()));
    }

    if (source === 'google-calendar') {
      const feed = await fetchJsonFeed(process.env.GOOGLE_CALENDAR_FEED_URL);
      if (feed) {
        events.push(...feed.map((event, index) => normalizeEvent(event, 'google-calendar', index)).filter(Boolean));
      }
    }
  }

  return events.length ? events : sampleEvents;
}

export async function getGalleries() {
  const configuredSources = parseSources(process.env.GALLERY_SOURCES, ['local', 'facebook']);
  const galleries = [];

  for (const source of configuredSources) {
    if (source === 'local') {
      galleries.push(...sampleGalleries.map((gallery) => ({ ...gallery, source: 'local' })));
    }

    if (source === 'facebook') {
      galleries.push(...(await getFacebookGalleries()));
    }

    if (source === 'google-photos') {
      const feed = await fetchJsonFeed(process.env.GOOGLE_PHOTOS_FEED_URL);
      if (feed) {
        galleries.push(...feed.map((gallery, index) => normalizeGallery(gallery, 'google-photos', index)).filter(Boolean));
      }
    }

    if (source === 'google-drive') {
      const feed = await fetchJsonFeed(process.env.GOOGLE_DRIVE_ALBUMS_FEED_URL);
      if (feed) {
        galleries.push(...feed.map((gallery, index) => normalizeGallery(gallery, 'google-drive', index)).filter(Boolean));
      }
    }

    if (source === 'instagram') {
      const feed = await fetchJsonFeed(process.env.INSTAGRAM_ALBUMS_FEED_URL);
      if (feed) {
        galleries.push(...feed.map((gallery, index) => normalizeGallery(gallery, 'instagram', index)).filter(Boolean));
      }
    }
  }

  return galleries.length ? galleries : sampleGalleries;
}
