<template>
    <div class="bg-gray-800 p-4 sm:p-6 rounded-lg shadow-lg">
        <div class="flex border-b border-gray-700 mb-6">
            <button @click="activeTab = 'citas'" :class="{ 'active': activeTab === 'citas' }" class="tab-button">
                Citas
            </button>
            <button @click="activeTab = 'clientes'" :class="{ 'active': activeTab === 'clientes' }" class="tab-button">
                Clientes
            </button>
            <button @click="activeTab = 'artistas'" :class="{ 'active': activeTab === 'artistas' }" class="tab-button">
                Artistas
            </button>
        </div>

        <div>
            <div v-show="activeTab === 'citas'">
                <Citas />
            </div>
            <div v-show="activeTab === 'clientes'">
                <Clientes />
            </div>
            <div v-show="activeTab === 'artistas'">
                <Artistas />
            </div>
        </div>
    </div>
</template>

<script>
import Clientes from '../components/Clientes.vue';
import Artistas from '../components/Artistas.vue';
import Citas from '../components/Citas.vue';

export default {
    name: 'Dashboard',
    components: {
        Clientes,
        Artistas,
        Citas
    },
    data() {
        return {
            // 3. Variable que controla qué pestaña está activa.
            //    Por defecto, mostramos 'citas' al cargar.
            activeTab: 'citas'
        }
    }
}
</script>