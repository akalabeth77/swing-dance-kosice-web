export const languages = ['en', 'sk'] as const;

export type Language = (typeof languages)[number];

export const defaultLanguage: Language = 'en';

export function isLanguage(value: string | undefined): value is Language {
  return value === 'en' || value === 'sk';
}

export const dictionary = {
  en: {
    siteName: 'Swing Dance Košice',
    navHome: 'Home',
    navEvents: 'Events',
    navGallery: 'Gallery',
    navCourses: 'Courses',
    navAdmin: 'Admin',
    navLanguage: 'Language',

    homeLead:
      'Discover lindy hop socials, classes, and workshops in Košice. Join our friendly community and keep dancing.',
    homeUpcomingEvents: 'Upcoming events',
    homeExploreCourses: 'Explore courses',
    featureEventsTitle: 'Events',
    featureEventsDescription: 'Facebook-powered event calendar to stay up to date.',
    featureGalleryTitle: 'Gallery',
    featureGalleryDescription: 'Highlights from social dances and workshops.',
    featureCoursesTitle: 'Courses',
    featureCoursesDescription: 'Course info for beginners and advanced dancers.',

    coursesTitle: 'Courses',
    courseBeginnerTitle: 'Beginner Lindy Hop',
    courseBeginnerSchedule: 'Mondays 18:00',
    courseBeginnerDescription:
      'Perfect for first-time dancers. Learn basic rhythm, connection, and social confidence.',
    courseImproverTitle: 'Improver Swing',
    courseImproverSchedule: 'Wednesdays 19:00',
    courseImproverDescription:
      'Build vocabulary, musicality, and partner communication with intermediate concepts.',
    courseSoloTitle: 'Solo Jazz',
    courseSoloSchedule: 'Fridays 17:30',
    courseSoloDescription: 'Classic jazz steps and choreography to boost style and groove.',

    eventsTitle: 'Event Calendar',
    eventsDescription: 'Loaded from Facebook Graph API via secure Next.js API route.',
    eventsLoading: 'Loading events…',
    eventsNoDate: 'Date TBD',
    eventsNoLocation: 'Location TBD',
    eventsNoUpcoming: 'No upcoming events found.',
    eventsLoadError: 'Failed to load events',
    unknownError: 'Unknown error',

    galleryTitle: 'Gallery',
    galleryDescription: 'Moments from our swing dance nights in Košice.',
    galleryImage1Alt: 'Swing dance social',
    galleryImage2Alt: 'Couple dancing lindy hop',
    galleryImage3Alt: 'Swing dance workshop',

    adminTitle: 'Admin',
    adminDescription: 'Minimal admin overview connected to Supabase.',
    adminErrorPrefix: 'Supabase error:',
    adminLatestAnnouncements: 'Latest announcements',
    adminNoAnnouncements: 'No announcements found.'
  },
  sk: {
    siteName: 'Swing Dance Košice',
    navHome: 'Domov',
    navEvents: 'Podujatia',
    navGallery: 'Galéria',
    navCourses: 'Kurzy',
    navAdmin: 'Admin',
    navLanguage: 'Jazyk',

    homeLead:
      'Objav lindy hop socials, kurzy a workshopy v Košiciach. Pridaj sa k našej priateľskej komunite a tancuj s nami.',
    homeUpcomingEvents: 'Nadchádzajúce podujatia',
    homeExploreCourses: 'Pozrieť kurzy',
    featureEventsTitle: 'Podujatia',
    featureEventsDescription: 'Kalendár podujatí napojený na Facebook, aby si mal všetko aktuálne.',
    featureGalleryTitle: 'Galéria',
    featureGalleryDescription: 'Momentky zo social dance večerov a workshopov.',
    featureCoursesTitle: 'Kurzy',
    featureCoursesDescription: 'Informácie o kurzoch pre začiatočníkov aj pokročilých.',

    coursesTitle: 'Kurzy',
    courseBeginnerTitle: 'Lindy Hop pre začiatočníkov',
    courseBeginnerSchedule: 'Pondelok 18:00',
    courseBeginnerDescription:
      'Ideálne pre úplných začiatočníkov. Naučíš sa základný rytmus, vedenie a istotu na parkete.',
    courseImproverTitle: 'Swing pre mierne pokročilých',
    courseImproverSchedule: 'Streda 19:00',
    courseImproverDescription:
      'Rozšír si slovník krokov, muzikálnosť a komunikáciu v páre pomocou pokročilejších konceptov.',
    courseSoloTitle: 'Solo Jazz',
    courseSoloSchedule: 'Piatok 17:30',
    courseSoloDescription: 'Klasické jazzové kroky a choreografie pre lepší štýl a groove.',

    eventsTitle: 'Kalendár podujatí',
    eventsDescription: 'Načítané z Facebook Graph API cez zabezpečenú Next.js API route.',
    eventsLoading: 'Načítavam podujatia…',
    eventsNoDate: 'Dátum bude doplnený',
    eventsNoLocation: 'Miesto bude doplnené',
    eventsNoUpcoming: 'Žiadne nadchádzajúce podujatia.',
    eventsLoadError: 'Nepodarilo sa načítať podujatia',
    unknownError: 'Neznáma chyba',

    galleryTitle: 'Galéria',
    galleryDescription: 'Momenty z našich swingových večerov v Košiciach.',
    galleryImage1Alt: 'Swingový social',
    galleryImage2Alt: 'Pár tancujúci lindy hop',
    galleryImage3Alt: 'Swingový workshop',

    adminTitle: 'Admin',
    adminDescription: 'Jednoduchý administrátorský prehľad napojený na Supabase.',
    adminErrorPrefix: 'Chyba Supabase:',
    adminLatestAnnouncements: 'Najnovšie oznamy',
    adminNoAnnouncements: 'Nenašli sa žiadne oznamy.'
  }
} as const;

export type TranslationKey = keyof (typeof dictionary)[Language];

export function getDictionary(language: Language) {
  return dictionary[language];
}
