import { createApp } from "vue";
import "./bootstrap.js";
import { createPinia } from "pinia";
import router from "./router.js";
import App from "./App.vue";

import ExampleComponent from "./components/exp.vue";
import AllExpenses from "./components/expenses/allExpenses/AllExpenses.vue";
import vuetify from "../plugins/vuetify";
import "../css/app.css";
import "vuetify/styles"; 

const app = createApp({});

app.use(router);
app.use(createPinia());
app.use(vuetify); 

app.component("example-component", ExampleComponent);
app.component("Expense", AllExpenses);


app.mount("#app");
