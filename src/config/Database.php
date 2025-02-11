<?php
class Database {
    private $host = "localhost";
    private $db_name = "tienda_valoraciones";
    private $username = "root";
    private $password = "";
    public $conn;

    //Método para obtener la conexión a la base de datos utilizando PDO
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

