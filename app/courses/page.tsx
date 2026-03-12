import { getDictionary } from '@/lib/i18n';
import { getServerLanguage } from '@/lib/i18n-server';

export default function CoursesPage() {
  const t = getDictionary(getServerLanguage());
  const courses = [
    {
      level: t.courseBeginnerTitle,
      schedule: t.courseBeginnerSchedule,
      description: t.courseBeginnerDescription
    },
    {
      level: t.courseImproverTitle,
      schedule: t.courseImproverSchedule,
      description: t.courseImproverDescription
    },
    {
      level: t.courseSoloTitle,
      schedule: t.courseSoloSchedule,
      description: t.courseSoloDescription
    }
  ];

  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">{t.coursesTitle}</h1>
      <div className="grid gap-4 md:grid-cols-2">
        {courses.map((course) => (
          <article key={course.level} className="rounded-xl border border-slate-800 bg-slate-900 p-6">
            <h2 className="text-xl font-semibold">{course.level}</h2>
            <p className="mt-1 text-accent">{course.schedule}</p>
            <p className="mt-2 text-slate-300">{course.description}</p>
          </article>
        ))}
      </div>
    </section>
  );
}
