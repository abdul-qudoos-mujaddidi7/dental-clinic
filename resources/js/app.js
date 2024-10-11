import { createApp } from 'vue';
import { createPinia } from 'pinia'; // Pinia for state management

import ExampleComponent from './components/exp.vue';
import vuetify from '../plugins/vuetify'; 
import "../css/app.css"; 
import "vuetify/styles";



const app = createApp({});


app.use(createPinia());
app.use(vuetify);

// Register components
app.component('example-component', ExampleComponent);

// Mount the app
app.mount('#app');
