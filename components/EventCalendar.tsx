'use client';

import { useEffect, useState } from 'react';
import { EventCard, FacebookEvent } from '@/components/EventCard';

export function EventCalendar() {
  const [events, setEvents] = useState<FacebookEvent[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const load = async () => {
      try {
        const res = await fetch('/api/facebook-events', { cache: 'no-store' });
        if (!res.ok) throw new Error('Failed to load events');
        const json = await res.json();
        setEvents(json.events ?? []);
      } catch (err) {
        setError(err instanceof Error ? err.message : 'Unknown error');
      } finally {
        setLoading(false);
      }
    };

    void load();
  }, []);

  if (loading) return <div className="rounded-lg bg-slate-900 p-4">Loading events…</div>;
  if (error) return <div className="rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-red-200">{error}</div>;
  if (events.length === 0) return <div className="rounded-lg bg-slate-900 p-4">No upcoming events found.</div>;

  return (
    <div className="grid gap-4 md:grid-cols-2">
      {events.map((event) => (
        <EventCard key={event.id} event={event} />
      ))}
    </div>
  );
}
