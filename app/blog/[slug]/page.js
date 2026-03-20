import { notFound } from 'next/navigation';
import { blogArticles, formatDate } from '@/lib/site-data';

export function generateStaticParams() {
  return blogArticles.map((article) => ({ slug: article.slug }));
}

export default function ArticlePage({ params }) {
  const article = blogArticles.find((item) => item.slug === params.slug);

  if (!article) {
    notFound();
  }

  return (
    <article className="card prose article-detail">
      <div className="meta">{formatDate(article.date)}</div>
      <h1>{article.title}</h1>
      <p className="lead">{article.excerpt}</p>
      {article.body.map((paragraph) => (
        <p key={paragraph}>{paragraph}</p>
      ))}
      <ul className="inline-list tags">
        {article.tags.map((tag) => (
          <li key={tag}>{tag}</li>
        ))}
      </ul>
    </article>
  );
}
