import { createI18n } from 'vue-i18n';
import en from './locales/en';
import fa from './locales/fa';

const i18n = createI18n({
  locale: 'en', // Set default language to English
  messages: {
    en,
    fa,
  },
});

export default i18n;
