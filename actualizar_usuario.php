<?php
include_once("./inc/conexion.php");

// Operación de Actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $idUsuario = $_POST["id"];
    $nombreUsuario = $_POST["nombre_usuario"];
    $tipoUsuario = $_POST["tipo_usuario"];
    $contrasena = $_POST["contrasena"];

    // Hashear la contraseña usando password_hash
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sqlActualizar = "UPDATE tbl_usuario SET nombre_usuario = ?, contrasena = ?, tipo_usuario = ? WHERE id_usuario = ?";
    $stmtActualizar = $conn->prepare($sqlActualizar);
    $stmtActualizar->bindParam(1, $nombreUsuario);
    $stmtActualizar->bindParam(2, $contrasenaHash);
    $stmtActualizar->bindParam(3, $tipoUsuario);
    $stmtActualizar->bindParam(4, $idUsuario);
    $stmtActualizar->execute();

    // Obtener los datos actualizados
    $sqlObtenerDatos = "SELECT * FROM tbl_usuario WHERE id_usuario = ?";
    $stmtObtenerDatos = $conn->prepare($sqlObtenerDatos);
    $stmtObtenerDatos->bindParam(1, $idUsuario);
    $stmtObtenerDatos->execute();
    $datosActualizados = $stmtObtenerDatos->fetch(PDO::FETCH_ASSOC);

    // Devolver los datos actualizados como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($datosActualizados);
    exit;
}
?>
