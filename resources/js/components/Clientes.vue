<template>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <form @submit.prevent="guardarCliente" class="mb-8">
            <h3 class="text-2xl font-bold text-gray-100 mb-6 border-b border-gray-700 pb-2">
                {{ editMode ? 'Editando Cliente' : 'Añadir Nuevo Cliente' }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input v-model="formData.nombre" placeholder="Nombre" required class="form-input">
                <input v-model="formData.apellidos" placeholder="Apellidos" required class="form-input">
                <input v-model="formData.email" type="email" placeholder="Email" required class="form-input">
                <input v-model="formData.telefono" placeholder="Teléfono" required class="form-input">
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
// El script no cambia, ¡puedes dejar el que ya tenías!
import axios from 'axios';

export default {
    name: 'Clientes',
    data() {
        return {
            clientes: [],
            formData: { id: null, nombre: '', apellidos: '', email: '', telefono: '' },
            editMode: false
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
            const url = this.editMode ? `/api/v1/clientes/${this.formData.id}` : '/api/v1/clientes';
            const method = this.editMode ? 'put' : 'post';
            axios[method](url, this.formData).then(() => {
                this.getClientes();
                this.cancelarEdicion();
            });
        },
        editarCliente(cliente) {
            this.editMode = true;
            this.formData = { ...cliente };
        },
        cancelarEdicion() {
            this.editMode = false;
            this.formData = { id: null, nombre: '', apellidos: '', email: '', telefono: '' };
        },
        eliminarCliente(id) {
            if (confirm('¿Estás seguro?')) {
                axios.delete(`/api/v1/clientes/${id}`).then(() => { this.getClientes(); });
            }
        }
    }
}
</script>