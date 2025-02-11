<?php
// Incluir archivos necesarios
require_once 'config/Database.php';
require_once 'controllers/UserController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$sql = "SELECT * FROM productos";
$stmt = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List - Rating System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
    //Función asíncrona para enviar el voto del usuario
    async function miVoto(idProducto) {
        const valoracion = document.getElementById(`rating_${idProducto}`).value;
        if (!valoracion) {
            alert('Por favor, selecciona una puntuación antes de votar.');
            return;
        }
        try {
            const response = await fetch('votar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ idProducto, valoracion }),
            });
            const data = await response.json();
            if (data.success) {
                actualizarValoracion(idProducto);
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    //Función asíncrona para actualizar la valoración del producto
    async function actualizarValoracion(idProducto) {
        try {
            const response = await fetch('valoracion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ idProducto }),
            });
            const data = await response.text();
            document.getElementById(`valoracion_${idProducto}`).innerHTML = data;
        } catch (error) {
            console.error('Error:', error);
        }
    }
    // Actualizar valoraciones al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const productos = document.querySelectorAll('[id^="valoracion_"]');
        productos.forEach(producto => {
            const idProducto = producto.id.split('_')[1];
            actualizarValoracion(idProducto);
        });
    });
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-800">Electrónica OnLine</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-4">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="text-indigo-600 hover:text-indigo-900">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <?php if ($_SESSION['is_admin'] == 1): ?>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="crear.php" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Crear Nuevo Producto
                        </a>
                    </div>
                <?php endif; ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valoración</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar Puntuación</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Votar</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" id="valoracion_<?php echo $row['id']; ?>"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <select id="rating_<?php echo $row['id']; ?>" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Selecciona una puntuación</option>
                                    <option value="1">1 Estrella</option>
                                    <option value="2">2 Estrellas</option>
                                    <option value="3">3 Estrellas</option>
                                    <option value="4">4 Estrellas</option>
                                    <option value="5">5 Estrellas</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button onclick="miVoto(<?php echo $row['id']; ?>);" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Votar
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="detalle.php?id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                                <?php if ($_SESSION['is_admin'] == 1): ?>
                                    <a href="editar.php?id=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">Eliminar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>

