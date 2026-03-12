import Link from 'next/link';

export default function HomePage() {
  return (
    <section className="space-y-10">
      <div className="rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 p-10 text-slate-950 shadow-xl">
        <h1 className="text-4xl font-bold md:text-6xl">Swing Dance Košice</h1>
        <p className="mt-4 max-w-2xl text-lg">
          Discover lindy hop socials, classes, and workshops in Košice. Join our friendly community and keep dancing.
        </p>
        <div className="mt-6 flex gap-4">
          <Link href="/events" className="rounded-md bg-slate-950 px-4 py-2 font-semibold text-white">
            Upcoming events
          </Link>
          <Link href="/courses" className="rounded-md border border-slate-950 px-4 py-2 font-semibold">
            Explore courses
          </Link>
        </div>
      </div>

      <div className="grid gap-6 md:grid-cols-3">
        <FeatureCard title="Events" description="Facebook-powered event calendar to stay up to date." href="/events" />
        <FeatureCard title="Gallery" description="Highlights from social dances and workshops." href="/gallery" />
        <FeatureCard title="Courses" description="Course info for beginners and advanced dancers." href="/courses" />
      </div>
    </section>
  );
}

function FeatureCard({ title, description, href }: { title: string; description: string; href: string }) {
  return (
    <Link href={href} className="rounded-xl border border-slate-800 bg-slate-900 p-6 transition hover:border-accent">
      <h2 className="text-xl font-semibold">{title}</h2>
      <p className="mt-2 text-slate-300">{description}</p>
    </Link>
  );
}
