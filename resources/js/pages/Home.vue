<template>
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-100 mb-4">Bienvenido al CRM del Estudio</h2>
        <p class="text-gray-400 mb-8">
            Gestiona tus clientes, artistas y citas de forma eficiente.
        </p>
        <router-link to="/dashboard" class="btn btn-primary text-lg">
            Entrar al Panel de Control
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'Home'
}
</script>