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
    $idUsuario = $nombreUsuario = $tipoUsuario = $contrasena = '';

    // Verificar si se ha enviado el formulario y procesarlo
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtener los datos del formulario
        $idUsuario = $_POST["id_usuario"];
        $nombreUsuario = $_POST["nombre_usuario"];
        $tipoUsuario = $_POST["tipo_usuario"];
        $contrasena = $_POST["contrasena"];

        try {
            // Verificar si el nombre de usuario ya existe (excluyendo el usuario actual)
            $sqlVerificarUsuario = "SELECT COUNT(*) as num_usuarios FROM tbl_usuario WHERE nombre_usuario = :nombreUsuario AND id_usuario != :idUsuario";
            $stmtVerificarUsuario = $conn->prepare($sqlVerificarUsuario);
            $stmtVerificarUsuario->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtVerificarUsuario->bindParam(':idUsuario', $idUsuario);
            $stmtVerificarUsuario->execute();

            if ($stmtVerificarUsuario->rowCount() > 0) {
                $numUsuarios = $stmtVerificarUsuario->fetch(PDO::FETCH_ASSOC)['num_usuarios'];

                if ($numUsuarios == 0) {
                    // El nombre de usuario no existe, se puede proceder con la actualización
                    $sqlActualizar = "UPDATE tbl_usuario SET nombre_usuario = :nombreUsuario, tipo_usuario = :tipoUsuario";

                    // Agregar contraseña al SQL si se proporciona
                    if (!empty($contrasena)) {
                        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
                        $sqlActualizar .= ", contrasena = :contrasena";
                    }

                    $sqlActualizar .= " WHERE id_usuario = :idUsuario";

                    $stmtActualizar = $conn->prepare($sqlActualizar);
                    $stmtActualizar->bindParam(':nombreUsuario', $nombreUsuario);
                    $stmtActualizar->bindParam(':tipoUsuario', $tipoUsuario);

                    // Agregar contraseña al enlace si se proporciona
                    if (!empty($contrasena)) {
                        $stmtActualizar->bindParam(':contrasena', $contrasenaHash);
                    }

                    $stmtActualizar->bindParam(':idUsuario', $idUsuario);
                    $stmtActualizar->execute();
                    echo "<div id='container'>";
                    echo "Usuario Actualizado"; // Éxito al actualizar el usuario
                } else {
                    echo "Error: El nombre de usuario ya existe.";
                }
            } else {
                echo "Error al verificar el nombre de usuario.";
            }
        } catch (Exception $e) {
            echo "Error al actualizar el usuario: " . $e->getMessage();
        }
    } else {
        // Si no se ha enviado el formulario por POST, obtener datos para mostrar en el formulario
        if (isset($_GET['id_usuario'])) {
            $idUsuario = $_GET["id_usuario"];

            // Obtener datos del usuario por su ID
            $sqlObtenerDatos = "SELECT * FROM tbl_usuario WHERE id_usuario = ?";
            $stmtObtenerDatos = $conn->prepare($sqlObtenerDatos);
            $stmtObtenerDatos->bindParam(1, $idUsuario, PDO::PARAM_INT);
            $stmtObtenerDatos->execute();
            $datosActualizados = $stmtObtenerDatos->fetch(PDO::FETCH_ASSOC);

            // Asignar valores a las variables
            $nombreUsuario = $datosActualizados['nombre_usuario'];
            $tipoUsuario = $datosActualizados['tipo_usuario'];
        }
    }
    ?>


    <!-- Formulario de actualización -->
    <div id='container'>
        <?php if (!empty($datosActualizados) && is_array($datosActualizados)) : ?>
            <h2>Actualizar Usuario</h2>
            <form id='form-actualizacion' action='' method='POST' onsubmit='return validarFormulario()'>
                <?php foreach ($datosActualizados as $campo => $valor) : ?>
                    <?php if ($campo != 'id_usuario') : ?>
                        <label for='<?php echo $campo; ?>'><?php echo ucfirst(str_replace('_', ' ', $campo)); ?>:</label>
                        <?php if ($campo == 'contrasena') : ?>
                            <input type='password' id='<?php echo $campo; ?>' name='<?php echo $campo; ?>' placeholder='Deje en blanco para mantener la contraseña actual'>
                        <?php else : ?>
                            <input type='text' id='<?php echo $campo; ?>' name='<?php echo $campo; ?>' value='<?php echo htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'); ?>'>
                        <?php endif; ?>
                        <span id='error_<?php echo $campo; ?>' style='color: red;'></span>
                    <?php endif; ?>
                <?php endforeach; ?>
                <input type='hidden' value='<?php echo isset($datosActualizados['id_usuario']) ? htmlspecialchars($datosActualizados['id_usuario'], ENT_QUOTES, 'UTF-8') : ''; ?>' id='id_usuario_actualizacion' name='id_usuario'>
                <button type='submit' class='btn-submit' onclick="return validarFormulario()">Actualizar</button>
            <?php else : ?>
                <p></p>
            <?php endif; ?>
            </form>
            <a href="./admin.php">Volver atrás</a>
    </div>


    <!-- Resto del código -->

    <script>
        function validarFormulario() {
            // Restablecer mensajes de error
            document.getElementById('error_nombre_usuario').innerHTML = '';
            document.getElementById('error_tipo_usuario').innerHTML = '';
            document.getElementById('error_contrasena').innerHTML = '';

            var nombreUsuario = document.getElementById('nombre_usuario').value;
            var tipoUsuario = document.getElementById('tipo_usuario').value;
            var contrasena = document.getElementById('contrasena').value;

            // Validar nombre de usuario
            if (nombreUsuario.trim() === '') {
                document.getElementById('error_nombre').innerHTML = 'Ingrese el nombre de usuario.';
                return false;
            }

            // Validar tipo de usuario
            if (tipoUsuario.trim() === '') {
                document.getElementById('error_tipo').innerHTML = 'Ingrese el tipo de usuario.';
                return false;
            }

            // Puedes agregar más validaciones según tus requisitos

            return true;
        }
    </script>
</body>

</html>

