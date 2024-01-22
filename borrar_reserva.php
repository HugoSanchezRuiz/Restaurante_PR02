<?php
session_start();

include_once('./inc/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id_reserva'])) {
        $id_reserva = $_GET['id_reserva'];

        try {
            $conn->beginTransaction();

            // 1. Eliminar la reserva
            $sql1 = "DELETE FROM tbl_ocupacion WHERE id_ocupacion = :id_reserva";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt1->execute();

            $conn->commit();

            echo "Reserva borrada exitosamente.";
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "ID de reserva no proporcionado.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
