<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Sala</title>
    <link rel="stylesheet" href="./css/actualizar.css">
</head>

<body>
    <?php
    include_once("./inc/conexion.php");

    // Inicializar variables
    $idSala = $nombreSala = $tipoSala = $capacidad = '';

    // Verificar si se ha enviado el formulario y procesarlo
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtener los datos del formulario
        $idSala = $_POST["id_sala"];
        $nombreSala = $_POST["nombre_sala"];
        $tipoSala = $_POST["tipo_sala"];
        $capacidad = $_POST["capacidad"];

        try {
            // Verificar si los datos son válidos (puedes agregar más validaciones según tus necesidades)

            $sqlActualizarSala = "UPDATE tbl_sala SET nombre = :nombreSala, tipo_sala = :tipoSala, capacidad = :capacidad WHERE id_sala = :idSala";
            $stmtActualizarSala = $conn->prepare($sqlActualizarSala);
            $stmtActualizarSala->bindParam(':nombreSala', $nombreSala);
            $stmtActualizarSala->bindParam(':tipoSala', $tipoSala);
            $stmtActualizarSala->bindParam(':capacidad', $capacidad);
            $stmtActualizarSala->bindParam(':idSala', $idSala);
            $stmtActualizarSala->execute();

            echo "<div id='container'>";
            echo "Sala Actualizada"; // Éxito al actualizar la sala
        } catch (Exception $e) {
            echo "Error al actualizar la sala: " . $e->getMessage();
        }
    } else {
        // Si no se ha enviado el formulario por POST, obtener datos para mostrar en el formulario
        if (isset($_GET['id_sala'])) {
            $idSala = $_GET["id_sala"];

            // Obtener datos de la sala por su ID
            $sqlObtenerDatosSala = "SELECT * FROM tbl_sala WHERE id_sala = ?";
            $stmtObtenerDatosSala = $conn->prepare($sqlObtenerDatosSala);
            $stmtObtenerDatosSala->bindParam(1, $idSala, PDO::PARAM_INT);
            $stmtObtenerDatosSala->execute();
            $datosSalaActualizada = $stmtObtenerDatosSala->fetch(PDO::FETCH_ASSOC);

            // Asignar valores a las variables
            $nombreSala = $datosSalaActualizada['nombre'];
            $tipoSala = $datosSalaActualizada['tipo_sala'];
            $capacidad = $datosSalaActualizada['capacidad'];
        }
    }
    ?>

    <!-- Formulario de actualización para salas -->
    <div id='container'>
        <?php if (!empty($datosSalaActualizada) && is_array($datosSalaActualizada)) : ?>
            <h2>Actualizar Sala</h2>
            <form id='form-actualizacion-sala' action='' method='POST' onsubmit='return validarFormularioSala()'>
                <label for='nombre_sala'>Nombre de Sala:</label>
                <input type='text' id='nombre_sala' name='nombre_sala' value='<?php echo htmlspecialchars($nombreSala, ENT_QUOTES, 'UTF-8'); ?>' required>
                <span id='error_nombre_sala' style='color: red;'></span>

                <label for='tipo_sala'>Tipo de Sala:</label>
                <input type='text' id='tipo_sala' name='tipo_sala' value='<?php echo htmlspecialchars($tipoSala, ENT_QUOTES, 'UTF-8'); ?>' required>
                <span id='error_tipo_sala' style='color: red;'></span>

                <label for='capacidad'>Capacidad:</label>
                <input type='number' id='capacidad' name='capacidad' value='<?php echo htmlspecialchars($capacidad, ENT_QUOTES, 'UTF-8'); ?>' required>
                <span id='error_capacidad' style='color: red;'></span>

                <input type='hidden' value='<?php echo isset($datosSalaActualizada['id_sala']) ? htmlspecialchars($datosSalaActualizada['id_sala'], ENT_QUOTES, 'UTF-8') : ''; ?>' id='id_sala_actualizacion' name='id_sala'>
                <button type='submit' class='btn-submit' onclick="return validarFormularioSala()">Actualizar</button>
            </form>
        <?php else : ?>
            <p></p>
        <?php endif; ?>
        <a href="./admin.php">Volver atrás</a>
    </div>

    <script>
        function validarFormularioSala() {
            // Restablecer mensajes de error
            document.getElementById('error_nombre_sala').innerHTML = '';
            document.getElementById('error_tipo_sala').innerHTML = '';
            document.getElementById('error_capacidad').innerHTML = '';

            var nombreSala = document.getElementById('nombre_sala').value;
            var tipoSala = document.getElementById('tipo_sala').value;
            var capacidad = document.getElementById('capacidad').value;

            // Validar nombre de sala
            if (nombreSala.trim() === '') {
                document.getElementById('error_nombre_sala').innerHTML = 'Ingrese el nombre de la sala.';
                return false;
            }

            // Validar tipo de sala
            if (tipoSala.trim() === '') {
                document.getElementById('error_tipo_sala').innerHTML = 'Ingrese el tipo de la sala.';
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
