<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Silla</title>
    <link rel="stylesheet" href="./css/actualizar.css">
</head>

<body>
<?php
include_once("./inc/conexion.php");

// Inicializar variables
$idSilla = $idMesa = '';

// Verificar si se ha enviado el formulario y procesarlo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $idSilla = $_POST["id_silla"];
    $idMesa = $_POST["id_mesa"];

    try {
        // Verificar si el id de la mesa es válido (puedes agregar más validaciones según tus necesidades)

        $sqlActualizarSilla = "UPDATE tbl_silla SET id_mesa = :idMesa WHERE id_silla = :idSilla";
        $stmtActualizarSilla = $conn->prepare($sqlActualizarSilla);
        $stmtActualizarSilla->bindParam(':idMesa', $idMesa);
        $stmtActualizarSilla->bindParam(':idSilla', $idSilla);
        $stmtActualizarSilla->execute();

        echo "<div id='container'>";
        echo "Silla Actualizada"; // Éxito al actualizar la silla
    } catch (Exception $e) {
        echo "Error al actualizar la silla: " . $e->getMessage();
    }
} else {
    // Si no se ha enviado el formulario por POST, obtener datos para mostrar en el formulario
    if (isset($_GET['id_silla'])) {
        $idSilla = $_GET["id_silla"];

        // Obtener datos de la silla por su ID
        $sqlObtenerDatosSilla = "SELECT * FROM tbl_silla WHERE id_silla = ?";
        $stmtObtenerDatosSilla = $conn->prepare($sqlObtenerDatosSilla);
        $stmtObtenerDatosSilla->bindParam(1, $idSilla, PDO::PARAM_INT);
        $stmtObtenerDatosSilla->execute();
        $datosSillaActualizada = $stmtObtenerDatosSilla->fetch(PDO::FETCH_ASSOC);

        // No necesitamos más datos para la actualización de silla
    }
}
?>

<!-- Formulario de actualización para sillas -->
<div id='container'>
    <?php if (!empty($datosSillaActualizada) && is_array($datosSillaActualizada)) : ?>
        <h2>Actualizar Silla</h2>
        <form id='form-actualizacion-silla' action='' method='POST' onsubmit='return validarFormularioSilla()'>
            <label for='id_mesa'>Número de Mesa:</label>
            <input type='number' id='id_mesa' name='id_mesa' value='<?php echo htmlspecialchars($idMesa, ENT_QUOTES, 'UTF-8'); ?>' required>
            <span id='error_id_mesa' style='color: red;'></span>

            <input type='hidden' value='<?php echo isset($datosSillaActualizada['id_silla']) ? htmlspecialchars($datosSillaActualizada['id_silla'], ENT_QUOTES, 'UTF-8') : ''; ?>' id='id_silla_actualizacion' name='id_silla'>
            <button type='submit' class='btn-submit' onclick="return validarFormularioSilla()">Actualizar</button>
        </form>
    <?php else : ?>
        <p></p>
    <?php endif; ?>
    <a href="./admin.php">Volver atrás</a>
</div>

<script>
    function validarFormularioSilla() {
        // Restablecer mensajes de error
        document.getElementById('error_id_mesa').innerHTML = '';

        var idMesa = document.getElementById('id_mesa').value;

        // Validar id de mesa
        if (idMesa.trim() === '') {
            document.getElementById('error_id_mesa').innerHTML = 'Ingrese el número de mesa.';
            return false;
        }

        // Puedes agregar más validaciones según tus requisitos

        return true;
    }
</script>
</body>
</html>
