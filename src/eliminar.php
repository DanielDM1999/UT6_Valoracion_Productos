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

//Se obtiene el id del producto
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID no encontrado.');

//Se elimina el producto de la base de datos
$result = $product_controller->delete($id);

if ($result['success']) {
    header("Location: listado.php");
    exit();
} else {
    echo "Error al eliminar el producto: " . $result['message'];
}

