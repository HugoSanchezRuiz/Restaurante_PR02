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
    try {
        include_once("./inc/conexion.php");

        ?>

        <form action='insert_reserva.php' method="post">
            <label for="id_mesa">Seleccionar Mesa:</label>
            <select name="id_mesa" id="id_mesa" required>
                <?php

                $stmt = $conn->query("SELECT id_mesa, id_sala, capacidad FROM tbl_mesa WHERE ocupada = FALSE");
                $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($mesas as $mesa) {
                    echo "<option value='" . $mesa['id_mesa'] . "'>Mesa " . $mesa['id_mesa'] . " - Sala " . $mesa['id_sala'] . " (Capacidad: " . $mesa['capacidad'] . ")</option>";
                }
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

    <?php
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    } finally {
        $conn = null;
    }
    ?>

</body>

</html>
