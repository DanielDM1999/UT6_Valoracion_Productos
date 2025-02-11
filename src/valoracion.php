<?php
// Incluir archivos necesarios
require_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->idProducto)) {
    $idProducto = $data->idProducto;

    // Consulta para obtener el promedio y total de votos
    $sql = "SELECT AVG(cantidad) as promedio, COUNT(*) as total FROM votos WHERE idPr = :idProducto";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":idProducto", $idProducto);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $promedio = round($row['promedio'] * 2) / 2;
    $total = $row['total'];

    // Generar las estrellas HTML
    $estrellas = "";
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $promedio) {
            $estrellas .= "<i class='fas fa-star text-yellow-400'></i>";
        } elseif ($i - 0.5 == $promedio) {
            $estrellas .= "<i class='fas fa-star-half-alt text-yellow-400'></i>";
        } else {
            $estrellas .= "<i class='far fa-star text-yellow-400'></i>";
        }
    }

    echo "<div class='flex items-center'>$estrellas <span class='ml-2 text-sm text-gray-600'>($total " . ($total == 1 ? "valoración" : "valoraciones") . ")</span></div>";
} else {
    echo "Error: Falta el ID del producto";
}
?>

