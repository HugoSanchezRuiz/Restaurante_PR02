<!-- deshabilitar.php -->
<?php
include_once('./inc/conexion.php');

try {
    $type = isset($_POST["type"]) ? $_POST["type"] : "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];

        if ($type == "mesa") {
            $stmt = $conn->prepare("UPDATE tbl_mesa SET habilitada = NOT habilitada WHERE id_mesa = :id_mesa");
            $stmt->bindParam(':id_mesa', $id);
            $stmt->execute();
        } elseif ($type == "silla") {
            $stmt = $conn->prepare("UPDATE tbl_silla SET habilitada = NOT habilitada WHERE id_silla = :id_silla");
            $stmt->bindParam(':id_silla', $id);
            $stmt->execute();
        } elseif ($type == "sala") {
            $stmt = $conn->prepare("UPDATE tbl_sala SET habilitada = NOT habilitada WHERE id_sala = :id_sala");
            $stmt->bindParam(':id_sala', $id);
            $stmt->execute();
        }

        // Obtener el nuevo estado y devolverlo como respuesta
        $stmt_estado = $conn->prepare("SELECT habilitada FROM tbl_$type WHERE id_$type = :id");
        $stmt_estado->bindParam(':id', $id);
        $stmt_estado->execute();
        $nuevo_estado = $stmt_estado->fetch(PDO::FETCH_COLUMN);
        echo $nuevo_estado ? "Habilitada" : "Deshabilitada";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
