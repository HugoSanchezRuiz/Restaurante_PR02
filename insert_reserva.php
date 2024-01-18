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

    include_once("./inc/conexion.php");

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verificar si la mesa ya está ocupada
    $sqlVerificarOcupada = "SELECT ocupada FROM tbl_mesa WHERE id_mesa = '$id_mesa'";
    $resultVerificarOcupada = mysqli_query($conn, $sqlVerificarOcupada);

    if ($resultVerificarOcupada) {
        $rowVerificarOcupada = mysqli_fetch_assoc($resultVerificarOcupada);

        if ($rowVerificarOcupada['ocupada'] == 1) {
            echo "Error: La mesa $id_mesa ya está ocupada.";
        } else {
            // La mesa no está ocupada, se puede hacer la reserva
            $sql = "INSERT INTO tbl_ocupacion (id_mesa, id_camarero, fecha_inicio) VALUES ('$id_mesa', 1, '$fecha_reserva')";

            if (mysqli_query($conn, $sql)) {
                // Actualizar el estado de la mesa a ocupada
                mysqli_query($conn, "UPDATE tbl_mesa SET ocupada = TRUE WHERE id_mesa = '$id_mesa'");
                echo "Reserva realizada con éxito de la mesa ".$id_mesa." a nombre de ".$nombre_cliente;
            } else {
                echo "Error al hacer la reserva: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error al verificar el estado de la mesa: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
<br>
<br>
<a href="./mostrar_mesas.php">Ir a página principal</a>
</body>
</html>



