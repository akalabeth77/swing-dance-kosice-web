const courses = [
  {
    level: 'Beginner Lindy Hop',
    schedule: 'Mondays 18:00',
    description: 'Perfect for first-time dancers. Learn basic rhythm, connection, and social confidence.'
  },
  {
    level: 'Improver Swing',
    schedule: 'Wednesdays 19:00',
    description: 'Build vocabulary, musicality, and partner communication with intermediate concepts.'
  },
  {
    level: 'Solo Jazz',
    schedule: 'Fridays 17:30',
    description: 'Classic jazz steps and choreography to boost style and groove.'
  }
];

export default function CoursesPage() {
  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">Courses</h1>
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
