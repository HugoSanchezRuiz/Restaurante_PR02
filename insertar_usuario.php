<?php
include_once("./inc/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST["nombre_usuario"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT); // Hash de la contraseña
    $tipoUsuario = $_POST["tipo_usuario"];

    $sqlInsertar = "INSERT INTO tbl_usuario (nombre_usuario, contrasena, tipo_usuario) VALUES (:nombreUsuario, :contrasena, :tipoUsuario)";
    $stmtInsertar = $conn->prepare($sqlInsertar);
    $stmtInsertar->bindParam(':nombreUsuario', $nombreUsuario);
    $stmtInsertar->bindParam(':contrasena', $contrasena);
    $stmtInsertar->bindParam(':tipoUsuario', $tipoUsuario);

    try {
        $stmtInsertar->execute();
        echo "ok"; // Éxito al insertar el usuario
    } catch (Exception $e) {
        echo "Error al insertar el usuario: " . $e->getMessage();
    }
}
?>