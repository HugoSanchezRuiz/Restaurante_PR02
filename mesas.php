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
        try {
            include_once("./inc/conexion.php");

            $stmt = $conn->query("SELECT id_sala, nombre FROM tbl_sala");
            $salas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($salas as $sala) {
                echo "<option value='" . $sala['id_sala'] . "'>" . $sala['nombre'] . "</option>";
            }
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        } finally {
            $conn = null;
        }
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
