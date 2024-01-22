<?php
session_start();

include './includes/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $search = $_POST["search"];

    // Realiza la búsqueda de usuarios por nombre o username, excluyendo al usuario actual
    $search_query = "SELECT id_user, nombre, username FROM tbl_usuario WHERE (nombre LIKE ? OR username LIKE ?) AND id_user != ?";

    $stmt_search = $pdo->prepare($search_query);
    $search_param = "%" . $search . "%";
    $stmt_search->bindParam(1, $search_param, PDO::PARAM_STR);
    $stmt_search->bindParam(2, $search_param, PDO::PARAM_STR);
    $stmt_search->bindParam(3, $user_id, PDO::PARAM_INT);

    $stmt_search->execute();

    $search_result = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

    if (!$search_result) {
        print_r($pdo->errorInfo());
    }
}