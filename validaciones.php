<?php
session_start();

if (!isset($_POST['inicio'])) {
    header("location: ../index.html");
    exit;
} else if (isset($_GET['logout'])) {
    session_destroy();
    header("location: ../index.html");
    exit;
} else { // comprobamos que la solicitud se envíe con POST
    $nombre = $_POST["nombre"];
    $contra = $_POST["contra"];

    // Validación del nombre y la contra
    if (empty($nombre) || empty($contra)) {
        header("Location: ../login.php?emptyUsr");
        exit;
    } else if (empty($nombre)) {
        header("Location: ../login.php?emptyNombre");
        exit;
    } else if (empty($contra)) {
        header("Location: ../login.php?emptyContra");
        exit;
    }

    // Incluye el archivo que contiene la conexión a la base de datos.
    include_once("./conexion.php");

    try {
        // Se prepara una consulta SQL para seleccionar datos de la tabla "tbl_camarero" donde el campo "nombre" sea igual al valor de la variable $nombre.
        $query = "SELECT id_camarero, contra FROM tbl_camarero WHERE nombre = ?";
        $stmt = $conn->prepare($query);

        // Se vincula el valor de $nombre como un parámetro en la consulta SQL (tipo string).
        $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
        // Se ejecuta la consulta con el valor $nombre.
        $stmt->execute();

        // Si la consulta devuelve al menos una fila (es decir, el nombre existe en la base de datos).
        if ($stmt->rowCount() > 0) {
            // Se obtienen los valores de las columnas en las variables correspondientes.
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_camarero = $row['id_camarero'];
            $hashedContra = $row['contra'];

            // Se verifica si la contraseña proporcionada ($contra) coincide con la contraseña almacenada en la base de datos ($hashedContra).
            if (password_verify($contra, $hashedContra)) {
                // Inicio de sesión exitoso
                session_start();
                // Se almacena el ID del camarero en la sesión.
                $_SESSION["id_camarero"] = $id_camarero;
                // Redirige al usuario a una página de contenido (la línea comentada no está activa).
                header("Location: ../alumnos.php");
            } else {
                // Si la contraseña no coincide, se redirige de vuelta a la página de inicio de sesión con un mensaje de error.
                header("Location: ../login.php?errorContra");
            }
        } else {
            // Si el nombre no existe en la base de datos, se redirige de vuelta a la página de inicio de sesión con un mensaje de error.
            header("Location: ../login.php?errorNombre");
        }
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        echo "Error: " . $e->getMessage();
    } finally {
        // Se cierra el statement de PDO.
        $stmt = null;
        // Se cierra la conexión a la base de datos.
        $conn = null;
    }
}
?>
