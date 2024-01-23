<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer Reserva</title>
    <link rel="stylesheet" href="./css/formularioreserva.css">
</head>

<body>

    <div id="container">
        <h2>Hacer Reserva</h2>
        <?php
        try {
            include_once("./inc/conexion.php");
            $usuario = $_GET['usuario'];
        ?>

            <form id="reservaForm">
                <label for="id_mesa">Seleccionar Mesa:</label>
                <select name="id_mesa" id="id_mesa">
                    <option value="" disabled selected>Selecciona una mesa</option>
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
                <input type="text" name="nombre_cliente" id="nombre_cliente">
                <br>

                <label for="fecha_reserva">Fecha de Reserva:</label>
                <input type="date" name="fecha_reserva" id="fecha_reserva">
                <br>

                <label for="hora_reserva">Hora de Reserva:</label>
                <!-- <input type="time" name="hora_reserva" id="fecha_reserva" required> -->
                <select name="hora_reserva" id="hora_reserva" required>
                    <option value="" disabled selected>Selecciona una hora</option>
                    <?php
                    // Generar opciones para las horas en punto, excluyendo 01:00 a 07:00
                    for ($hora = 8; $hora < 24; $hora++) {
                        $horaFormato = sprintf('%02d', $hora);
                        echo "<option value='$horaFormato:00'>$horaFormato:00</option>";
                    }
                    ?>
                </select>
                <br>
                <span id="error_vacio"></span>
                <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                <br>

                <input type="button" id="hacerReservaBtn" value="Hacer Reserva" onclick="validarYHacerReserva()">
            </form>
            <a href="./mostrar_mesas.php">Ir atrás</a>

            <div id="mensajeReserva"></div>


        <?php
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        } finally {
            $conn = null;
        }
        ?>
    </div>
    <script>
        function validarYHacerReserva() {
            // Validar el formulario antes de enviar la solicitud
            var formulario = document.getElementById('reservaForm');
            var inputs = formulario.querySelectorAll('input, select');
            var spanError = document.getElementById("error_vacio");
            var validacionExitosa = true;

            inputs.forEach(function(input) {
                if (input.required && input.value.trim() === "") {
                    spanError.textContent = "Por favor, complete todos los campos.";
                    validacionExitosa = false;
                }
            });

            if (validacionExitosa) {
                spanError.textContent = ""; // Limpiar el mensaje de error
                hacerReserva();
            }
        }

        function hacerReserva() {
            var formulario = document.getElementById('reservaForm');
            var datos = new FormData(formulario);

            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById('mensajeReserva').innerHTML = xhr.responseText;
                    } else {
                        console.error("Error al realizar la solicitud: " + xhr.status);
                    }
                }
            };

            xhr.open("POST", "insert_reserva.php", true);
            xhr.send(datos);
        }
    </script>

</body>

</html>