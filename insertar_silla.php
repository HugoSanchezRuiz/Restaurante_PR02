<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mesa = $_POST["id_mesa"];

    try {
        include_once("./inc/conexion.php");

        $sql = "INSERT INTO tbl_silla (id_mesa) VALUES (:id_mesa)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_mesa', $id_mesa);
        // Bind otros parámetros

        if ($stmt->execute()) {
            echo "Silla insertada con éxito.";
        } else {
            echo "Error al insertar la silla.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $conn = null;
}
?>
