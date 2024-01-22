<?php

include_once('./inc/conexion.php');
try {
    include_once('./inc/conexion.php');

    // Obtener información sobre mesas, sillas y salas
    $stmt_mesas = $conn->query("SELECT * FROM tbl_mesa");
    $stmt_sillas = $conn->query("SELECT * FROM tbl_silla");
    $stmt_salas = $conn->query("SELECT * FROM tbl_sala");

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Mantenimiento</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #3a5f68;
            margin: 20px 0;
        }

        table {
            width: 80%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
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

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d2b33;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #0d2b33;
        }

        .toggle-button {
            background-color: #0d2b33;
            color: white;
            border: none;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .toggle-button:hover {
            background-color: #0d2b33;
        }
    </style>
</head>
<body>

<h1>Página de Mantenimiento</h1>

<div id="crudRecursos"></div>

<h2>Mesas</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Capacidad</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>
    <?php while ($row = $stmt_mesas->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr id="mesa<?= $row["id_mesa"] ?>">
            <td><?= $row["id_mesa"] ?></td>
            <td><?= $row["capacidad"] ?></td>
            <td><?= $row["habilitada"] ? "Habilitada" : "Deshabilitada" ?></td>
            <td>
                <form method="post" class="toggle-form" data-type="mesa" data-id="<?= $row["id_mesa"] ?>">
                    <button type="button" class="toggle-button" onclick="toggleEstado(this)">Cambiar Estado</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Sillas</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>
    <?php while ($row = $stmt_sillas->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr id="silla<?= $row["id_silla"] ?>">
            <td><?= $row["id_silla"] ?></td>
            <td><?= $row["habilitada"] ? "Habilitada" : "Deshabilitada" ?></td>
            <td>
                <form method="post" class="toggle-form" data-type="silla" data-id="<?= $row["id_silla"] ?>">
                    <button type="button" class="toggle-button" onclick="toggleEstado(this)">Cambiar Estado</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Salas</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Capacidad</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>
    <?php while ($row = $stmt_salas->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr id="sala<?= $row["id_sala"] ?>">
            <td><?= $row["id_sala"] ?></td>
            <td><?= $row["nombre"] ?></td>
            <td><?= $row["capacidad"] ?></td>
            <td><?= $row["habilitada"] ? "Habilitada" : "Deshabilitada" ?></td>
            <td>
                <form method="post" class="toggle-form" data-type="sala" data-id="<?= $row["id_sala"] ?>">
                    <button type="button" class="toggle-button" onclick="toggleEstado(this)">Cambiar Estado</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="./index.php" class="button">Volver Login</a>
<br>
<br>
<script>
    function toggleEstado(button) {
        var form = button.closest("form");
        var type = form.getAttribute("data-type");
        var id = form.getAttribute("data-id");

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "deshabilitar.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Actualizar la interfaz de usuario
                var row = document.getElementById(type + id);
                var estado = row.cells[row.cells.length - 2]; // La columna del estado

                // Cambiar el estado en la interfaz de usuario con la respuesta del servidor
                estado.innerHTML = xhr.responseText.trim();
            }
        };
        xhr.send("type=" + type + "&id=" + id);
    }
</script>

</body>
</html>