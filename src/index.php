<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Electrónica OnLine</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
async function validarUsuario(formData) {
    try {
        // Enviar una petición HTTP POST al servidor (login.php)
        const response = await fetch('login.php', {
            method: 'POST', // Usamos el método POST para enviar los datos
            headers: {
                'Content-Type': 'application/json', // Indicamos que los datos se enviarán en formato JSON
            },
            body: JSON.stringify(formData), // Convertimos los datos del formulario a formato JSON
        });

        // Procesar la respuesta del servidor y convertirla a un objeto JSON
        const data = await response.json();

        // Si el servidor responde con éxito
        if (data.success) {
            // Redirigir al usuario a la página de listado
            window.location.href = 'listado.php'; 
        } else {
            //Si no, mostrar un mensaje de error en la interfaz de usuario
            document.getElementById('mensajeError').innerHTML = data.message || 'Ha ocurrido un error';
            document.getElementById('mensajeError').classList.remove('hidden'); // Mostrar el mensaje
        }
    } catch (error) {
        // Capturar errores en la solicitud 
        console.error('Error:', error); // Mostrar el error en la consola

        // Mostrar un mensaje genérico de error en la interfaz de usuario
        document.getElementById('mensajeError').innerHTML = 'Ocurrió un error al procesar su solicitud. Por favor, vuelva a intentarlo.';
        document.getElementById('mensajeError').classList.remove('hidden'); // Mostrar el mensaje
    }
}
    </script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Registro</h1>
        <form id="loginForm" onsubmit="event.preventDefault(); validarUsuario(Object.fromEntries(new FormData(this)));" class="space-y-4">
            <div>
                <label for="usuario" class="block text-sm font-medium text-gray-700">Usuario</label>
                <input type="text" id="usuario" name="usuario" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Registrar
            </button>
        </form>
        <div id="mensajeError" class="mt-4 text-center text-sm text-red-600 hidden"></div>
    </div>
</body>
</html>
