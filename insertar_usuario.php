<?php
include_once("./inc/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST["usuario"];
    $contrasena = password_hash($_POST["pwd"], PASSWORD_DEFAULT); // Hash de la contraseña
    $tipoUsuario = $_POST["tipo_usuario"];

    try {
        // Verificar si el nombre de usuario ya existe
        $sqlVerificarUsuario = "SELECT COUNT(*) as num_usuarios FROM tbl_usuario WHERE nombre_usuario = :nombreUsuario";
        $stmtVerificarUsuario = $conn->prepare($sqlVerificarUsuario);
        $stmtVerificarUsuario->bindParam(':nombreUsuario', $nombreUsuario);
        $stmtVerificarUsuario->execute();

        if ($stmtVerificarUsuario->rowCount() > 0) {
            $numUsuarios = $stmtVerificarUsuario->fetch(PDO::FETCH_ASSOC)['num_usuarios'];

            if ($numUsuarios == 0) {
                // El nombre de usuario no existe, se puede proceder con la inserción
                $sqlInsertar = "INSERT INTO tbl_usuario (nombre_usuario, contrasena, tipo_usuario) VALUES (:nombreUsuario, :contrasena, :tipoUsuario)";
                $stmtInsertar = $conn->prepare($sqlInsertar);
                $stmtInsertar->bindParam(':nombreUsuario', $nombreUsuario);
                $stmtInsertar->bindParam(':contrasena', $contrasena);
                $stmtInsertar->bindParam(':tipoUsuario', $tipoUsuario);

                $stmtInsertar->execute();
                echo "Usuario Insertado"; // Éxito al insertar el usuario
            } else {
                echo "Error: El nombre de usuario ya existe.";
            }
        } else {
            echo "Error al verificar el nombre de usuario.";
        }
    } catch (Exception $e) {
        echo "Error al insertar el usuario: " . $e->getMessage();
    }
}
?>
