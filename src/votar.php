<?php
// Incluir archivos necesarios
require_once 'config/Database.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "El usuario no ha iniciado sesión"));
    exit();
}

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->idProducto) && isset($data->valoracion)) {
    $idProducto = $data->idProducto;
    $valoracion = $data->valoracion;
    $usuario = $_SESSION['username'];

    // Verificar si el usuario ya ha votado por este producto
    $check_sql = "SELECT * FROM votos WHERE idPr = :idProducto AND idUs = :usuario";
    $check_stmt = $db->prepare($check_sql);
    $check_stmt->bindParam(":idProducto", $idProducto);
    $check_stmt->bindParam(":usuario", $usuario);
    $check_stmt->execute();

    if ($check_stmt->rowCount() == 0) {
        // Si el usuario no ha votado, insertar el nuevo voto
        $insert_sql = "INSERT INTO votos (cantidad, idPr, idUs) VALUES (:valoracion, :idProducto, :usuario)";
        $insert_stmt = $db->prepare($insert_sql);
        $insert_stmt->bindParam(":valoracion", $valoracion);
        $insert_stmt->bindParam(":idProducto", $idProducto);
        $insert_stmt->bindParam(":usuario", $usuario);
        
        if($insert_stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Voto registrado correctamente"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error al registrar el voto"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Ya has valorado este producto"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Faltan campos requeridos"));
}
?>

