<?php
// Resto del código de obtener_crud.php

include_once("./inc/conexion.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    // Operación de Mostrar
    $sqlMostrar = "SELECT id_usuario, nombre_usuario, contrasena, tipo_usuario FROM tbl_usuario";
    $resultMostrar = $conn->query($sqlMostrar);

    if ($resultMostrar) {
        if ($resultMostrar->rowCount() > 0) {
            while ($row = $resultMostrar->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='usuario-container'>";
                echo "<p>ID: " . $row['id_usuario'] . " - Nombre: " . $row['nombre_usuario'] . " - Contraseña: " . $row['contrasena'] . " - Tipo: " . $row['tipo_usuario'] . "</p>";
                echo "<div class='btn-container'>";
                echo "<button id='act' onclick=\"mostrarFormularioActualizacion({$row['id_usuario']})\">UPDATE</button>";
                echo "<button id='bor' onclick=\"confirmarEliminacionUsuario('{$row['id_usuario']}')\">DELETE</button>";
                echo "<br>";
                echo "</div>";
                echo "</div>";

                // Formulario de actualización
                echo "<div id='formulario-actualizacion' style='display:none;'>";
                echo "<h2>Actualizar Usuario</h2>";
                echo "<form id='form-actualizacion'>";
                echo "<label for='nombre_usuario'>Nombre:</label>";
                echo "<input type='text' id='nombre_usuario' name='nombre_usuario' required>";

                echo "<label for='tipo_usuario'>Tipo de Usuario:</label>";
                echo "<input type='text' id='tipo_usuario' name='tipo_usuario' required>";

                echo "<label for='contrasena'>Contraseña:</label>";
                echo "<input type='password' id='contrasena' name='contrasena'>";

                echo "<input type='hidden' value='" . $row['id_usuario'] . "' id='id_usuario_actualizacion' name='id_usuario'>";

                echo "<button type='button' onclick='enviarFormularioActualizacion()'>Actualizar</button>";
                echo "<button type='button' onclick='cerrarFormularioActualizacion()'>Cancelar</button>";
                echo "</form>";
                echo "</div>";
    ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById('formulario-actualizacion').style.display = 'none';
                    })

                    function mostrarFormularioActualizacion(idUsuario) {
                        // Establecer el ID del usuario en un campo oculto
                        document.getElementById('id_usuario_actualizacion').value = idUsuario;

                        // Mostrar el formulario de actualización
                        document.getElementById('formulario-actualizacion').style.display = 'block';
                    }

                    function cerrarFormularioActualizacion() {
                        // Ocultar el formulario de actualización
                        document.getElementById('formulario-actualizacion').style.display = 'none';
                    }

                    function enviarFormularioActualizacion() {
                        // Obtener datos del formulario
                        var formData = new FormData(document.getElementById('form-actualizacion'));

                        // Enviar la petición AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'actualizar_usuario.php', true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Manejar la respuesta del servidor (puedes mostrar un mensaje de éxito, etc.)
                                console.log(xhr.responseText);
                                cerrarFormularioActualizacion();
                            }
                        };
                        xhr.send(formData);
                    }
                </script>
    <?php

            }
        } else {
            echo "<div class='usuario-container'>";
            echo "<p>No hay usuarios registrados.</p>";
            echo "</div>";
        }
    } else {
        throw new Exception("Error en la consulta de usuarios: " . $pdo->errorInfo()[2]);
    }
    ?>
</body>

</html>
