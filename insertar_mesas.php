<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sala = $_POST["id_sala"];
    $capacidad_nueva_mesa = $_POST["capacidad"];
    
    try {
        include_once("./inc/conexion.php");

        // Consulta para obtener la capacidad actual de la sala
        $sqlCapacidadSala = "SELECT capacidad FROM tbl_sala WHERE id_sala = :id_sala";
        $stmtCapacidadSala = $conn->prepare($sqlCapacidadSala);
        $stmtCapacidadSala->bindParam(':id_sala', $id_sala);
        $stmtCapacidadSala->execute();
        
        if ($stmtCapacidadSala->rowCount() > 0) {
            $capacidad_sala_actual = $stmtCapacidadSala->fetch(PDO::FETCH_ASSOC)['capacidad'];
            
            // Verifica si la capacidad de la sala es suficiente para la nueva mesa
            if ($capacidad_sala_actual >= $capacidad_nueva_mesa) {
                $sqlInsertarMesa = "INSERT INTO tbl_mesa (id_sala, capacidad) VALUES (:id_sala, :capacidad)";
                $stmtInsertarMesa = $conn->prepare($sqlInsertarMesa);
                $stmtInsertarMesa->bindParam(':id_sala', $id_sala);
                $stmtInsertarMesa->bindParam(':capacidad', $capacidad_nueva_mesa);

                if ($stmtInsertarMesa->execute()) {
                    echo "Mesa insertada con éxito.";
                } else {
                    echo "Error al insertar la mesa.";
                }
            } else {
                echo "Error: La capacidad de la sala no es suficiente para la nueva mesa.";
            }
        } else {
            echo "Error: No se encontró la sala con ID $id_sala.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $conn = null;
}
?>
