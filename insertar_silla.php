<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mesa = $_POST["id_mesa"];

    try {
        include_once("./inc/conexion.php");

        // Verificar si la mesa tiene capacidad para más sillas antes de insertar
        $sqlVerificarCapacidad = "SELECT capacidad FROM tbl_mesa WHERE id_mesa = :id_mesa";
        $stmtVerificarCapacidad = $conn->prepare($sqlVerificarCapacidad);
        $stmtVerificarCapacidad->bindParam(':id_mesa', $id_mesa);
        $stmtVerificarCapacidad->execute();

        if ($stmtVerificarCapacidad->rowCount() > 0) {
            $capacidad_mesa = $stmtVerificarCapacidad->fetch(PDO::FETCH_ASSOC)['capacidad'];

            // Verificar si ya hay suficientes sillas en la mesa
            $sqlContarSillas = "SELECT COUNT(*) as num_sillas FROM tbl_silla WHERE id_mesa = :id_mesa";
            $stmtContarSillas = $conn->prepare($sqlContarSillas);
            $stmtContarSillas->bindParam(':id_mesa', $id_mesa);
            $stmtContarSillas->execute();

            if ($stmtContarSillas->rowCount() > 0) {
                $num_sillas = $stmtContarSillas->fetch(PDO::FETCH_ASSOC)['num_sillas'];

                if ($num_sillas < $capacidad_mesa) {
                    // Se puede insertar la silla
                    $sqlInsertarSilla = "INSERT INTO tbl_silla (id_mesa) VALUES (:id_mesa)";
                    $stmtInsertarSilla = $conn->prepare($sqlInsertarSilla);
                    $stmtInsertarSilla->bindParam(':id_mesa', $id_mesa);

                    if ($stmtInsertarSilla->execute()) {
                        echo "Silla insertada con éxito.";
                    } else {
                        echo "Error al insertar la silla.";
                    }
                } else {
                    echo "Error: La mesa ya tiene la capacidad máxima de sillas.";
                }
            } else {
                echo "Error al contar las sillas de la mesa.";
            }
        } else {
            echo "Error: No se encontró la mesa con ID $id_mesa.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $conn = null;
}
?>
