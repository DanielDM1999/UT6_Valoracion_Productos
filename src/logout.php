<?php
//Iniciamos y destruimos la sesión
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>