<template>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <form @submit.prevent="guardarCliente" class="mb-8">
            <h3 class="text-2xl font-bold text-gray-100 mb-6 border-b border-gray-700 pb-2">
                {{ editMode ? 'Editando Cliente' : 'Añadir Nuevo Cliente' }}
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
                    {{ editMode ? 'Guardar Cambios' : 'Guardar Cliente' }}
                </button>
                <button v-if="editMode" @click.prevent="cancelarEdicion" class="btn btn-secondary">
                    Cancelar
                </button>
            </div>
        </form>

        <div>
            <h3 class="text-2xl font-bold text-gray-100 mb-4">Lista de Clientes</h3>
            <ul class="divide-y divide-gray-700">
                <li v-for="cliente in clientes" :key="cliente.id" class="flex justify-between items-center py-3">
                    <span class="text-gray-300">{{ cliente.nombre }} {{ cliente.apellidos }} ({{ cliente.email }})</span>
                    <div class="space-x-2">
                        <button @click="editarCliente(cliente)" class="btn-icon btn-edit">Editar</button>
                        <button @click="eliminarCliente(cliente.id)" class="btn-icon btn-delete">Eliminar</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'; // Ya lo teníamos importado

export default {
    name: 'Clientes',
    data() {
        return {
            clientes: [],
            formData: { id: null, nombre: '', apellidos: '', email: '', telefono: '' },
            editMode: false,
            errors: {}
        };
    },
    mounted() {
        this.getClientes();
    },
    methods: {
        getClientes() {
            axios.get('/api/v1/clientes').then(response => { this.clientes = response.data; });
        },
        guardarCliente() {
            this.errors = {};
            const url = this.editMode ? `/api/v1/clientes/${this.formData.id}` : '/api/v1/clientes';
            const method = this.editMode ? 'put' : 'post';
            
            axios[method](url, this.formData)
                .then(() => {
                    this.getClientes();
                    this.cancelarEdicion();
                    // REEMPLAZAMOS this.$toast POR Swal.fire()
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'La operación se completó correctamente.',
                        icon: 'success',
                        background: '#374151',
                        color: '#e5e7eb',
                        confirmButtonColor: '#3085d6'
                    });
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                        // REEMPLAZAMOS this.$toast POR Swal.fire()
                        Swal.fire({
                            title: 'Error de Validación',
                            text: 'Por favor, corrige los errores del formulario.',
                            icon: 'error',
                            background: '#374151',
                            color: '#e5e7eb',
                            confirmButtonColor: '#d33'
                        });
                    } else {
                        console.error("Hubo un error:", error);
                        // REEMPLAZAMOS this.$toast POR Swal.fire()
                        Swal.fire({
                            title: 'Error Inesperado',
                            text: 'Ocurrió un error al procesar la solicitud.',
                            icon: 'error',
                            background: '#374151',
                            color: '#e5e7eb',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
        },
        editarCliente(cliente) {
            this.editMode = true;
            this.formData = { ...cliente };
            this.errors = {};
        },
        cancelarEdicion() {
            this.editMode = false;
            this.formData = { id: null, nombre: '', apellidos: '', email: '', telefono: '' };
            this.errors = {};
        },
        eliminarCliente(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
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
                    axios.delete(`/api/v1/clientes/${id}`)
                        .then(() => {
                            this.getClientes();
                            // Aquí usamos el toast de éxito que ya teníamos de vue-toastification,
                            // o también podríamos cambiarlo por un Swal.fire() si queremos.
                            // Por ahora lo dejamos para no perder la librería del todo.
                            this.$toast.success('Cliente eliminado con éxito.');
                        });
                }
            })
        }
    }
}
</script>