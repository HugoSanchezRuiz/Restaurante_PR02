<?php
include_once("./inc/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscarUsuario"])) {
    $search = $_POST["buscarUsuario"];

    // Realiza la búsqueda de usuarios por nombre o username, excluyendo al usuario actual
    // $search_query = "SELECT id_usuario, nombre_usuario, tipo_usuario FROM tbl_usuario WHERE (nombre_usuario LIKE ? OR tipo_usuario LIKE ?)";
    $search_query = "SELECT id_usuario, nombre_usuario, contrasena, tipo_usuario FROM tbl_usuario WHERE (nombre_usuario LIKE ? OR tipo_usuario LIKE ?)";

    $stmt_search = $conn->prepare($search_query);
    $search_param = "%" . $search . "%";
    $stmt_search->bindParam(1, $search_param, PDO::PARAM_STR);
    $stmt_search->bindParam(2, $search_param, PDO::PARAM_STR);

    $stmt_search->execute();

    $search_result = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

    if (!$search_result) {
        // print_r($conn->errorInfo());
        echo "<div class='usuario-container'>";
        echo "No se encuentra ningun usuario con esas características.";
        echo "</div>";
    } else {
        foreach ($search_result as $usuario) {
            echo "<div class='usuario-container'>";
            echo "<p>ID: " . $usuario['id_usuario'] . " - Nombre: " . $usuario['nombre_usuario'] . " - Contraseña: " . $usuario['contrasena'] . " - Tipo: " . $usuario['tipo_usuario'] . "</p>";
            echo "<div class='btn-container'>";
            echo "<button id='act' onclick=\"mostrarFormularioActualizacion({$usuario['id_usuario']})\">UPDATE</button>";
            echo "<button id='bor' onclick=\"confirmarEliminacionUsuario('{$usuario['id_usuario']}')\">DELETE</button>";
            echo "<br>";
            echo "</div>";
            echo "</div>";
        }
    }
}
