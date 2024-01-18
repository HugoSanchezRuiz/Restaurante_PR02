<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sala = $_POST["id_sala"];
    $capacidad = $_POST["capacidad"];
    echo $id_sala;

    include_once("./inc/conexion.php");

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO tbl_mesa (id_sala, capacidad) VALUES ('$id_sala', '$capacidad')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Mesa insertada con éxito.";
    } else {
        echo "Error al insertar la mesa: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
