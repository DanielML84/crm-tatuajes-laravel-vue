<template>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <form @submit.prevent="guardarCita" class="mb-8">
             <h3 class="text-2xl font-bold text-gray-100 mb-6 border-b border-gray-700 pb-2">Agendar Nueva Cita</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Cliente:</label>
                    <select v-model="formData.cliente_id" required class="form-input">
                        <option disabled value="">Selecciona un cliente</option>
                        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                            {{ cliente.nombre }} {{ cliente.apellidos }}
                        </option>
                    </select>
                    <p v-if="errors.cliente_id" class="text-red-500 text-sm mt-1">{{ errors.cliente_id[0] }}</p>
                </div>
                <div>
                    <label class="form-label">Artista:</label>
                    <select v-model="formData.artista_id" required class="form-input">
                        <option disabled value="">Selecciona un artista</option>
                        <option v-for="artista in artistas" :key="artista.id" :value="artista.id">
                            {{ artista.nombre }} {{ artista.apellidos }}
                        </option>
                    </select>
                    <p v-if="errors.artista_id" class="text-red-500 text-sm mt-1">{{ errors.artista_id[0] }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Fecha y Hora:</label>
                    <input v-model="formData.fecha_hora" type="datetime-local" required class="form-input">
                    <p v-if="errors.fecha_hora" class="text-red-500 text-sm mt-1">{{ errors.fecha_hora[0] }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Descripción:</label>
                    <textarea v-model="formData.descripcion" placeholder="Descripción del tatuaje..." class="form-input h-24"></textarea>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">Agendar Cita</button>
            </div>
        </form>

        <div>
            <h3 class="text-2xl font-bold text-gray-100 mb-4">Próximas Citas</h3>
            <ul class="divide-y divide-gray-700">
                <li v-for="cita in citas" :key="cita.id" class="flex justify-between items-center py-3">
                    <div class="text-gray-300">
                        <p><strong>Cliente:</strong> {{ cita.cliente ? cita.cliente.nombre : 'N/A' }} | <strong>Artista:</strong> {{ cita.artista ? cita.artista.nombre : 'N/A' }}</p>
                        <p class="text-sm text-gray-400"><strong>Fecha:</strong> {{ new Date(cita.fecha_hora).toLocaleString() }} | <strong>Estado:</strong> {{ cita.estado }}</p>
                    </div>
                    <button @click="eliminarCita(cita.id)" class="btn-icon btn-delete">Eliminar</button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    name: 'Citas',
    data() {
        return {
            citas: [],
            clientes: [],
            artistas: [],
            formData: { cliente_id: '', artista_id: '', fecha_hora: '', descripcion: '' },
            errors: {}
        };
    },
    mounted() {
        this.getCitas();
        this.getClientes();
        this.getArtistas();
    },
    methods: {
        handleApiError(error) {
            if (error.response && error.response.status === 401) {
                this.$router.push({ name: 'login' });
            } else {
                console.error("Error de API:", error);
            }
        },
        getCitas() {
            axios.get('/api/v1/citas')
                .then(response => { this.citas = response.data; })
                .catch(this.handleApiError); // <-- Usamos el manejador de errores
        },
        getClientes() {
            axios.get('/api/v1/clientes/list')
                .then(response => { this.clientes = response.data; })
                .catch(this.handleApiError); // <-- Usamos el manejador de errores
        },
        getArtistas() {
            axios.get('/api/v1/artistas/list')
                .then(response => { this.artistas = response.data; })
                .catch(this.handleApiError); // <-- Usamos el manejador de errores
        },
        guardarCita() {
            this.errors = {};
            axios.post('/api/v1/citas', this.formData)
                .then(() => {
                    this.getCitas();
                    this.formData = { cliente_id: '', artista_id: '', fecha_hora: '', descripcion: '' };
                    this.$toast.success('¡Cita agendada con éxito!');
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.handleApiError(error);
                    }
                });
        },
        eliminarCita(id) {
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
                    axios.delete(`/api/v1/citas/${id}`)
                        .then(() => { 
                            this.getCitas(); 
                            this.$toast.success('Cita eliminada con éxito.');
                        })
                        .catch(this.handleApiError); // <-- Usamos el manejador de errores
                }
            });
        }
    }
}
</script>