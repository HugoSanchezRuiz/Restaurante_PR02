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
        try {
            include_once("./inc/conexion.php");

            $stmt = $conn->query("SELECT id_mesa, id_sala, capacidad FROM tbl_mesa");
            $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($mesas as $mesa) {
                echo "<option value='" . $mesa['id_mesa'] . "'>Mesa " . $mesa['id_mesa'] . " - Sala " . $mesa['id_sala'] . " (Capacidad: " . $mesa['capacidad'] . ")</option>";
            }
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        } finally {
            $conn = null;
        }
        ?>
    </select>
    <br>

    <input type="submit" value="Borrar Mesa">
</form>
<a href="./mostrar_mesas.php">Ir atrás</a>

</body>
</html>
