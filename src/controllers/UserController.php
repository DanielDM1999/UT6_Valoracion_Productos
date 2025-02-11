<?php
// Incluir archivos necesarios
require_once 'models/User.php';

class UserController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    // Método para manejar el inicio de sesión y registro de usuarios
    public function login($username, $password) {
        $this->user->usuario = $username;
        $stmt = $this->user->login();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row['id'];
            $usuario = $row['usuario'];
            $stored_password = $row['password'];
            $is_admin = $row['is_admin'];

            if($password === $stored_password) {
                $this->startSession($id, $usuario, $is_admin);
                return array(
                    "success" => true, 
                    "message" => ($is_admin ? "Admin" : "User") . " Inicio de sesión Satisfactorio", 
                    "user_id" => $id,
                    "username" => $usuario,
                    "is_admin" => $is_admin
                );
            } else {
                return array("success" => false, "message" => "Credenciales inválidas");
            }
        } else {
            // Si el usuario no existe, creamos dicho usuario
            if($username !== 'admin') {
                $this->user->usuario = $username;
                $this->user->password = $password;
                $this->user->is_admin = 0;
                $new_user_id = $this->user->create();
                if($new_user_id) {
                    $this->startSession($new_user_id, $username, 0);
                    return array(
                        "success" => true,
                        "user_id" => $new_user_id,
                        "username" => $username,
                        "is_admin" => 0
                    );
                } else {
                    return array("success" => false, "message" => "Error al crear el usuario");
                }
            } else {
                return array("success" => false, "message" => "Credenciales inválidas");
            }
        }
    }

    // Método privado para iniciar la sesión
    private function startSession($id, $username, $is_admin) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = $is_admin;
    }
}
?>

