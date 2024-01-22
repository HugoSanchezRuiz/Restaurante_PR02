<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            text-align: center;
            color: #333;
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <h2>Hacer Reserva</h2>
    <?php
    try {
        include_once("./inc/conexion.php");
        $usuario = $_GET['usuario'];
        // echo $usuario;

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
            <input type="date" name="fecha_reserva" id="fecha_reserva" required>
            <br>

            <label for="hora_reserva">Hora de Reserva:</label>
            <input type="time" name="hora_reserva" id="hora_reserva" required>
            <br>
            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">



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