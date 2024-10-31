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
import "../css/app.css";
import "vuetify/styles"; 
import vuetify from "../plugins/vuetify";
import router from "./router.js";
import App from "./App.vue";

const app = createApp(App);
app.use(router);
app.use(createPinia());
app.use(vuetify); 
app.mount("#app");
