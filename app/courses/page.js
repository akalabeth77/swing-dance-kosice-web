import Link from 'next/link';
import { PageHeader } from '@/components/SiteShell';
import { courses } from '@/lib/site-data';

export default function CoursesPage() {
  return (
    <>
      <PageHeader
        eyebrow="🕺 Kurzy"
        title="Registrácie na kurzy"
        description="Každý kurz má vlastný detail a Vercel-safe registračný formulár pripravený na webhook alebo CRM integráciu."
      />

      <div className="card-grid two-up">
        {courses.map((course) => (
          <article className="card" key={course.slug}>
            <h2>{course.title}</h2>
            <ul className="feature-list compact">
              <li>{course.schedule}</li>
              <li>{course.location}</li>
              <li>{course.price}</li>
              <li>{course.spots}</li>
            </ul>
            <p>{course.description}</p>
            <Link className="button primary" href={`/courses/${course.slug}/register`}>
              Registrovať sa
            </Link>
          </article>
        ))}
      </div>
    </>
  );
}
