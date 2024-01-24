<?php
include_once("./inc/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscarMesa"])) {
    $search = $_POST["buscarMesa"];

    // Realiza la búsqueda de mesas por nombre o tipo de mesa
    $search_query = "SELECT id_mesa, id_sala, capacidad FROM tbl_mesa WHERE id_mesa LIKE ?";

    $stmt_search = $conn->prepare($search_query);
    $stmt_search->bindParam(1, $search_param, PDO::PARAM_INT);

    $stmt_search->execute();

    $search_result = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

    if (!$search_result) {
        echo "<div class='mesa-container'>";
        echo "No se encuentra ninguna mesa con esas características.";
        echo "</div>";
    } else {
        foreach ($search_result as $mesa) {
            echo "<div class='mesa-container'>";
            echo "<p>ID Mesa: " . $mesa['id_mesa'] . " - Sala: " . $mesa['id_sala'] . " - Capacidad: " . $mesa['capacidad'] . "</p>";
            // Agrega aquí el código necesario para los botones u otras acciones relacionadas con las mesas
            echo "<br>";
            echo "</div>";
        }
    }
}
?>
