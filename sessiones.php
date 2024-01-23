<?php
session_start();
include_once "./inc/conexion.php";
if (!isset($_GET['usuario'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión si no detecta un usuario
    exit();
} else {
    $usuarioRecibido = $_GET['usuario'];
    $_SESSION['usuario'] = $usuarioRecibido;

    // Lógica para redireccionar en base al tipo de usuario
    $redireccion = '';

    $query = "SELECT tipo_usuario FROM tbl_usuario WHERE nombre_usuario = :nombre";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nombre', $usuarioRecibido, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si la consulta fue exitosa
    if ($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $tipo_usuario = $row['tipo_usuario'];

        // Lógica para redirigir en base al tipo de usuario
        $redireccion = '';

        switch ($tipo_usuario) {
            case 'admin':
                $redireccion = './admin.php';
                break;

            case 'gerente':
                $redireccion = './admin.php';
                break;

            case 'mantenimiento':
                $redireccion = './mantenimiento.php';
                break;

            case 'camarero':
                $redireccion = './mostrar_mesas.php';
                break;

            default:
                
        }

    } else {
        // Manejar el error según sea necesario
        die("Error al obtener el tipo de usuario: " . $pdo->errorInfo()[2]);
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