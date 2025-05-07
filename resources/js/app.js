// import { createApp } from "vue";
// import "./bootstrap.js";
// import { createPinia } from "pinia";
// import router from "./router.js";
// import "../css/app.css";
// import "vuetify/styles"; 
// import vuetify from "../plugins/vuetify";
// import App from "./App.vue";

// const app = createApp(App);

// app.use(router);
// app.use(createPinia());
// app.use(vuetify); 
// app.mount("#app");
import { createApp } from "vue";
import "./bootstrap.js";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate"; // ✅ Import plugin
import "../css/app.css";
import "vuetify/styles"; 
import vuetify from "../plugins/vuetify";
import router from "./router.js";
import App from "./App.vue";
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import i18n from './i18n';

const app = createApp(App);

// ✅ Create Pinia instance and apply plugin
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

app.component('DatePicker', DatePicker);
app.use(router);
app.use(i18n);
app.use(pinia); // ✅ Use the configured Pinia instance
app.use(vuetify); 
app.mount("#app");

