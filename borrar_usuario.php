<?php
include_once("./inc/conexion.php");

if (isset($_GET['nombre_usuario'])) {
    $nombreUsuario = $_GET['nombre_usuario'];

    // Operación de Eliminar
    $sqlEliminar = "DELETE FROM tbl_usuario WHERE nombre_usuario = ?";
    $stmtEliminar = $conn->prepare($sqlEliminar);
    $stmtEliminar->bindParam(1, $nombreUsuario);
    $stmtEliminar->execute();

    // No hay necesidad de redireccionar aquí
}
?>
