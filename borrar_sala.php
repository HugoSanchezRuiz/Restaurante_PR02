<?php
session_start();

include_once('./inc/conexion.php');

if (isset($_GET['id_sala'])) {
    $id_sala = $_GET['id_sala'];

    try {
        $conn->beginTransaction();

        // Obtener las ocupaciones de las mesas en la sala
        $sql_occupations = "SELECT id_mesa FROM tbl_mesa WHERE id_sala = :id_sala";
        $stmt_occupations = $conn->prepare($sql_occupations);
        $stmt_occupations->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $stmt_occupations->execute();

        while ($row = $stmt_occupations->fetch(PDO::FETCH_ASSOC)) {
            $id_mesa = $row['id_mesa'];

            // Eliminar ocupaciones de la mesa
            $sql_delete_occupations = "DELETE FROM tbl_ocupacion WHERE id_mesa = :id_mesa";
            $stmt_delete_occupations = $conn->prepare($sql_delete_occupations);
            $stmt_delete_occupations->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
            $stmt_delete_occupations->execute();
        }

        // Eliminar filas en tbl_mesa asociadas a la sala
        $sql_delete_mesa = "DELETE FROM tbl_mesa WHERE id_sala = :id_sala";
        $stmt_delete_mesa = $conn->prepare($sql_delete_mesa);
        $stmt_delete_mesa->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $stmt_delete_mesa->execute();

        // Eliminar sala
        $sql_delete_sala = "DELETE FROM tbl_sala WHERE id_sala = :id_sala";
        $stmt_delete_sala = $conn->prepare($sql_delete_sala);
        $stmt_delete_sala->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $stmt_delete_sala->execute();

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
