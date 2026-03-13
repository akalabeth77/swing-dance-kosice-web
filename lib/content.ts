import { getSupabaseClient } from '@/lib/supabase';

export type MenuItem = {
  id: string;
  label: string;
  href: string;
  sort_order: number;
};

export type Article = {
  id: string;
  title: string;
  excerpt: string;
  content: string;
  slug: string;
  published_at: string;
};

export type Course = {
  id: string;
  name: string;
  level: string;
  schedule: string;
  description: string;
};

export async function getPublicMenuItems(): Promise<MenuItem[]> {
  try {
    const supabase = getSupabaseClient();
    const { data, error } = await supabase
      .from('menu_items')
      .select('id, label, href, sort_order')
      .order('sort_order', { ascending: true })
      .order('created_at', { ascending: true });

    if (error) {
      return [];
    }

    return data ?? [];
  } catch {
    return [];
  }
}

export async function getPublishedArticles(limit = 6): Promise<Article[]> {
  try {
    const supabase = getSupabaseClient();
    const { data, error } = await supabase
      .from('articles')
      .select('id, title, excerpt, content, slug, published_at')
      .order('published_at', { ascending: false })
      .limit(limit);

    if (error) {
      return [];
    }

    return data ?? [];
  } catch {
    return [];
  }
}

const defaultCourses: Course[] = [
  {
    id: 'fallback-lindy-hop-beginners-1',
    name: 'Lindy Hop Beginners 1',
    level: 'Beginners',
    schedule: 'Pondelok 18:00',
    description: 'Úplné základy Lindy Hopu pre nových tanečníkov.'
  },
  {
    id: 'fallback-collegiate-shag-beginners-1',
    name: 'Collegiate Shag Beginners 1',
    level: 'Beginners',
    schedule: 'Streda 19:00',
    description: 'Rýchly, hravý a energický kurz Collegiate Shag od nuly.'
  }
];

export async function getCourses(): Promise<Course[]> {
  try {
    const supabase = getSupabaseClient();
    const { data, error } = await supabase
      .from('courses')
      .select('id, name, level, schedule, description')
      .order('sort_order', { ascending: true })
      .order('created_at', { ascending: true });

    if (error || !data || data.length === 0) {
      return defaultCourses;
    }

    return data;
  } catch {
    return defaultCourses;
  }
}
