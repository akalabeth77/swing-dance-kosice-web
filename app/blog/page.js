import Link from 'next/link';
import { PageHeader } from '@/components/SiteShell';
import { blogArticles, formatDate } from '@/lib/site-data';

export default function BlogPage() {
  return (
    <>
      <PageHeader
        eyebrow="📝 Blog"
        title="Workshop blog a community updates"
        description="Sekcia pre recapy, rozhovory s lektormi, SEO články aj long-form obsah po eventoch."
      />

      <div className="card-grid two-up">
        {blogArticles.map((article) => (
          <article className="card article-card" key={article.slug}>
            <img alt={article.title} src={article.cover} />
            <div className="meta">{formatDate(article.date)}</div>
            <h2>{article.title}</h2>
            <p>{article.excerpt}</p>
            <Link href={`/blog/${article.slug}`}>Čítať článok →</Link>
          </article>
        ))}
      </div>
    </>
  );
}
