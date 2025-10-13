<template>
    <div class="bg-gray-900 min-h-screen text-gray-200 font-sans">
        <div class="container mx-auto p-4 md:p-8">
            <header class="flex justify-between items-center mb-12">
                <router-link to="/">
                    <img v-if="$route.name !== 'home'" src="/images/logo-inkflow.png" alt="InkFlow CRM Logo" class="h-12 md:h-16">
                    <h1 v-else class="text-2xl font-bold text-cyan-400">InkFlow CRM</h1>
                </router-link>
                
                <nav class="space-x-6">
                    <router-link to="/" class="nav-link">Inicio</router-link>
                    
                    <router-link v-if="isLoggedIn" to="/dashboard" class="nav-link">Dashboard</router-link>

                    <a v-if="isLoggedIn" @click="logout" href="#" class="nav-link cursor-pointer">Cerrar Sesión</a>
                    <router-link v-else to="/login" class="nav-link">Iniciar Sesión</router-link>
                </nav>
            </header>

            <main>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script>
import auth from '../auth'; // Importamos el cerebro

export default {
    name: 'App',
    data() {
        return {
            isLoggedIn: !!localStorage.getItem('authToken')
        }
    },
    methods: {
        logout() {
            auth.logout();
            // Actualizamos el estado para que la barra de navegación cambie
            this.isLoggedIn = false;
        }
    },
    // Este "watcher" observa los cambios de ruta. Si cambiamos de página,
    // vuelve a comprobar si estamos logueados para mantener la barra de nav actualizada.
    watch: {
        '$route'() {
            this.isLoggedIn = !!localStorage.getItem('authToken');
        }
    }
}
</script>

<style>
/* Estilos para los enlaces de navegación */
.nav-link {
    @apply text-gray-300 hover:text-cyan-400 transition duration-300;
}
/* Estilo para el enlace activo */
.router-link-exact-active {
    @apply text-cyan-400 font-bold;
}
</style>