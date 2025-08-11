<template>
    <div class="container">
        <h1>CRM Tatuajes</h1>

        <form @submit.prevent="guardarCliente" class="form-container">
            <h3>{{ editMode ? 'Editando Cliente' : 'Añadir Nuevo Cliente' }}</h3>
            <input v-model="formData.nombre" placeholder="Nombre" required>
            <input v-model="formData.apellidos" placeholder="Apellidos" required>
            <input v-model="formData.email" type="email" placeholder="Email" required>
            <input v-model="formData.telefono" placeholder="Teléfono" required>
            <button type="submit">{{ editMode ? 'Guardar Cambios' : 'Guardar Cliente' }}</button>
            <button v-if="editMode" @click.prevent="cancelarEdicion" class="cancel-button">Cancelar</button>
        </form>

        <div class="list-container">
            <h3>Lista de Clientes</h3>
            <ul>
                <li v-for="cliente in clientes" :key="cliente.id">
                    <span>{{ cliente.nombre }} {{ cliente.apellidos }} ({{ cliente.email }})</span>
                    <div class="buttons-container">
                        <button @click="editarCliente(cliente)" class="edit-button">Editar</button>
                        <button @click="eliminarCliente(cliente.id)" class="delete-button">Eliminar</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'App',
    data() {
        return {
            clientes: [],
            // Usaremos formData para el formulario, para no mezclar con el objeto de un nuevo cliente
            formData: {
                id: null,
                nombre: '',
                apellidos: '',
                email: '',
                telefono: ''
            },
            // Una bandera para saber si el formulario está en modo edición o no
            editMode: false
        };
    },
    mounted() {
        this.getClientes();
    },
    methods: {
        getClientes() {
            axios.get('/api/v1/clientes')
                .then(response => {
                    this.clientes = response.data;
                })
                .catch(error => {
                    console.error("Hubo un error al obtener los clientes:", error);
                });
        },
        guardarCliente() {
            // Si estamos en modo edición, actualizamos (PUT)
            if (this.editMode) {
                axios.put(`/api/v1/clientes/${this.formData.id}`, this.formData)
                    .then(response => {
                        this.getClientes(); // Actualizamos la lista
                        this.cancelarEdicion(); // Limpiamos el formulario y salimos del modo edición
                        alert('¡Cliente actualizado con éxito!');
                    })
                    .catch(error => {
                        console.error("Hubo un error al actualizar el cliente:", error);
                    });
            } else {
                // Si no, creamos uno nuevo (POST)
                axios.post('/api/v1/clientes', this.formData)
                    .then(response => {
                        this.getClientes(); // Actualizamos la lista
                        this.formData = { id: null, nombre: '', apellidos: '', email: '', telefono: '' }; // Limpiamos
                        alert('¡Cliente guardado con éxito!');
                    })
                    .catch(error => {
                        console.error("Hubo un error al guardar el cliente:", error);
                    });
            }
        },
        // Nuevo método para entrar en modo edición
        editarCliente(cliente) {
            this.editMode = true;
            // Copiamos los datos del cliente al formulario
            this.formData = { ...cliente };
        },
        // Nuevo método para cancelar la edición
        cancelarEdicion() {
            this.editMode = false;
            this.formData = { id: null, nombre: '', apellidos: '', email: '', telefono: '' };
        },
        // Nuevo método para eliminar un cliente
        eliminarCliente(id) {
            // Pedimos confirmación antes de borrar
            if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                axios.delete(`/api/v1/clientes/${id}`)
                    .then(response => {
                        this.getClientes(); // Actualizamos la lista
                        alert('Cliente eliminado con éxito.');
                    })
                    .catch(error => {
                        console.error("Hubo un error al eliminar el cliente:", error);
                    });
            }
        }
    }
}
</script>

<style scoped>
.container { font-family: sans-serif; padding: 20px; max-width: 800px; margin: auto; }
.form-container, .list-container { border: 1px solid #ccc; padding: 15px; margin-top: 20px; border-radius: 8px; }
input { display: block; margin-bottom: 10px; padding: 8px; width: 95%; }
button { padding: 10px 15px; background-color: darkcyan; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 5px; }
button:hover { background-color: #00796b; }
li { display: flex; justify-content: space-between; align-items: center; padding: 8px; border-bottom: 1px solid #eee; }
.cancel-button { background-color: #777; }
.cancel-button:hover { background-color: #555; }
.edit-button { background-color: #f0ad4e; font-size: 0.8em; padding: 5px 10px;}
.edit-button:hover { background-color: #ec971f; }
.delete-button { background-color: #d9534f; font-size: 0.8em; padding: 5px 10px;}
.delete-button:hover { background-color: #c9302c; }
</style>