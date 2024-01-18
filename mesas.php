<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserción de Mesas</title>
</head>
<body>

<h2>Insertar Mesa</h2>

<form action="insertar_mesas.php" method="post">
    <label for="id_sala">ID Sala:</label>
    <select name="id_sala" id="id_sala" required>
        <?php
        include_once("./inc/conexion.php");

        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $result = mysqli_query($conn, "SELECT id_sala, nombre FROM tbl_sala");

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['id_sala'] . "'>" . $row['nombre'] . "</option>";
        }

        mysqli_close($conn);
        ?>
    </select>
    <br>

    <label for="capacidad">Capacidad:</label>
    <input type="number" name="capacidad" id="capacidad" required>
    <br>

    <input type="submit" value="Insertar Mesa">
</form>
<a href="./mostrar_mesas.php">Ir atrás</a>
</body>
</html>
