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
            <div class="mb-4">
                <input 
                    type="text" 
                    v-model="searchTerm" 
                    @keyup.enter="getArtistas(1)" 
                    placeholder="Buscar por nombre o email..." 
                    class="form-input"
                >
            </div>
            <div v-if="isLoading" class="text-center text-gray-400">Cargando...</div>
            <div v-else>
                <ul v-if="pagination.data && pagination.data.length > 0" class="divide-y divide-gray-700">
                    <li v-for="artista in pagination.data" :key="artista.id" class="flex justify-between items-center py-3">
                        <span class="text-gray-300">{{ artista.nombre }} {{ artista.apellidos }} ({{ artista.email }})</span>
                        <div class="space-x-2">
                            <button @click="editarArtista(artista)" class="btn-icon btn-edit">Editar</button>
                            <button @click="eliminarArtista(artista.id)" class="btn-icon btn-delete">Eliminar</button>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-gray-400">No se encontraron artistas.</p>
                <div v-if="pagination.total > pagination.per_page" class="flex justify-between items-center mt-4">
                    <button @click="getArtistas(pagination.current_page - 1)" :disabled="!pagination.prev_page_url" class="btn btn-secondary disabled:opacity-50">Anterior</button>
                    <span class="text-gray-400">Página {{ pagination.current_page }} de {{ pagination.last_page }}</span>
                    <button @click="getArtistas(pagination.current_page + 1)" :disabled="!pagination.next_page_url" class="btn btn-secondary disabled:opacity-50">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    name: 'Artistas',
    data() {
        return {
            isLoading: false,
            pagination: {}, 
            formData: { id: null, nombre: '', apellidos: '', email: '', telefono: '' },
            editMode: false,
            errors: {},
            searchTerm: ''
        };
    },
    mounted() {
        this.getArtistas();
    },
    methods: {
        getArtistas(page = 1) {
            this.isLoading = true;
            let url = `/api/v1/artistas?page=${page}&search=${this.searchTerm}`;
            axios.get(url)
                .then(response => {
                    this.pagination = response.data;
                })
                .catch(error => {
                    if (error.response && error.response.status === 401) {
                        this.$router.push({ name: 'login' });
                    } else {
                        console.error("Error al obtener artistas:", error);
                    }
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        guardarArtista() {
            this.errors = {};
            const url = this.editMode ? `/api/v1/artistas/${this.formData.id}` : '/api/v1/artistas';
            const method = this.editMode ? 'put' : 'post';
            axios[method](url, this.formData)
                .then(() => {
                    this.getArtistas(); // Llama a getArtistas para refrescar
                    this.cancelarEdicion();
                    this.$toast.success('Operación exitosa.');
                })
                .catch(error => {
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
            this.errors = {};
        },
        cancelarEdicion() {
            this.editMode = false;
            this.formData = { id: null, nombre: '', apellidos: '', email: '', telefono: '' };
            this.errors = {};
        },
        eliminarArtista(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡eliminar!',
                cancelButtonText: 'Cancelar',
                background: '#374151',
                color: '#e5e7eb'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/v1/artistas/${id}`).then(() => {
                        this.getArtistas(); // Llama a getArtistas para refrescar
                        this.$toast.success('Artista eliminado con éxito.');
                    });
                }
            });
        }
    }
}
</script>