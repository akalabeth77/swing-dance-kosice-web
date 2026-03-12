import { EventCalendar } from '@/components/EventCalendar';
import { getDictionary } from '@/lib/i18n';
import { getServerLanguage } from '@/lib/i18n-server';

export default function EventsPage() {
  const t = getDictionary(getServerLanguage());

  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">{t.eventsTitle}</h1>
      <p className="text-slate-300">{t.eventsDescription}</p>
      <EventCalendar />
    </section>
  );
}
