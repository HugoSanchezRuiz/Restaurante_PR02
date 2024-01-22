<?php
include_once("./inc/conexion.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuario = $_GET['id'];

    $sqlUsuario = "SELECT id_usuario, nombre_usuario, tipo_usuario FROM tbl_usuario WHERE id_usuario = ?";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->execute([$idUsuario]);

    $datosUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if (!$datosUsuario) {
        header("Location: ./index.php");
        exit();
    }
} else {
    header("Location: ./index.php");
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
    <form id="updateForm" action="#" method="post">
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $datosUsuario['id_usuario']; ?>">

        <label for="nombre_usuario">Nuevo Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" value="<?php echo $datosUsuario['nombre_usuario']; ?>" required>

        <label for="contrasena">Nueva Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena">

        <label for="tipo_usuario">Nuevo Tipo de Usuario:</label>
        <select name="tipo_usuario" id="tipo_usuario" required>
            <option value="admin" <?php echo ($datosUsuario['tipo_usuario'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="gerente" <?php echo ($datosUsuario['tipo_usuario'] === 'gerente') ? 'selected' : ''; ?>>Gerente</option>
            <option value="mantenimiento" <?php echo ($datosUsuario['tipo_usuario'] === 'mantenimiento') ? 'selected' : ''; ?>>Mantenimiento</option>
            <option value="camarero" <?php echo ($datosUsuario['tipo_usuario'] === 'camarero') ? 'selected' : ''; ?>>Camarero</option>
        </select>

        <input type="submit" name="actualizar" id="actualizarB" value="Actualizar Usuario">
    </form>
    <a href="admin.php" class="button">Cancelar</a>

    <script>
            console.log("dhewdj");
    document.getElementById("actualizarB").onsubmit = actualizar;


    function actualizar() {

        // Obtener los valores correctos de los campos del formulario
        var idUsuario = document.getElementById("id_usuario").value;
        var nombreUsuario = document.getElementById("nombre_usuario").value;
        var contrasena = document.getElementById("contrasena").value;
        var tipoUsuario = document.getElementById("tipo_usuario").value;

        // Crear FormData con los valores correctos
        var formData = new FormData();
        formData.append('id_usuario', idUsuario);
        formData.append('nombre_usuario', nombreUsuario);
        formData.append('contrasena', contrasena);
        formData.append('tipo_usuario', tipoUsuario);

        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Éxito al actualizar el usuario
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario Actualizado',
                        showConfirmButton: true,
                        timer: 5000
                    });
                    // Puedes realizar acciones adicionales si es necesario
                } else {
                    // Error al actualizar el usuario
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Actualizar Usuario',
                        text: xhr.responseText
                    });
                }
            }
        };

        xhr.open("POST", "actualizar_usuario.php", true); 
        xhr.send(formData);
    }
</script>


    </script>

</body>

</html>