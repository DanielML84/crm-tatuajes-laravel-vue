<template>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-100 mb-4 sm:mb-0">Agenda de Citas</h2>
            
            <div class="flex items-center space-x-2">
                <label for="artist-filter" class="form-label mb-0">Filtrar por Artista:</label>
                <select 
                    id="artist-filter"
                    v-model="selectedArtistId"
                    @change="getEventos"
                    class="form-input w-48"
                >
                    <option value="">Todos los artistas</option>
                    <option v-for="artista in artistas" :key="artista.id" :value="artista.id">
                        {{ artista.nombre }} {{ artista.apellidos }}
                    </option>
                </select>
            </div>
        </div>
        
        <FullCalendar :options="calendarOptions" />
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es';
import axios from 'axios';

export default {
    name: 'Agenda',
    components: {
        FullCalendar
    },
    data() {
        return {
            // NUEVO: Lista para el desplegable y el ID del artista seleccionado
            artistas: [],
            selectedArtistId: '',

            calendarOptions: {
                plugins: [ dayGridPlugin ],
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                locale: esLocale,
                events: [],
                eventColor: '#22d3ee',
                height: 'auto'
            }
        }
    },
    mounted() {
        // Al cargar, pedimos los artistas para el filtro y los eventos iniciales
        this.getArtistas();
        this.getEventos();
    },
    methods: {
        // NUEVO: Método para obtener la lista de artistas
        getArtistas() {
            axios.get('/api/v1/artistas/list')
                .then(response => {
                    this.artistas = response.data;
                })
                .catch(error => {
                    console.error("Error al cargar la lista de artistas:", error);
                });
        },
        // MÉTODO MODIFICADO: Ahora es dinámico
        getEventos() {
            let url = '/api/v1/agenda';

            // Si hay un artista seleccionado, añadimos el filtro a la URL
            if (this.selectedArtistId) {
                url += `?artista_id=${this.selectedArtistId}`;
            }

            axios.get(url)
                .then(response => {
                    this.calendarOptions.events = response.data;
                })
                .catch(error => {
                    console.error("Error al obtener los eventos de la agenda:", error);
                });
        }
    }
}
</script>

<style>
/* Los estilos de FullCalendar no cambian */
.fc .fc-button-primary {
    @apply bg-cyan-600 border-cyan-600 hover:bg-cyan-700;
}
.fc .fc-toolbar-title {
    @apply text-gray-100;
}
.fc .fc-daygrid-day-number, .fc .fc-col-header-cell-cushion {
    @apply text-gray-300;
}
</style>