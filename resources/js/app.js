import './bootstrap';
import Vue from 'vue';
import App from './components/App.vue'; // <-- Asegúrate de que apunta al nuevo App.vue

const app = new Vue({
    el: '#app',
    render: h => h(App)
});