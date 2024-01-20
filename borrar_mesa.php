<?php
session_start();

include_once('./inc/conexion.php');

if (isset($_GET['id_mesa'])) {
    $id_mesa = $_GET['id_mesa'];

    try {
        $conn->beginTransaction();

        // 1. Eliminar filas en tbl_ocupacion
        $sql1 = "DELETE FROM tbl_ocupacion WHERE id_mesa = :id_mesa";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
        $stmt1->execute();

        // 2. Eliminar filas en tbl_silla
        $sql2 = "DELETE FROM tbl_silla WHERE id_mesa = :id_mesa";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
        $stmt2->execute();

        // 3. Eliminar fila en tbl_mesa
        $sql3 = "DELETE FROM tbl_mesa WHERE id_mesa = :id_mesa";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
        $stmt3->execute();

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
