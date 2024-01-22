<?php
include_once("./inc/conexion.php");

// Consulta SQL para obtener las reservas
$sqlReservas = "SELECT * FROM tbl_ocupacion";
$stmtReservas = $conn->query($sqlReservas);

// Obtener todas las filas de reservas
$reservas = $stmtReservas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Reservas</title>
    <!-- Agrega aquí tus enlaces a CSS, SweetAlert, etc. -->
    <link rel="stylesheet" href="ruta/a/tu/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #3a5f68;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        thead {
            background-color: #3a5f68;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>

    <h1>Reservas</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID Ocupación</th>
                <th>ID Mesa</th>
                <th>ID Usuario</th>
                <th>Fecha Reserva</th>
                <th>Hora Reserva</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Es Reserva</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva) : ?>
                <tr>
                    <td><?= $reserva['id_ocupacion'] ?></td>
                    <td><?= $reserva['id_mesa'] ?></td>
                    <td><?= $reserva['id_usuario'] ?></td>
                    <td><?= $reserva['fecha_reserva'] ?></td>
                    <td><?= $reserva['hora_reserva'] ?></td>
                    <td><?= $reserva['fecha_inicio'] ?></td>
                    <td><?= $reserva['fecha_fin'] ?></td>
                    <td><?= $reserva['es_reserva'] ? 'Sí' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="./mostrar_mesas.php" class="button">Volver atrás</a>

</body>

</html>