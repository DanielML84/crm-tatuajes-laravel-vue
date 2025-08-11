<template>
    <div class="container">
        <form @submit.prevent="guardarArtista" class="form-container">
            <h3>{{ editMode ? 'Editando Artista' : 'Añadir Nuevo Artista' }}</h3>
            <input v-model="formData.nombre" placeholder="Nombre" required>
            <input v-model="formData.apellidos" placeholder="Apellidos" required>
            <input v-model="formData.email" type="email" placeholder="Email" required>
            <input v-model="formData.telefono" placeholder="Teléfono" required>
            <button type="submit">{{ editMode ? 'Guardar Cambios' : 'Guardar Artista' }}</button>
            <button v-if="editMode" @click.prevent="cancelarEdicion" class="cancel-button">Cancelar</button>
        </form>

        <div class="list-container">
            <h3>Lista de Artistas</h3>
            <ul>
                <li v-for="artista in artistas" :key="artista.id">
                    <span>{{ artista.nombre }} {{ artista.apellidos }} ({{ artista.email }})</span>
                    <div class="buttons-container">
                        <button @click="editarArtista(artista)" class="edit-button">Editar</button>
                        <button @click="eliminarArtista(artista.id)" class="delete-button">Eliminar</button>
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
            editMode: false
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
            const url = this.editMode ? `/api/v1/artistas/${this.formData.id}` : '/api/v1/artistas';
            const method = this.editMode ? 'put' : 'post';
            axios[method](url, this.formData).then(() => {
                this.getArtistas();
                this.cancelarEdicion();
            });
        },
        editarArtista(artista) {
            this.editMode = true;
            this.formData = { ...artista };
        },
        cancelarEdicion() {
            this.editMode = false;
            this.formData = { id: null, nombre: '', apellidos: '', email: '', telefono: '' };
        },
        eliminarArtista(id) {
            if (confirm('¿Estás seguro?')) {
                axios.delete(`/api/v1/artistas/${id}`).then(() => { this.getArtistas(); });
            }
        }
    }
}
</script>

<style scoped>
/* Puedes copiar los mismos estilos del componente de Clientes si quieres */
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