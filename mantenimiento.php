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
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <h1>Página de Mantenimiento</h1>

    <h2>Mesas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Capacidad</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
        <?php while ($row = $stmt_mesas->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?= $row["id_mesa"] ?></td>
                <td><?= $row["capacidad"] ?></td>
                <td><?= $row["habilitada"] ? "Habilitada" : "Deshabilitada" ?></td>
                <td>
                    <form method="post" class="toggle-form">
                        <input type="hidden" name="id_mesa" value="<?= $row["id_mesa"] ?>">
                        <button class="toggle-button" data-id="<?= $row["id_mesa"] ?>" data-url="deshabilitar.php" data-type="mesa">Cambiar Estado</button>

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
            <tr>
                <td><?= $row["id_silla"] ?></td>
                <td><?= $row["habilitada"] ? "Habilitada" : "Deshabilitada" ?></td>
                <td>
                    <form method="post" class="toggle-form">
                        <input type="hidden" name="id_silla" value="<?= $row["id_silla"] ?>">
                        <button class="toggle-button" data-id="<?= $row["id_silla"] ?>" data-url="deshabilitar.php">Cambiar Estado</button>
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
            <tr>
                <td><?= $row["id_sala"] ?></td>
                <td><?= $row["nombre"] ?></td>
                <td><?= $row["capacidad"] ?></td>
                <td><?= $row["habilitada"] ? "Habilitada" : "Deshabilitada" ?></td>
                <td>
                    <form method="post" class="toggle-form">
                        <input type="hidden" name="id_sala" value="<?= $row["id_sala"] ?>">
                        <button class="toggle-button" data-id="<?= $row["id_sala"] ?>" data-url="deshabilitar.php">Cambiar Estado</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function toggleState(url, id, type, callback) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            callback();
                        } else {
                            alert("Error al cambiar el estado.");
                        }
                    }
                };
                xhr.send("id=" + id + "&type=" + type);
            }


            var toggleButtons = document.querySelectorAll(".toggle-button");
            toggleButtons.forEach(function(button) {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    var id = this.getAttribute("data-id");
                    var url = this.getAttribute("data-url");
                    var type = this.getAttribute("data-type");

                    toggleState(url, id, type, function() {
                        // Recargar solo la sección correspondiente a la entidad (mesa, silla o sala)
                        var sectionId = "table-" + type;
                        var tableSection = document.getElementById(sectionId);
                        tableSection.innerHTML = response.html; // Actualiza la tabla sin recargar la página
                    });
                });
            });

        });
    </script>

</body>

</html>