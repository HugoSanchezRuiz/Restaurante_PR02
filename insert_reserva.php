<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        include_once("./inc/conexion.php");
        $id_mesa = $_POST["id_mesa"];
        $usuario = $_POST["usuario"];
        $nombre_cliente = $_POST["nombre_cliente"];
        $fecha_reserva = $_POST["fecha_reserva"];
        $hora_reserva = $_POST["hora_reserva"];
        $datetime_reserva = $fecha_reserva . ' ' . $hora_reserva;
        $fecha_fin_reserva = date("Y-m-d H:i:s", strtotime($datetime_reserva . ' + 1 hour'));

        $sqlObtenerIdCamarero = "SELECT id_usuario FROM tbl_usuario WHERE nombre_usuario = :usuario AND tipo_usuario = 'camarero'";
        $stmtObtenerIdCamarero = $conn->prepare($sqlObtenerIdCamarero);
        $stmtObtenerIdCamarero->bindParam(':usuario', $usuario);
        $stmtObtenerIdCamarero->execute();

        if ($stmtObtenerIdCamarero->rowCount() > 0) {
            $id_camarero = $stmtObtenerIdCamarero->fetch(PDO::FETCH_ASSOC)['id_usuario'];

            // Verificar si la mesa ya está ocupada en el momento seleccionado
            $sqlVerificarOcupada = "SELECT COUNT(*) as count_ocupada FROM tbl_ocupacion WHERE id_mesa = :id_mesa AND fecha_reserva = :fecha_reserva AND hora_reserva = :hora_reserva";
            $stmtVerificarOcupada = $conn->prepare($sqlVerificarOcupada);
            $stmtVerificarOcupada->bindParam(':id_mesa', $id_mesa);
            $stmtVerificarOcupada->bindParam(':fecha_reserva', $fecha_reserva);
            $stmtVerificarOcupada->bindParam(':hora_reserva', $hora_reserva);

            $stmtVerificarOcupada->execute();
            $countOcupada = $stmtVerificarOcupada->fetch(PDO::FETCH_ASSOC)['count_ocupada'];

            if ($countOcupada > 0) {
                echo "<br>";
                echo "<br>";
                echo "<p style='color: red'>Error: La mesa $id_mesa ya está ocupada en la fecha y hora seleccionadas.</p>";
            } else {
                // La mesa no está ocupada, se puede hacer la reserva
                $sql = "INSERT INTO tbl_ocupacion (id_mesa, id_usuario, fecha_reserva, hora_reserva, fecha_inicio, fecha_fin, es_reserva) VALUES (:id_mesa, :id_camarero, :fecha_reserva, :hora_reserva, :fecha_inicio, :fecha_fin_reserva, TRUE)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id_mesa', $id_mesa);
                $stmt->bindParam(':id_camarero', $id_camarero);
                $stmt->bindParam(':fecha_reserva', $fecha_reserva);
                $stmt->bindParam(':hora_reserva', $hora_reserva);
                $stmt->bindParam(':fecha_inicio', $datetime_reserva);
                $stmt->bindParam(':fecha_fin_reserva', $fecha_fin_reserva);

                if ($stmt->execute()) {
                    // Actualizar el estado de la mesa a ocupada
                    $sqlActualizarMesa = "UPDATE tbl_mesa SET ocupada = TRUE WHERE id_mesa = :id_mesa";
                    $stmtActualizarMesa = $conn->prepare($sqlActualizarMesa);
                    $stmtActualizarMesa->bindParam(':id_mesa', $id_mesa);
                    $stmtActualizarMesa->execute();

                    echo "<br>";
                    echo "<br>";
                    echo "Reserva realizada con éxito de la mesa " . $id_mesa . " a nombre de " . $nombre_cliente;
                    echo "<br>";
                } else {
                    echo "Error al hacer la reserva.";
                }
            }
        } else {
            echo "<br>";
            echo "<br>";
            echo "Error: No se encontró al camarero con el nombre proporcionado.";
        }
        $conn = null;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
} else {
    echo "f";
}
?>
