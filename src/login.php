<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Incluir archivos necesarios
require_once 'config/Database.php';
require_once 'controllers/UserController.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Crear instancia del controlador de usuario
$user_controller = new UserController($db);

// Función para validar el formulario
function validateForm($username, $password) {
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "El nombre de usuario es requerido.";
    }
    
    if (empty($password)) {
        $errors[] = "La contraseña es requerida.";
    }
    
    return $errors;
}

// Obtener datos de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Validar el formulario
$errors = validateForm($data->usuario ?? '', $data->password ?? '');

if (empty($errors)) {
    // Si no hay errores, intentar iniciar sesión o crear usuario
    $result = $user_controller->login($data->usuario, $data->password);
    
    if($result['success']) {
        // Si el inicio de sesión es exitoso, iniciar sesión
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['is_admin'] = $result['is_admin'];
        echo json_encode(array("success" => true));
    } else {
        // Si el inicio de sesión falla, devolver el mensaje de error
        echo json_encode($result);
    }
} else {
    // Si hay errores de validación, devolverlos
    echo json_encode(array("success" => false, "message" => implode(" ", $errors)));
}
?>

