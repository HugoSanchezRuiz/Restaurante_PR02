<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mesa = $_POST["id_mesa"];
    $nombre_cliente = $_POST["nombre_cliente"];
    $fecha_reserva = $_POST["fecha_reserva"];

    

    try {
        include_once("./inc/conexion.php");

        // Verificar si la mesa ya está ocupada
        $sqlVerificarOcupada = "SELECT ocupada FROM tbl_mesa WHERE id_mesa = :id_mesa";
        $stmtVerificarOcupada = $conn->prepare($sqlVerificarOcupada);
        $stmtVerificarOcupada->bindParam(':id_mesa', $id_mesa);
        $stmtVerificarOcupada->execute();
        $rowVerificarOcupada = $stmtVerificarOcupada->fetch(PDO::FETCH_ASSOC);

        if ($rowVerificarOcupada['ocupada'] == 1) {
            echo "Error: La mesa $id_mesa ya está ocupada.";
        } else {
            // La mesa no está ocupada, se puede hacer la reserva
            $sql = "INSERT INTO tbl_ocupacion (id_mesa, id_camarero, fecha_inicio) VALUES (:id_mesa, 1, :fecha_reserva)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_mesa', $id_mesa);
            $stmt->bindParam(':fecha_reserva', $fecha_reserva);

            if ($stmt->execute()) {
                // Actualizar el estado de la mesa a ocupada
                $sqlActualizarMesa = "UPDATE tbl_mesa SET ocupada = TRUE WHERE id_mesa = :id_mesa";
                $stmtActualizarMesa = $conn->prepare($sqlActualizarMesa);
                $stmtActualizarMesa->bindParam(':id_mesa', $id_mesa);
                $stmtActualizarMesa->execute();

                echo "Reserva realizada con éxito de la mesa ".$id_mesa." a nombre de ".$nombre_cliente;
            } else {
                echo "Error al hacer la reserva.";
            }
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $conn = null;
}
?>
<br>
<br>
<a href="./mostrar_mesas.php">Ir a página principal</a>
</body>
</html>
