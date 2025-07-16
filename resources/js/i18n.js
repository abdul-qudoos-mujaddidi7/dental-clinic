// src/i18n/index.js or plugins/i18n.js
import { createI18n } from "vue-i18n";
import en from "./locales/en.json";
import fa from "./locales/fa.json";
import pa from "./locales/pa.json";

const i18n = createI18n({
  legacy: false,
  locale: "en", // or load from localStorage
  messages: {
    en,
    fa,
    pa,
  },
});

export default i18n;
