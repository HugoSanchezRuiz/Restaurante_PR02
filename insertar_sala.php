<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $tipo_sala = $_POST["tipo_sala"];
    $capacidad = $_POST["capacidad"];
    // Agrega otros campos necesarios para la sala

    try {
        include_once("./inc/conexion.php");

        $sql = "INSERT INTO tbl_sala (nombre, tipo_sala, capacidad) VALUES (:nombre, :tipo_sala, :capacidad)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':tipo_sala', $tipo_sala);
        $stmt->bindParam(':capacidad', $capacidad);
        // Bind otros parámetros

        if ($stmt->execute()) {
            echo "Sala insertada con éxito.";
        } else {
            echo "Error al insertar la sala.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $conn = null;
}
?>
