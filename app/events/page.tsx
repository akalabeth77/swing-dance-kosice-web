import { EventCalendar } from '@/components/EventCalendar';

export default function EventsPage() {
  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">Event Calendar</h1>
      <p className="text-slate-300">Loaded from Facebook Graph API via secure Next.js API route.</p>
      <EventCalendar />
    </section>
  );
}
