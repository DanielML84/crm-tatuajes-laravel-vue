<template>
    <div class="container">
        <div class="form-container">
            <h3>Agendar Nueva Cita</h3>
            <form @submit.prevent="guardarCita">
                <div class="form-group">
                    <label>Cliente:</label>
                    <select v-model="formData.cliente_id" required>
                        <option disabled value="">Selecciona un cliente</option>
                        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                            {{ cliente.nombre }} {{ cliente.apellidos }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Artista:</label>
                    <select v-model="formData.artista_id" required>
                        <option disabled value="">Selecciona un artista</option>
                        <option v-for="artista in artistas" :key="artista.id" :value="artista.id">
                            {{ artista.nombre }} {{ artista.apellidos }}
                        </option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Fecha y Hora:</label>
                    <input v-model="formData.fecha_hora" type="datetime-local" required>
                </div>

                <div class="form-group">
                    <label>Descripción:</label>
                    <textarea v-model="formData.descripcion" placeholder="Descripción del tatuaje..."></textarea>
                </div>

                <button type="submit">Agendar Cita</button>
            </form>
        </div>

        <div class="list-container">
            <h3>Lista de Citas</h3>
            <ul>
                <li v-for="cita in citas" :key="cita.id">
                    <span>
                        <strong>Cliente:</strong> {{ cita.cliente ? cita.cliente.nombre : 'N/A' }} | 
                        <strong>Artista:</strong> {{ cita.artista ? cita.artista.nombre : 'N/A' }} | 
                        <strong>Fecha:</strong> {{ new Date(cita.fecha_hora).toLocaleString() }} | 
                        <strong>Estado:</strong> {{ cita.estado }}
                    </span>
                    <div class="buttons-container">
                        <button @click="eliminarCita(cita.id)" class="delete-button">Eliminar</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Citas',
    data() {
        return {
            citas: [],
            clientes: [], // Array para guardar la lista de clientes
            artistas: [], // Array para guardar la lista de artistas
            formData: {
                cliente_id: '',
                artista_id: '',
                fecha_hora: '',
                descripcion: ''
            }
        };
    },
    mounted() {
        // Cuando el componente carga, pedimos los 3 tipos de datos
        this.getCitas();
        this.getClientes();
        this.getArtistas();
    },
    methods: {
        getCitas() {
            axios.get('/api/v1/citas').then(response => { this.citas = response.data; });
        },
        // Métodos para llenar los desplegables
        getClientes() {
            axios.get('/api/v1/clientes').then(response => { this.clientes = response.data; });
        },
        getArtistas() {
            axios.get('/api/v1/artistas').then(response => { this.artistas = response.data; });
        },
        guardarCita() {
            axios.post('/api/v1/citas', this.formData).then(() => {
                this.getCitas(); // Actualizamos la lista de citas
                // Limpiamos el formulario
                this.formData = { cliente_id: '', artista_id: '', fecha_hora: '', descripcion: '' };
                alert('¡Cita agendada con éxito!');
            }).catch(error => {
                console.error("Error al agendar la cita:", error);
                alert('Error al agendar la cita.');
            });
        },
        eliminarCita(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
                axios.delete(`/api/v1/citas/${id}`).then(() => { this.getCitas(); });
            }
        }
    }
}
</script>

<style scoped>
/* Estilos similares a los otros componentes */
.container { font-family: sans-serif; padding: 20px; max-width: 800px; margin: auto; }
.form-container, .list-container { border: 1px solid #ccc; padding: 15px; margin-top: 20px; border-radius: 8px; }
.form-group { margin-bottom: 15px; }
label { display: block; margin-bottom: 5px; font-weight: bold; }
input[type="datetime-local"], select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
textarea { height: 80px; }
button { padding: 10px 15px; background-color: darkcyan; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 5px; }
button:hover { background-color: #00796b; }
li { display: flex; justify-content: space-between; align-items: center; padding: 8px; border-bottom: 1px solid #eee; }
.delete-button { background-color: #d9534f; font-size: 0.8em; padding: 5px 10px;}
.delete-button:hover { background-color: #c9302c; }
</style>