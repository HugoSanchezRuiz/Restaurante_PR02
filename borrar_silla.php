<?php
session_start();

include_once('./inc/conexion.php');

if (isset($_GET['id_silla'])) {
    $id_silla = $_GET['id_silla'];

    try {
        $conn->beginTransaction();

        // 1. Eliminar fila en tbl_silla
        $sql1 = "DELETE FROM tbl_silla WHERE id_silla = :id_silla";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(':id_silla', $id_silla, PDO::PARAM_INT);
        $stmt1->execute();

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
