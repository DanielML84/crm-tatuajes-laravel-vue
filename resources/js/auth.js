import axios from 'axios';
import router from './router';

export default {
    // Inicia la sesión llamando a la API
    async login(credentials) {
        // Petición POST a la ruta de login que creamos en Laravel
        const response = await axios.post('/api/v1/login', credentials);
        
        const token = response.data.access_token;
        const user = response.data.user;

        // Guardamos el token en el localStorage del navegador
        localStorage.setItem('authToken', token);
        // Configuramos Axios para que envíe este token en todas las futuras peticiones
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        
        return user;
    },

    // Cierra la sesión
    logout() {
        // Borramos el token del localStorage
        localStorage.removeItem('authToken');
        // Redirigimos al usuario a la página de inicio
        router.push({ name: 'home' });
    }
}