<?php
// Resto del código de obtener_crud.php

include_once("./inc/conexion.php");

// Operación de Mostrar
$sqlMostrar = "SELECT id_usuario, nombre_usuario, contrasena, tipo_usuario FROM tbl_usuario";
$resultMostrar = $conn->query($sqlMostrar);

if ($resultMostrar) {
    if ($resultMostrar->rowCount() > 0) {
        while ($row = $resultMostrar->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='usuario-container'>";
            echo "<p>ID: " . $row['id_usuario'] . " - Nombre: " . $row['nombre_usuario'] . " - Contraseña: " . $row['contrasena'] . " - Tipo: " . $row['tipo_usuario'] . "</p>";
            echo "<div class='btn-container'>";
            echo "<button id='act' onclick=\"mostrarFormularioActualizacion({$row['id_usuario']})\">Actualizar</button>";
            echo "<button onclick=\"confirmarEliminacionUsuario('{$row['id_usuario']}')\">Eliminar</button>";
            echo "<br>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay usuarios registrados.</p>";
    }
} else {
    throw new Exception("Error en la consulta de usuarios: " . $pdo->errorInfo()[2]);
}
