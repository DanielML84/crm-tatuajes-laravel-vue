<template>
    <div class="flex items-center justify-center">
        <div class="w-full max-w-md">
            <form @submit.prevent="handleLogin" class="bg-gray-800 shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl font-bold text-center text-gray-100 mb-6">Iniciar Sesión</h2>
                
                <div v-if="errorMessage" class="bg-red-500 text-white text-sm p-3 rounded-md mb-4">
                    {{ errorMessage }}
                </div>

                <div class="mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input v-model="form.email" id="email" type="email" placeholder="admin@inkflow.com" class="form-input">
                </div>
                <div class="mb-6">
                    <label class="form-label" for="password">Contraseña</label>
                    <input v-model="form.password" id="password" type="password" placeholder="******************" class="form-input">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="btn btn-primary w-full">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import auth from '../auth'; // <-- 1. Importamos nuestro cerebro de autenticación

export default {
    name: 'Login',
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errorMessage: ''
        }
    },
    methods: {
        async handleLogin() {
            this.errorMessage = ''; // Limpiamos errores previos
            try {
                // 2. Llamamos al método login de nuestro archivo auth.js
                const user = await auth.login(this.form);

                // Si el login tiene éxito, redirigimos al dashboard
                this.$router.push({ name: 'dashboard' });

            } catch (error) {
                // Si el login falla (ej. contraseña incorrecta), Laravel devuelve un error.
                // Lo capturamos y mostramos un mensaje.
                this.errorMessage = 'El email o la contraseña son incorrectos.';
                console.error("Error de login:", error);
            }
        }
    }
}
</script>