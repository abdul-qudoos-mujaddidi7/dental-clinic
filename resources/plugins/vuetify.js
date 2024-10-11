import '../css/app.css'; // Your Tailwind CSS file
import 'vuetify/styles'; // Import Vuetify's base styles
import { createVuetify } from 'vuetify'; // Import Vuetify
import { aliases, mdi } from 'vuetify/iconsets/mdi'; // Material Design icons

// Create Vuetify instance
const vuetify = createVuetify({
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
  theme: {
    themes: {
      light: {
        primary: '#6200EE',
        secondary: '#03DAC6',
        accent: '#BB86FC',
      },
    },
  },
});

export default vuetify;
