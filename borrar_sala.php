<?php
session_start();

include_once('./inc/conexion.php');

if (isset($_GET['id_sala'])) {
    $id_sala = $_GET['id_sala'];

    try {
        $conn->beginTransaction();

        // 1. Eliminar filas en tbl_mesa asociadas a la sala
        $sql1 = "DELETE FROM tbl_mesa WHERE id_sala = :id_sala";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $stmt1->execute();

        // 2. Eliminar sala
        $sql2 = "DELETE FROM tbl_sala WHERE id_sala = :id_sala";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $stmt2->execute();

        $conn->commit();

        header('Location: ./admin.php');
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage() . "<br>";
    }
} else {
    header('Location:  ./index.php');
    exit();
}
?>
