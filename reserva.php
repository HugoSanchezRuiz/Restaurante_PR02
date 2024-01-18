<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer Reserva</title>
</head>

<body>

    <h2>Hacer Reserva</h2>
    <?php
    //echo $_SESSION['camarero'];
    ?>

    <?php
    include_once("./inc/conexion.php");

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    ?>

    <form action='insert_reserva.php' method="post">
        <label for="id_mesa">Seleccionar Mesa:</label>
        <select name="id_mesa" id="id_mesa" required>
            <?php

            $result = mysqli_query($conn, "SELECT id_mesa, id_sala, capacidad FROM tbl_mesa WHERE ocupada = FALSE");

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id_mesa'] . "'>Mesa " . $row['id_mesa'] . " - Sala " . $row['id_sala'] . " (Capacidad: " . $row['capacidad'] . ")</option>";
            }

            mysqli_close($conn);
            ?>
        </select>
        <br>

        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" name="nombre_cliente" id="nombre_cliente" required>
        <br>

        <label for="fecha_reserva">Fecha de Reserva:</label>
        <input type="datetime-local" name="fecha_reserva" id="fecha_reserva" required>
        <br>

        <input type='submit' value='Hacer Reserva'>
        

    </form>
    <a href="./mostrar_mesas.php">Ir atrás</a>

</body>

</html>