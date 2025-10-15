import './bootstrap';
import Vue from 'vue';
import App from './components/App.vue';
import router from './router';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

// ====================================================================
// === INICIO DE LA SOLUCIÓN: CONFIGURACIÓN DE AXIOS AL ARRANCAR ===
// ====================================================================

// 1. Buscamos el token en el localStorage (el "bolsillo")
const authToken = localStorage.getItem('authToken');

// 2. Si encontramos un token...
if (authToken) {
    // 3. Le decimos a Axios que lo use en TODAS las futuras peticiones
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
}

// ====================================================================
// === FIN DE LA SOLUCIÓN =============================================
// ====================================================================


Vue.use(Toast, {
    transition: "Vue-Toastification__bounce",
    maxToasts: 5,
    newestOnTop: true
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});