import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './pages/Home.vue';
import Dashboard from './pages/Dashboard.vue';
import Login from './pages/Login.vue'; // <-- 1. Importamos la nueva página de Login

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login', // <-- 2. Añadimos la nueva ruta para el login
        name: 'login',
        component: Login
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true } // <-- 3. Marcamos esta ruta como protegida
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

// 4. AÑADIMOS UN "GUARDIA DE NAVEGACIÓN"
// Este código se ejecuta ANTES de cada cambio de ruta.
router.beforeEach((to, from, next) => {
    // Comprueba si la ruta a la que vamos (to) requiere autenticación
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // Si requiere autenticación, comprobamos si tenemos un token en el localStorage
        if (!localStorage.getItem('authToken')) {
            // Si NO hay token, redirigimos al login
            next({ name: 'login' });
        } else {
            // Si SÍ hay token, permitimos el paso
            next();
        }
    } else {
        // Si la ruta no requiere autenticación, permitimos el paso
        next();
    }
});

export default router;