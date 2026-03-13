import { getDictionary } from '@/lib/i18n';
import { getServerLanguage } from '@/lib/i18n-server';
import { getCourses } from '@/lib/content';

export default async function CoursesPage() {
  const t = getDictionary(getServerLanguage());
  const courses = await getCourses();

  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">{t.coursesTitle}</h1>
      <p className="text-slate-300">Aktuálne otvorené kurzy spravované cez redakčný systém.</p>
      <div className="grid gap-4 md:grid-cols-2">
        {courses.map((course) => (
          <article key={course.id} className="rounded-xl border border-slate-800 bg-slate-900 p-6">
            <h2 className="text-xl font-semibold">{course.name}</h2>
            <p className="mt-1 text-accent">{course.schedule}</p>
            <p className="mt-2 text-sm text-slate-400">{course.level}</p>
            <p className="mt-2 text-slate-300">{course.description}</p>
          </article>
        ))}
      </div>
    </section>
  );
}
