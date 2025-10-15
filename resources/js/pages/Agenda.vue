<template>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-gray-100 mb-6">Agenda de Citas</h2>
        
        <FullCalendar :options="calendarOptions" />
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es'; // Importamos el idioma español
import axios from 'axios';

export default {
    name: 'Agenda',
    components: {
        FullCalendar // Registramos el componente del calendario
    },
    data() {
        return {
            calendarOptions: {
                plugins: [ dayGridPlugin ],
                initialView: 'dayGridMonth', // Vista de mes por defecto
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                locale: esLocale, // Establecemos el idioma a español
                events: [], // Aquí guardaremos las citas que vengan de la API
                eventColor: '#22d3ee' // Color cian para los eventos
            }
        }
    },
    mounted() {
        // Al cargar el componente, pedimos los eventos a nuestra nueva API
        this.getEventos();
    },
    methods: {
        getEventos() {
            axios.get('/api/v1/agenda')
                .then(response => {
                    // Asignamos los eventos recibidos a las opciones del calendario
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
/* Pequeños ajustes para que FullCalendar se vea bien con el tema oscuro */
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