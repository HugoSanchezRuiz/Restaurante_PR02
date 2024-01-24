<?php
// Resto del código de obtener_crud.php

include_once("./inc/conexion.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar usuarios</title>

    
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
                echo "<button id='act' onclick=\"mostrarSweetAlert('{$row['id_usuario']}', '{$row['nombre_usuario']}', '{$row['tipo_usuario']}', '{$row['contrasena']}')\">UPDATE</button>";

                echo "<button id='bor' onclick=\"confirmarEliminacionUsuario('{$row['id_usuario']}')\">DELETE</button>";
                echo "<br>";
                echo "</div>";
                echo "</div>";
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
