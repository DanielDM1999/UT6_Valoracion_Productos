<?php
class User {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $usuario;
    public $password;
    public $is_admin;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Método para iniciar sesión
    public function login() {
        $query = "SELECT id, usuario, password, is_admin 
                  FROM " . $this->table_name . " 
                  WHERE usuario = :usuario";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->execute();

        return $stmt;
    }

    //Método para registrar un usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (usuario, password, is_admin) 
                  VALUES (:usuario, :password, :is_admin)";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":is_admin", $this->is_admin);
    
        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return $this->id;
        }
        return false;
    }    
}
?>