<template>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <form @submit.prevent="guardarArtista" class="mb-8">
            <h3 class="text-2xl font-bold text-gray-100 mb-6 border-b border-gray-700 pb-2">
                {{ editMode ? 'Editando Artista' : 'Añadir Nuevo Artista' }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input v-model="formData.nombre" placeholder="Nombre" required class="form-input">
                    <p v-if="errors.nombre" class="text-red-500 text-sm mt-1">{{ errors.nombre[0] }}</p>
                </div>
                <div>
                    <input v-model="formData.apellidos" placeholder="Apellidos" required class="form-input">
                    <p v-if="errors.apellidos" class="text-red-500 text-sm mt-1">{{ errors.apellidos[0] }}</p>
                </div>
                <div>
                    <input v-model="formData.email" type="email" placeholder="Email" required class="form-input">
                    <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email[0] }}</p>
                </div>
                <div>
                    <input v-model="formData.telefono" placeholder="Teléfono" required class="form-input">
                    <p v-if="errors.telefono" class="text-red-500 text-sm mt-1">{{ errors.telefono[0] }}</p>
                </div>
            </div>
            <div class="flex items-center mt-6 space-x-4">
                <button type="submit" class="btn btn-primary">
                    {{ editMode ? 'Guardar Cambios' : 'Guardar Artista' }}
                </button>
                <button v-if="editMode" @click.prevent="cancelarEdicion" class="btn btn-secondary">
                    Cancelar
                </button>
            </div>
        </form>

        <div>
            <h3 class="text-2xl font-bold text-gray-100 mb-4">Lista de Artistas</h3>
            <ul class="divide-y divide-gray-700">
                <li v-for="artista in artistas" :key="artista.id" class="flex justify-between items-center py-3">
                    <span class="text-gray-300">{{ artista.nombre }} {{ artista.apellidos }} ({{ artista.email }})</span>
                    <div class="space-x-2">
                        <button @click="editarArtista(artista)" class="btn-icon btn-edit">Editar</button>
                        <button @click="eliminarArtista(artista.id)" class="btn-icon btn-delete">Eliminar</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Artistas',
    data() {
        return {
            artistas: [],
            formData: { id: null, nombre: '', apellidos: '', email: '', telefono: '' },
            editMode: false,
            // Objeto para los errores
            errors: {}
        };
    },
    mounted() {
        this.getArtistas();
    },
    methods: {
        getArtistas() {
            axios.get('/api/v1/artistas').then(response => { this.artistas = response.data; });
        },
        guardarArtista() {
            this.errors = {}; // Limpiamos errores
            const url = this.editMode ? `/api/v1/artistas/${this.formData.id}` : '/api/v1/artistas';
            const method = this.editMode ? 'put' : 'post';
            
            axios[method](url, this.formData)
                .then(() => {
                    this.getArtistas();
                    this.cancelarEdicion();
                })
                .catch(error => { // Capturamos el error
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error("Hubo un error:", error);
                    }
                });
        },
        editarArtista(artista) {
            this.editMode = true;
            this.formData = { ...artista };
            this.errors = {}; // Limpiamos errores
        },
        cancelarEdicion() {
            this.editMode = false;
            this.formData = { id: null, nombre: '', apellidos: '', email: '', telefono: '' };
            this.errors = {}; // Limpiamos errores
        },
        eliminarArtista(id) {
            if (confirm('¿Estás seguro?')) {
                axios.delete(`/api/v1/artistas/${id}`).then(() => { this.getArtistas(); });
            }
        }
    }
}
</script>