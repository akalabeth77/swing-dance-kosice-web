'use client';

import { createContext, useContext, useEffect, useMemo, useState } from 'react';
import { defaultLanguage, getDictionary, isLanguage, type Language, type TranslationKey } from '@/lib/i18n';

type LanguageContextValue = {
  language: Language;
  setLanguage: (language: Language) => void;
  t: (key: TranslationKey) => string;
};

const LanguageContext = createContext<LanguageContextValue | null>(null);

export function LanguageProvider({ children, initialLanguage }: { children: React.ReactNode; initialLanguage: Language }) {
  const [language, setLanguage] = useState<Language>(initialLanguage);

  useEffect(() => {
    const storedLanguage = window.localStorage.getItem('lang') ?? undefined;

    if (isLanguage(storedLanguage) && storedLanguage !== language) {
      setLanguage(storedLanguage);
    }
  }, [language]);

  useEffect(() => {
    document.documentElement.lang = language;
    window.localStorage.setItem('lang', language);
    document.cookie = `lang=${language}; path=/; max-age=31536000; samesite=lax`;
  }, [language]);

  const value = useMemo<LanguageContextValue>(() => {
    const dictionary = getDictionary(language);

    return {
      language,
      setLanguage,
      t: (key: TranslationKey) => dictionary[key]
    };
  }, [language]);

  return <LanguageContext.Provider value={value}>{children}</LanguageContext.Provider>;
}

export function useI18n() {
  const context = useContext(LanguageContext);

  if (!context) {
    const dictionary = getDictionary(defaultLanguage);

    return {
      language: defaultLanguage,
      setLanguage: () => undefined,
      t: (key: TranslationKey) => dictionary[key]
    };
  }

  return context;
}
