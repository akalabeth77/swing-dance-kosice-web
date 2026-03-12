import { cookies } from 'next/headers';
import { defaultLanguage, isLanguage, type Language } from '@/lib/i18n';

export function getServerLanguage(): Language {
  const cookieStore = cookies();
  const cookieLanguage = cookieStore.get('lang')?.value;
  return isLanguage(cookieLanguage) ? cookieLanguage : defaultLanguage;
}
