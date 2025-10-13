<template>
    <div class="bg-gray-900 min-h-screen text-gray-200 font-sans">
        <div id="main-container" class="container mx-auto p-4 md:p-8">
            <header class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-cyan-400">
                    Estudio de Tatuajes CRM
                </h1>
            </header>
            <main class="space-y-12">
                <Citas />
                <Clientes />
                <Artistas />
            </main>
        </div>
    </div>
</template>

<script>
import Clientes from './Clientes.vue';
import Artistas from './Artistas.vue';
import Citas from './Citas.vue';

export default {
    name: 'App',
    components: { Clientes, Artistas, Citas }
}
</script>