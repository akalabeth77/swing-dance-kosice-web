export type FacebookEvent = {
  id: string;
  name: string;
  start_time?: string;
  place?: {
    name?: string;
  };
  description?: string;
};

export function EventCard({ event }: { event: FacebookEvent }) {
  return (
    <article className="rounded-xl border border-slate-800 bg-slate-900 p-5">
      <h3 className="text-lg font-semibold">{event.name}</h3>
      <p className="mt-1 text-sm text-slate-300">
        {event.start_time ? new Date(event.start_time).toLocaleString() : 'Date TBD'} • {event.place?.name ?? 'Location TBD'}
      </p>
      {event.description ? <p className="mt-3 text-slate-400">{event.description}</p> : null}
    </article>
  );
}
