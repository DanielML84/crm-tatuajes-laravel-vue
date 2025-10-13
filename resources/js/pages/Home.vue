<template>
    <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16">
        
        <div class="w-full md:w-1/2">
            <img src="/images/hero-image.png" alt="Estudio de Tatuajes" class="rounded-lg shadow-2xl shadow-cyan-500/20">
        </div>

        <div class="w-full md:w-1/2 text-center md:text-left">
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-100 leading-tight">
                Gestiona tu arte con <span class="text-cyan-400">InkFlow CRM</span>
            </h2>
            <p class="text-gray-400 mt-4 text-lg">
                La herramienta definitiva para organizar tus clientes, artistas y citas en un solo lugar.
            </p>
            
            <router-link to="/dashboard" class="btn btn-primary text-lg mt-8 inline-block">
                Entrar al Panel de Control
            </router-link>
        </div>

    </div>
</template>

<script>
export default {
    name: 'Home'
}
</script>