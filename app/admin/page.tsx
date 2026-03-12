import { getSupabaseClient } from '@/lib/supabase';
import { getDictionary } from '@/lib/i18n';
import { getServerLanguage } from '@/lib/i18n-server';

export const dynamic = 'force-dynamic';

async function getAnnouncements() {
  const supabase = getSupabaseClient();

  const { data, error } = await supabase
    .from('announcements')
    .select('id, title, created_at')
    .order('created_at', { ascending: false })
    .limit(10);

  if (error) {
    return { error: error.message, data: [] };
  }

  return { error: null, data: data ?? [] };
}

export default async function AdminPage() {
  const { error, data } = await getAnnouncements();
  const language = getServerLanguage();
  const t = getDictionary(language);
  const locale = language === 'sk' ? 'sk-SK' : 'en-US';

  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold">{t.adminTitle}</h1>
      <p className="text-slate-300">{t.adminDescription}</p>

      {error ? (
        <div className="rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-red-200">
          {t.adminErrorPrefix} {error}
        </div>
      ) : (
        <div className="rounded-xl border border-slate-800 bg-slate-900 p-6">
          <h2 className="text-xl font-semibold">{t.adminLatestAnnouncements}</h2>
          <ul className="mt-4 space-y-2">
            {data.length === 0 ? (
              <li className="text-slate-400">{t.adminNoAnnouncements}</li>
            ) : (
              data.map((item) => (
                <li key={item.id} className="flex items-center justify-between rounded-md bg-slate-800 p-3">
                  <span>{item.title}</span>
                  <span className="text-sm text-slate-400">{new Date(item.created_at).toLocaleDateString(locale)}</span>
                </li>
              ))
            )}
          </ul>
        </div>
      )}
    </section>
  );
}
