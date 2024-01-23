<?php
include_once("./inc/conexion.php");

if (isset($_POST["id_usuario"])) {
    $idUsuario = $_POST["id_usuario"];
    $nombreUsuario = $_POST["nombre_usuario"];
    $tipoUsuario = $_POST["tipo_usuario"];
    $contrasena = $_POST["contrasena"];

    // Validar y sanear datos según sea necesario

    // Hashear la contraseña solo si se proporciona
    $contrasenaHash = (!empty($contrasena)) ? password_hash($contrasena, PASSWORD_DEFAULT) : null;

    $sqlActualizar = "UPDATE tbl_usuario SET nombre_usuario = ?, tipo_usuario = ?";
    $parametros = [$nombreUsuario, $tipoUsuario];

    // Agregar contraseña al SQL si se proporciona
    if ($contrasenaHash !== null) {
        $sqlActualizar .= ", contrasena = ?";
        $parametros[] = $contrasenaHash;
    }

    $sqlActualizar .= " WHERE id_usuario = ?";
    $parametros[] = $idUsuario;

    $stmtActualizar = $conn->prepare($sqlActualizar);
    $stmtActualizar->execute($parametros);

    // Obtener los datos actualizados
    $sqlObtenerDatos = "SELECT * FROM tbl_usuario WHERE id_usuario = ?";
    $stmtObtenerDatos = $conn->prepare($sqlObtenerDatos);
    $stmtObtenerDatos->execute([$idUsuario]);
    $datosActualizados = $stmtObtenerDatos->fetch(PDO::FETCH_ASSOC);

    // Devolver los datos actualizados como respuesta JSON
    header('Content-Type: application/json'); // Corregir la línea de Content-Type
    echo json_encode($datosActualizados);
    exit;
}
?>
