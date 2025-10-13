<template>
    <div class="bg-gray-900 min-h-screen text-gray-200 font-sans">
        <div class="container mx-auto p-4 md:p-8">
            <header class="flex justify-between items-center mb-12">
                
                <div>
                    <router-link to="/" v-if="$route.name !== 'home'">
                        <img src="/images/logo-inkflow.png" alt="InkFlow CRM Logo" class="h-12 md:h-16">
                    </router-link>

                    <h1 v-else class="text-2xl font-bold text-cyan-400">
                        InkFlow CRM
                    </h1>
                </div>

                <nav class="space-x-6">
                    <router-link to="/" class="nav-link">Inicio</router-link>
                    <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
                </nav>
            </header>

            <main>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script>
export default {
    name: 'App'
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