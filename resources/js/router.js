import Vue from 'vue';
import VueRouter from 'vue-router';

// Le decimos a Vue que use Vue Router
Vue.use(VueRouter);

// Importamos los componentes que actuarán como nuestras "páginas"
// (Los crearemos en el siguiente paso)
import Home from './pages/Home.vue';
import Dashboard from './pages/Dashboard.vue';

// Definimos las rutas
const routes = [
    {
        path: '/', // La URL raíz
        name: 'home',
        component: Home // Le decimos que muestre el componente Home
    },
    {
        path: '/dashboard', // La URL para nuestro CRM
        name: 'dashboard',
        component: Dashboard // Le decimos que muestre el componente Dashboard
    }
];

// Creamos la instancia del router
const router = new VueRouter({
    mode: 'history', // Usa el modo historial del navegador para URLs limpias
    routes // le pasamos el array de rutas que definimos arriba
});

export default router;