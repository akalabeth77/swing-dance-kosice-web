'use client';

import { useEffect, useState } from 'react';
import { EventCard, FacebookEvent } from '@/components/EventCard';
import { useI18n } from '@/components/LanguageProvider';

export function EventCalendar() {
  const { t } = useI18n();
  const [events, setEvents] = useState<FacebookEvent[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const load = async () => {
      try {
        const res = await fetch('/api/facebook-events', { cache: 'no-store' });
        if (!res.ok) throw new Error(t('eventsLoadError'));
        const json = await res.json();
        setEvents(json.events ?? []);
      } catch (err) {
        setError(err instanceof Error ? err.message : t('unknownError'));
      } finally {
        setLoading(false);
      }
    };

    void load();
  }, [t]);

  if (loading) return <div className="rounded-lg bg-slate-900 p-4">{t('eventsLoading')}</div>;
  if (error) return <div className="rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-red-200">{error}</div>;
  if (events.length === 0) return <div className="rounded-lg bg-slate-900 p-4">{t('eventsNoUpcoming')}</div>;

  return (
    <div className="grid gap-4 md:grid-cols-2">
      {events.map((event) => (
        <EventCard key={event.id} event={event} />
      ))}
    </div>
  );
}
