import './bootstrap';
import Vue from 'vue';
import App from './components/App.vue';
import router from './router';

// 1. Importamos el plugin y su CSS
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

// 2. Le decimos a Vue que use el plugin
Vue.use(Toast, {
    // Aquí puedes añadir opciones de configuración si quieres
    transition: "Vue-Toastification__bounce",
    maxToasts: 5,
    newestOnTop: true
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});