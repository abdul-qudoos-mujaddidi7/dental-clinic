import { createI18n } from 'vue-i18n';
import EN from './locales/en.json';
import DARI from './locales/fa.json';

const messages = {
    en: EN,
    fa: DARI,

};

const i18n = createI18n({
    legacy: false, 
    locale: "en", 
    fallbackLocale: "en",
    messages,
});

export default i18n;
