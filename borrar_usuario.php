<?php
include_once("./inc/conexion.php");

if (isset($_GET['id_usuario'])) {
    $idUsuario = $_GET['id_usuario'];

    $sql1 = "DELETE FROM tbl_ocupacion WHERE id_usuario = :id_usuario";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt1->execute();

    // Operación de Eliminar
    $sqlEliminar = "DELETE FROM tbl_usuario WHERE id_usuario = ?";
    $stmtEliminar = $conn->prepare($sqlEliminar);
    $stmtEliminar->bindParam(1, $idUsuario);
    $stmtEliminar->execute();
}
