<?php

include_once('./inc/conexion.php');
try {
    include_once('./inc/conexion.php');

    // Manejar las solicitudes de habilitación/deshabilitación
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["id_mesa"])) {
            $id_mesa = $_POST["id_mesa"];
            // Realizar la actualización en la tabla tbl_mesa
            $stmt = $conn->prepare("UPDATE tbl_mesa SET habilitada = NOT habilitada WHERE id_mesa = :id_mesa");
            $stmt->bindParam(':id_mesa', $id_mesa);
            $stmt->execute();
        } elseif (isset($_POST["id_silla"])) {
            $id_silla = $_POST["id_silla"];
            // Realizar la actualización en la tabla tbl_silla
            $stmt = $conn->prepare("UPDATE tbl_silla SET habilitada = NOT habilitada WHERE id_silla = :id_silla");
            $stmt->bindParam(':id_silla', $id_silla);
            $stmt->execute();
        } elseif (isset($_POST["id_sala"])) {
            $id_sala = $_POST["id_sala"];
            // Realizar la actualización en la tabla tbl_sala
            $stmt = $conn->prepare("UPDATE tbl_sala SET habilitada = NOT habilitada WHERE id_sala = :id_sala");
            $stmt->bindParam(':id_sala', $id_sala);
            $stmt->execute();
        }
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>