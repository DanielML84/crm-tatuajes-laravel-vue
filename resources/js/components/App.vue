<template>
    <div id="main-container">
        <header>
            <h1>Gestión del Estudio de Tatuajes</h1>
        </header>
        <main>
            <Citas />
            <hr>
            <Clientes />
            <hr>
            <Artistas />
        </main>
    </div>
</template>

<script>
// Importamos los tres componentes
import Clientes from './Clientes.vue';
import Artistas from './Artistas.vue';
import Citas from './Citas.vue';

export default {
    name: 'App',
    // Los registramos para poder usarlos en el template
    components: {
        Clientes,
        Artistas,
        Citas
    }
}
</script>

<style>
/* Estilos globales para la aplicación */
body {
    background-color: #f4f4f4;
}
#main-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}
header h1 {
    color: #333;
    font-family: sans-serif;
}
hr {
    width: 80%;
    margin: 40px 0;
    border: 1px solid #ddd;
}
</style>