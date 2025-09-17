import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router/router.js';

// Create a new Vue application
const app = createApp(App);

// Use the router
app.use(createPinia());
app.use(router);

// Mount the Vue application to the element with id 'app'
app.mount('#app');