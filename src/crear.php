<?php
require_once 'config/Database.php';
require_once 'controllers/ProductController.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: listado.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$product_controller = new ProductController($db);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validaciónes
    if (empty($_POST['nombre'])) {
        $errors['nombre'] = 'El nombre es obligatorio.';
    }
    if (empty($_POST['precio'])) {
        $errors['precio'] = 'El precio es obligatorio.';
    } elseif (!is_numeric($_POST['precio']) || $_POST['precio'] <= 0) {
        $errors['precio'] = 'El precio debe ser un número positivo.';
    }
    if (empty($_POST['descripcion'])) {
        $errors['descripcion'] = 'La descripción es obligatoria.';
    }

    // Si no hay errores, se redirecciona al listado de productos
    if (empty($errors)) {
        $result = $product_controller->create($_POST);
        if ($result['success']) {
            header("Location: listado.php");
            exit();
        } else {
            $errors['general'] = 'Hubo un error al crear el producto. Por favor, inténtelo de nuevo.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-2xl font-semibold text-gray-900">Crear Nuevo Producto</h1>
            <?php if (!empty($errors['general'])): ?>
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo $errors['general']; ?></span>
                </div>
            <?php endif; ?>
            <form action="crear.php" method="POST" class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" name="nombre" id="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md <?php echo isset($errors['nombre']) ? 'border-red-500' : ''; ?>">
                                <?php if (isset($errors['nombre'])): ?>
                                    <p class="mt-2 text-sm text-red-600"><?php echo $errors['nombre']; ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                                <input type="number" name="precio" id="precio" step="0.01" value="<?php echo isset($_POST['precio']) ? htmlspecialchars($_POST['precio']) : ''; ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md <?php echo isset($errors['precio']) ? 'border-red-500' : ''; ?>">
                                <?php if (isset($errors['precio'])): ?>
                                    <p class="mt-2 text-sm text-red-600"><?php echo $errors['precio']; ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-span-6">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md <?php echo isset($errors['descripcion']) ? 'border-red-500' : ''; ?>"><?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?></textarea>
                                <?php if (isset($errors['descripcion'])): ?>
                                    <p class="mt-2 text-sm text-red-600"><?php echo $errors['descripcion']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="listado.php" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-2">
                            Volver
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Crear Producto
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

