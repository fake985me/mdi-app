import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import App from './App.vue';
import router from './router';

// Create a new Vue application
const app = createApp(App);

// Use the router
app.use(router);

// Mount the Vue application to the element with id 'app'
app.mount('#app');