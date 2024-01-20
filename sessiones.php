<?php
session_start();

if (!isset($_GET['usuario'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
} else {
    $usuarioRecibido = $_GET['usuario'];
    $_SESSION['usuario'] = $usuarioRecibido;

    // Lógica para redireccionar en base al tipo de usuario
    $redireccion = '';

    switch ($usuarioRecibido) {
        case 'admin':
            $redireccion = './admin.php';
            break;

        case 'gerente':
            $redireccion = './admin.php';
            break;

        case 'mantenimiento':
            $redireccion = './mantenimiento.php';
            break;
        default:
            // Verificar si el nombre del usuario contiene la palabra "camarero"
            if (strpos($usuarioRecibido, 'camarero') !== false) {
                $redireccion = './mostrar_mesas.php';
            } else {
                // Si el tipo de usuario no coincide con ningún caso y no contiene la palabra "camarero", redirige a alguna página predeterminada
                $redireccion = './index.php';
            }
            break;
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Redireccionando...</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>

    <style>
        html {
            background-color: #3a5f68;
            color: #3a5f68;
        }
    </style>

    <body>
        <script>
            Swal.fire({
                title: "Aceptado",
                text: "Has entrado a la página principal",
                icon: "success"
            }).then(() => {
                // Redirigir según el tipo de usuario
                window.location.href = "<?php echo $redireccion; ?>";
            });
        </script>
    </body>

    </html>
<?php
    exit(); // Salir después de enviar el script de JavaScript
}
?>

</body>

</html>