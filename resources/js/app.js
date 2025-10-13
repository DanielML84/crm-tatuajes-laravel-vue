import './bootstrap';
import Vue from 'vue';
import App from './components/App.vue';
import router from './router'; // <-- 1. Importamos nuestro router

const app = new Vue({
    el: '#app',
    router, // <-- 2. Le pasamos el router a la instancia de Vue
    render: h => h(App)
});