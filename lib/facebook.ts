import { FacebookEvent } from '@/components/EventCard';

type FacebookEventsResponse = {
  data?: FacebookEvent[];
};

export async function fetchFacebookEvents(): Promise<FacebookEvent[]> {
  const pageId = process.env.FB_PAGE_ID;
  const accessToken = process.env.FB_ACCESS_TOKEN;

  if (!pageId || !accessToken) {
    throw new Error('Missing FB_PAGE_ID or FB_ACCESS_TOKEN');
  }

  const query = new URLSearchParams({
    access_token: accessToken,
    fields: 'id,name,start_time,place,description',
    since: Math.floor(Date.now() / 1000).toString()
  });

  const url = `https://graph.facebook.com/v20.0/${pageId}/events?${query.toString()}`;

  const res = await fetch(url, {
    method: 'GET',
    next: { revalidate: 300 }
  });

  if (!res.ok) {
    const text = await res.text();
    throw new Error(`Facebook API error: ${res.status} ${text}`);
  }

  const json = (await res.json()) as FacebookEventsResponse;
  return json.data ?? [];
}
