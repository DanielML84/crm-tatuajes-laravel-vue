<template>
    <div class="mt-6 border-t border-gray-700 pt-6">
        <h4 class="text-xl font-bold text-gray-200 mb-4">Hitos del Proyecto</h4>

        <form @submit.prevent="guardarHito" class="bg-gray-700 p-4 rounded-lg mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <input v-model="nuevoHito.titulo" placeholder="Título del hito" required class="form-input">
                <select v-model="nuevoHito.estado_hito_id" required class="form-input">
                    <option disabled value="">Selecciona un estado</option>
                    <option v-for="estado in estados" :key="estado.id" :value="estado.id">
                        {{ estado.nombre }}
                    </option>
                </select>
                <button type="submit" class="btn btn-primary">Añadir Hito</button>
            </div>
        </form>

        <ul class="space-y-3">
            <li v-for="hito in hitos" :key="hito.id" class="bg-gray-700 p-3 rounded-md flex justify-between items-center">
                <span class="text-gray-300">{{ hito.titulo }}</span>
                <div class="flex items-center space-x-3">
                    <span class="text-sm px-2 py-1 rounded-full" :class="estadoColor(hito.estado_hito_id)">
                        {{ hito.estado_hito.nombre }}
                    </span>
                    <button @click="eliminarHito(hito.id)" class="btn-icon btn-delete text-xs">Eliminar</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'GestionHitos',
    props: {
        citaId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            hitos: [],
            estados: [],
            nuevoHito: {
                titulo: '',
                estado_hito_id: ''
            }
        }
    },
    mounted() {
        this.getHitos();
        this.getEstados();
    },
    methods: {
        // MÉTODO CENTRALIZADO PARA MANEJAR ERRORES DE API
        handleApiError(error) {
            if (error.response && error.response.status === 401) {
                this.$router.push({ name: 'login' });
            } else {
                console.error("Error de API:", error);
                this.$toast.error('Ocurrió un error al procesar la solicitud.');
            }
        },
        getHitos() {
            axios.get(`/api/v1/citas/${this.citaId}/hitos`)
                .then(response => {
                    this.hitos = response.data;
                })
                .catch(this.handleApiError); // <-- USAMOS EL MANEJADOR
        },
        getEstados() {
            axios.get('/api/v1/estados-hitos')
                .then(response => {
                    this.estados = response.data;
                })
                .catch(this.handleApiError); // <-- ¡ASEGÚRATE DE QUE ESTA LÍNEA ESTÉ AQUÍ!
        },
        guardarHito() {
            const data = {
                ...this.nuevoHito,
                cita_id: this.citaId
            };
            axios.post(`/api/v1/citas/${this.citaId}/hitos`, data)
                .then(() => {
                    this.getHitos();
                    this.nuevoHito.titulo = '';
                    this.nuevoHito.estado_hito_id = '';
                    this.$toast.success('Hito añadido con éxito.');
                })
                .catch(this.handleApiError); // <-- USAMOS EL MANEJADOR
        },
        eliminarHito(hitoId) {
            axios.delete(`/api/v1/hitos/${hitoId}`)
                .then(() => {
                    this.getHitos();
                    this.$toast.success('Hito eliminado.');
                })
                .catch(this.handleApiError); // <-- USAMOS EL MANEJADOR
        },
        // Función para dar color a los estados
        estadoColor(estadoId) {
            switch(estadoId) {
                case 1: return 'bg-yellow-500 text-yellow-900'; // Pendiente
                case 2: return 'bg-blue-500 text-blue-900';   // En Progreso
                case 3: return 'bg-green-500 text-green-900'; // Completado
                default: return 'bg-gray-500 text-gray-900';
            }
        }
    }
}
</script>