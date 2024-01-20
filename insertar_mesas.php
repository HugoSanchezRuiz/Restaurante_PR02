<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sala = $_POST["id_sala"];
    $capacidad = $_POST["capacidad"];
    echo $id_sala;

    try {
        include_once("./inc/conexion.php");

        $sql = "INSERT INTO tbl_mesa (id_sala, capacidad) VALUES (:id_sala, :capacidad)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_sala', $id_sala);
        $stmt->bindParam(':capacidad', $capacidad);

        if ($stmt->execute()) {
            echo "Mesa insertada con éxito.";
        } else {
            echo "Error al insertar la mesa.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $conn = null;
}
?>
