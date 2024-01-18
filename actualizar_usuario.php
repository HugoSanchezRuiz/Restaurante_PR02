<?php
include_once("./inc/conexion.php");

// Operación de Actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $idUsuario = $_POST["id"];
    $nombreUsuario = $_POST["nombre"];
    $tipoUsuario = $_POST["tipo"];
    $contrasena = $_POST["contrasena"];

    // Hashear la contraseña usando password_hash
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sqlActualizar = "UPDATE tbl_usuario SET nombre_usuario = ?, contrasena = ?, tipo_usuario = ? WHERE id_usuario = ?";
    $stmtActualizar = $conn->prepare($sqlActualizar);
    $stmtActualizar->bindParam(1, $nombreUsuario);
    $stmtActualizar->bindParam(2, $contrasenaHash); // Almacenar la contraseña hasheada
    $stmtActualizar->bindParam(3, $tipoUsuario);
    $stmtActualizar->bindParam(4, $idUsuario);
    $stmtActualizar->execute();
}
?>
