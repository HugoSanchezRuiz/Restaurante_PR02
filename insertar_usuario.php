<?php
include_once("./inc/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insertar"])) {
    $nombreUsuario = $_POST["nombre_usuario"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT); // Hash de la contraseña
    $tipoUsuario = $_POST["tipo_usuario"];

    $sqlInsertar = "INSERT INTO tbl_usuario (nombre_usuario, contrasena, tipo_usuario) VALUES (:nombreUsuario, :contrasena, :tipoUsuario)";
    $stmtInsertar = $conn->prepare($sqlInsertar);
    $stmtInsertar->bindParam(':nombreUsuario', $nombreUsuario);
    $stmtInsertar->bindParam(':contrasena', $contrasena);
    $stmtInsertar->bindParam(':tipoUsuario', $tipoUsuario);
    $stmtInsertar->execute();

    // Redirigir a admin.php después de insertar
    header("Location: admin.php");
    exit();
}
?>

<h3>Insertar Usuario</h3>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="nombre_usuario">Nombre de Usuario:</label>
    <input type="text" name="nombre_usuario" required>
    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" required>
    <label for="tipo_usuario">Tipo de Usuario:</label>
    <select name="tipo_usuario" required>
        <option value="admin">Admin</option>
        <option value="gerente">Gerente</option>
        <option value="mantenimiento">Mantenimiento</option>
        <option value="camarero">Camarero</option>
    </select>
    <input type="submit" name="insertar" value="Insertar Usuario">
</form>
