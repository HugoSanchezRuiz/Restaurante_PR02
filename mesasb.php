<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Mesa</title>
</head>
<body>

<h2>Borrar Mesa</h2>

<form action="borrar_mesa.php" method="post">
    <label for="id_mesa">Seleccionar Mesa a Borrar:</label>
    <select name="id_mesa" id="id_mesa" required>
        <?php
        include_once("./inc/conexion.php");

        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $result = mysqli_query($conn, "SELECT id_mesa, id_sala, capacidad FROM tbl_mesa");

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['id_mesa'] . "'>Mesa " . $row['id_mesa'] . " - Sala " . $row['id_sala'] . " (Capacidad: " . $row['capacidad'] . ")</option>";
        }

        mysqli_close($conn);
        ?>
    </select>
    <br>

    <input type="submit" value="Borrar Mesa">
</form>
<a href="./mostrar_mesas.php">Ir atrás</a>

</body>
</html>
