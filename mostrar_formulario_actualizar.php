<?php
include_once("./inc/conexion.php");

// Verificar si se ha proporcionado un ID de usuario válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Obtener los datos actuales del usuario
    $sqlUsuario = "SELECT id_usuario, nombre_usuario, tipo_usuario FROM tbl_usuario WHERE id_usuario = ?";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->execute([$idUsuario]);

    $datosUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron datos para el ID proporcionado
    if (!$datosUsuario) {
        // Si no se encontraron datos, redirigir o manejar el error según sea necesario
        header("Location: ./index.php"); // Cambia la redirección según tus necesidades
        exit();
    }
} else {
    // Si no se proporcionó un ID válido, redirigir o manejar el error según sea necesario
    header("Location: ./index.php"); // Cambia la redirección según tus necesidades
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
</head>

<body>

    <h3>Actualizar Usuario</h3>
    <form action="admin.php" method="post">
        <input type="hidden" name="id_usuario" value="<?php echo $datosUsuario['id_usuario']; ?>">

        <label for="nombre_usuario">Nuevo Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" value="<?php echo $datosUsuario['nombre_usuario']; ?>">

        <label for="contrasena">Nueva Contraseña:</label>
        <input type="password" name="contrasena">

        <!-- Agrega más campos según sea necesario -->

        <label for="tipo_usuario">Nuevo Tipo de Usuario:</label>
        <select name="tipo_usuario" required>
            <option value="admin" <?php echo ($datosUsuario['tipo_usuario'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="gerente" <?php echo ($datosUsuario['tipo_usuario'] === 'gerente') ? 'selected' : ''; ?>>Gerente</option>
            <option value="mantenimiento" <?php echo ($datosUsuario['tipo_usuario'] === 'mantenimiento') ? 'selected' : ''; ?>>Mantenimiento</option>
            <option value="camarero" <?php echo ($datosUsuario['tipo_usuario'] === 'camarero') ? 'selected' : ''; ?>>Camarero</option>
        </select>

        <input type="submit" name="actualizar" id="actualizarB" value="Actualizar Usuario">
    </form>
    <a href="admin.php" class="button">Cancelar</a>

</body>

</html>