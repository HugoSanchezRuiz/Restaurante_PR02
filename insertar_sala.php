<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $tipo_sala = $_POST["tipo_sala"];
    $capacidad = $_POST["capacidad"];

    // Manejo de la carga de la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tipo = $_FILES['imagen']['type'];
    $imagen_tamano = $_FILES['imagen']['size'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];

    try {
        include_once("./inc/conexion.php");

        // Verificar si el nombre de la sala ya existe
        $sqlVerificarNombre = "SELECT COUNT(*) as num_salas FROM tbl_sala WHERE nombre = :nombre";
        $stmtVerificarNombre = $conn->prepare($sqlVerificarNombre);
        $stmtVerificarNombre->bindParam(':nombre', $nombre);
        $stmtVerificarNombre->execute();

        if ($stmtVerificarNombre->rowCount() > 0) {
            $num_salas = $stmtVerificarNombre->fetch(PDO::FETCH_ASSOC)['num_salas'];

            if ($num_salas == 0) {
                // El nombre de la sala no existe, se puede proceder con la inserción
                $sql = "INSERT INTO tbl_sala (nombre, tipo_sala, capacidad, imagen_nombre, imagen_tipo, imagen_tamano, imagen_contenido) VALUES (:nombre, :tipo_sala, :capacidad, :imagen_nombre, :imagen_tipo, :imagen_tamano, :imagen_contenido)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':tipo_sala', $tipo_sala);
                $stmt->bindParam(':capacidad', $capacidad);
                $stmt->bindParam(':imagen_nombre', $imagen_nombre);
                $stmt->bindParam(':imagen_tipo', $imagen_tipo);
                $stmt->bindParam(':imagen_tamano', $imagen_tamano);
                $stmt->bindParam(':imagen_contenido', file_get_contents($imagen_temporal));

                if ($stmt->execute()) {
                    echo "Sala insertada con éxito.";
                } else {
                    echo "Error al insertar la sala.";
                }
            } else {
                echo "Error: El nombre de la sala ya existe.";
            }
        } else {
            echo "Error al verificar el nombre de la sala.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $conn = null;
}
?>
