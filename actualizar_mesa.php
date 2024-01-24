<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/actualizar.css">
</head>

<body>
    <?php
    include_once("./inc/conexion.php");

    // Inicializar variables
    $idMesa = $idSala = $capacidad = '';

    // Verificar si se ha enviado el formulario y procesarlo
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtener los datos del formulario
        $idMesa = $_POST["id_mesa"];
        $idSala = $_POST["id_sala"];
        $capacidad = $_POST["capacidad"];

        try {
            // Verificar si el id de la sala y capacidad son válidos (puedes agregar más validaciones según tus necesidades)

            // El nombre de la sala es solo para referencia en el formulario
            $sqlActualizarMesa = "UPDATE tbl_mesa SET id_sala = :idSala, capacidad = :capacidad WHERE id_mesa = :idMesa";
            $stmtActualizarMesa = $conn->prepare($sqlActualizarMesa);
            $stmtActualizarMesa->bindParam(':idSala', $idSala);
            $stmtActualizarMesa->bindParam(':capacidad', $capacidad);
            $stmtActualizarMesa->bindParam(':idMesa', $idMesa);
            $stmtActualizarMesa->execute();

            echo "<div id='container'>";
            echo "Mesa Actualizada"; // Éxito al actualizar la mesa
            echo "<a href='./admin.php'>Volver atrás</a>";
            echo "</div>";
        } catch (Exception $e) {
            echo "Error al actualizar la mesa: " . $e->getMessage();
        }
    } else {
        // Si no se ha enviado el formulario por POST, obtener datos para mostrar en el formulario
        if (isset($_GET['id_mesa'])) {
            $idMesa = $_GET["id_mesa"];

            // Obtener datos de la mesa por su ID
            $sqlObtenerDatosMesa = "SELECT * FROM tbl_mesa WHERE id_mesa = ?";
            $stmtObtenerDatosMesa = $conn->prepare($sqlObtenerDatosMesa);
            $stmtObtenerDatosMesa->bindParam(1, $idMesa, PDO::PARAM_INT);
            $stmtObtenerDatosMesa->execute();
            $datosMesaActualizada = $stmtObtenerDatosMesa->fetch(PDO::FETCH_ASSOC);

            // Asignar valores a las variables
            $idSala = $datosMesaActualizada['id_sala'];
            $capacidad = $datosMesaActualizada['capacidad'];
        }

        // Mostrar el formulario
        echo "<div id='container'>";
        if (!empty($datosMesaActualizada) && is_array($datosMesaActualizada)) {
            echo "<h2>Actualizar Mesa</h2>";
            echo "<form id='form-actualizacion-mesa' action='' method='POST' onsubmit='return validarFormularioMesa()'>";
            echo "<label for='id_sala'>Número de Sala:</label>";
            echo "<input type='number' id='id_sala' name='id_sala' value='" . htmlspecialchars($idSala, ENT_QUOTES, 'UTF-8') . "' required>";
            echo "<span id='error_id_sala' style='color: red;'></span>";

            echo "<label for='capacidad'>Capacidad:</label>";
            echo "<input type='number' id='capacidad' name='capacidad' value='" . htmlspecialchars($capacidad, ENT_QUOTES, 'UTF-8') . "' required>";
            echo "<span id='error_capacidad' style='color: red;'></span>";

            echo "<input type='hidden' value='" . (isset($datosMesaActualizada['id_mesa']) ? htmlspecialchars($datosMesaActualizada['id_mesa'], ENT_QUOTES, 'UTF-8') : '') . "' id='id_mesa_actualizacion' name='id_mesa'>";
            echo "<button type='submit' class='btn-submit' onclick='return validarFormularioMesa()'>Actualizar</button>";
            echo "</form>";
        } else {
            echo "<p></p>";
        }
        // Volver atrás fuera del formulario
        echo "<a href='./admin.php'>Volver atrás</a>";
        echo "</div>";
    }
    ?>

    <script>
        function validarFormularioMesa() {
            // Restablecer mensajes de error
            document.getElementById('error_id_sala').innerHTML = '';
            document.getElementById('error_capacidad').innerHTML = '';

            var idSala = document.getElementById('id_sala').value;
            var capacidad = document.getElementById('capacidad').value;

            // Validar id de sala
            if (idSala.trim() === '') {
                document.getElementById('error_id_sala').innerHTML = 'Ingrese el número de sala.';
                return false;
            }

            // Validar capacidad
            if (capacidad.trim() === '' || capacidad <= 0) {
                document.getElementById('error_capacidad').innerHTML = 'Ingrese una capacidad válida.';
                return false;
            }

            // Puedes agregar más validaciones según tus requisitos

            return true;
        }
    </script>
</body>

</html>
