import { notFound } from 'next/navigation';
import { courses } from '@/lib/site-data';

export function generateStaticParams() {
  return courses.map((course) => ({ slug: course.slug }));
}

export default function CourseRegistrationPage({ params, searchParams }) {
  const course = courses.find((item) => item.slug === params.slug);

  if (!course) {
    notFound();
  }

  const state = searchParams.state;

  return (
    <>
      {state === 'success' ? <div className="flash flash-success">Registrácia bola odoslaná. Ak nastavíš webhook, môže sa rovno poslať do CRM alebo e-mailu.</div> : null}
      {state === 'error' ? <div className="flash flash-error">Prosím doplň meno a e-mail.</div> : null}

      <section className="section-grid two-up">
        <article className="card">
          <span className="eyebrow">Kurz registrácia</span>
          <h1>{course.title}</h1>
          <p>{course.description}</p>
          <ul className="feature-list compact">
            <li>{course.schedule}</li>
            <li>{course.location}</li>
            <li>{course.price}</li>
            <li>{course.spots}</li>
          </ul>
          <h2>Benefity</h2>
          <ul className="feature-list compact">
            {course.benefits.map((benefit) => (
              <li key={benefit}>{benefit}</li>
            ))}
          </ul>
        </article>

        <form action="/api/register" className="card form-card" method="post">
          <h2>Prihláška</h2>
          <input name="slug" type="hidden" value={course.slug} />
          <label>
            Meno a priezvisko
            <input name="name" required type="text" />
          </label>
          <label>
            E-mail
            <input name="email" required type="email" />
          </label>
          <label>
            Telefón
            <input name="phone" type="text" />
          </label>
          <label>
            Tanečná rola
            <select name="dance_role">
              <option value="">Vyber si</option>
              <option value="lead">Lead</option>
              <option value="follow">Follow</option>
              <option value="switch">Switch</option>
            </select>
          </label>
          <label>
            Poznámka
            <textarea name="notes" placeholder="Partner, skúsenosti, otázky..." rows="5" />
          </label>
          <button className="button primary" type="submit">
            Odoslať registráciu
          </button>
        </form>
      </section>
    </>
  );
}
