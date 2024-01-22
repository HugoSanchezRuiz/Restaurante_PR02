<?php

require_once("./includes/conexion.php");

session_start();

if (!isset($_SESSION["user_id"])) {
    // Si el usuario no tiene la sesión iniciada, redirige o muestra un mensaje de error
    echo "No has iniciado sesión.";
    echo "<p><a href='./includes/cerrar_session.php'>Iniciar Sesión</a></p>";
    // Puedes agregar aquí un enlace para redirigir al usuario a la página de inicio de sesión.
    exit();
}

$user_id = $_SESSION["user_id"];

if (!empty($_POST["search"])) {
    $data = $_POST["search"];
    // Modificamos la consulta para excluir al usuario activo y a sus amigos
    $consulta = $pdo->prepare("
        SELECT id_usuario, nombre_usuario, tipo_usuario
        FROM tbl_usuario
        WHERE (nombre_usuario LIKE :data OR tipo_usuario LIKE :data)
        AND id_usuario != :user_id
        AND id_usuario NOT IN (
            SELECT usuario_2 FROM tbl_amigos WHERE usuario_1 = :user_id
        )
    ");
    $consulta->bindValue(':data', '%' . $data . '%', PDO::PARAM_STR);
    $consulta->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $consulta->execute();
} else {
    // Modificamos la consulta para excluir al usuario activo y a sus amigos
    $consulta = $pdo->prepare("
        SELECT id_usuario, nombre_usuario, tipo_usuario
        FROM tbl_usuario
        WHERE id_usuario != :user_id
        AND id_usuario NOT IN (
            SELECT usuario_2 FROM tbl_amigos WHERE usuario_1 = :user_id
        )
    ");
    $consulta->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $consulta->execute();
}

$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

if (count($resultado) > 0) {
    // Si hay resultados, mostrarlos
    foreach ($resultado as $usuario) {
        echo "<div class='search-result' id='resultado_" . $usuario['id_usuario'] . "'>";
        echo "<p>Nombre de Usuario: " . $usuario['nombre_usuario'] . " | Tipo de Usuario: " . $usuario['tipo_usuario'] . "</p>";

        echo "</div>";
    }
} else {
    // Si no hay resultados, mostrar un mensaje
    echo "No se encontraron usuarios que coincidan con la búsqueda.";
}
?>
