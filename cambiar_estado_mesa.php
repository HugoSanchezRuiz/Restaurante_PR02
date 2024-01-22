<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
    html {
        background-color: #3a5f68;
        color: #3a5f68;
    }
</style>

<?php
session_start();

include_once("./inc/conexion.php");

$usuario = $_SESSION['usuario'];

$numero_maximo_camareros = 15; // Cambia esto según la cantidad máxima de camareros

//$id_camarero = 0;

for ($i = 1; $i <= $numero_maximo_camareros; $i++) {
    $nombre_camarero = 'camarero_' . $i;
}

if ($usuario === $nombre_camarero) {
    // Consulta SQL para obtener el ID del camarero
    $sqlObtenerIdCamarero = "SELECT id_usuario FROM tbl_usuario WHERE nombre_usuario = :nombre_camarero AND tipo_usuario = 'camarero'";
    $stmtObtenerIdCamarero = $conn->prepare($sqlObtenerIdCamarero);
    $stmtObtenerIdCamarero->bindParam(':nombre_camarero', $nombre_camarero);
    $stmtObtenerIdCamarero->execute();

    $id_camarero = $stmtObtenerIdCamarero->fetch(PDO::FETCH_ASSOC)['id_usuario'];
}

// Si no se encuentra el camarero, $id_camarero seguirá siendo 0

if (isset($_POST['mesa_id'])) {
    $mesa_id = $_POST['mesa_id'];

    try {
        // Inicia la conexión PDO
        include_once "./inc/conexion.php";

        // Inicia la transacción
        $conn->beginTransaction();

        // Consulta SQL para obtener el estado actual de ocupación de la mesa
        $sqlEstadoActual = "SELECT ocupada FROM tbl_mesa WHERE id_mesa = ?";
        $stmtEstadoActual = $conn->prepare($sqlEstadoActual);
        $stmtEstadoActual->bindParam(1, $mesa_id);
        $stmtEstadoActual->execute();
        $resultEstadoActual = $stmtEstadoActual->fetch(PDO::FETCH_ASSOC);


        if ($resultEstadoActual) {
            $ocupada = $resultEstadoActual['ocupada'];

            // Invierte el estado de ocupación
            $nuevoEstado = !$ocupada;

            // Actualiza el estado de ocupación en la base de datos
            $sqlActualizarEstado = "UPDATE tbl_mesa SET ocupada = ? WHERE id_mesa = ?";
            $stmtActualizarEstado = $conn->prepare($sqlActualizarEstado);
            $stmtActualizarEstado->bindParam(1, $nuevoEstado);
            $stmtActualizarEstado->bindParam(2, $mesa_id);
            $stmtActualizarEstado->execute();

            if ($stmtActualizarEstado) {
                // Si la mesa está ocupada, inserta una nueva fila en tbl_ocupacion con la fecha de inicio
                if ($nuevoEstado == 1) {
                    $sqlInsertarOcupacion = "INSERT INTO tbl_ocupacion (id_mesa, id_usuario, fecha_inicio, fecha_fin, es_reserva) VALUES (?, ?, NOW(), NULL, FALSE)";
                    $stmtInsertarOcupacion = $conn->prepare($sqlInsertarOcupacion);
                    $stmtInsertarOcupacion->bindParam(1, $mesa_id);
                    $stmtInsertarOcupacion->bindParam(2, $id_camarero);
                    $stmtInsertarOcupacion->execute();

                    if (!$stmtInsertarOcupacion) {
                        // Si hay un error en la inserción, realiza un rollback
                        $conn->rollBack();
                        echo "Error al insertar la ocupación de la mesa: " . $conn->errorInfo();
                        exit();
                    }
                } else {
                    // Si la mesa está desocupada, actualiza la fecha_fin en tbl_ocupacion
                    $sqlActualizarOcupacion = "UPDATE tbl_ocupacion SET fecha_fin = NOW() WHERE id_mesa = ? AND fecha_fin IS NULL";
                    $stmtActualizarOcupacion = $conn->prepare($sqlActualizarOcupacion);
                    $stmtActualizarOcupacion->bindParam(1, $mesa_id);
                    $stmtActualizarOcupacion->execute();

                    if (!$stmtActualizarOcupacion) {
                        // Si hay un error en la actualización, realiza un rollback
                        $conn->rollBack();
                        echo "Error al actualizar la ocupación de la mesa: " . $conn->errorInfo();
                        exit();
                    }
                }

                // Confirma la transacción
                $conn->commit();

                // Cierra la conexión
                $conn = null;


            } else {
                // Si hay un error en la actualización, realiza un rollback (deshace todos los cambios hechos)
                $conn->rollBack();
                echo "Error al actualizar el estado de la mesa: " . $conn->errorInfo();
            }
        } else {
            echo "Error al obtener el estado actual de la mesa: " . $conn->errorInfo();
        }

        // Cierra la conexión
        $conn = null;

        // Redirige de nuevo a la página anterior
        header("Location: ./mostrar_mesas.php");
        // exit();
    } catch (PDOException $e) {
        // Manejo de excepciones
        echo "Excepción: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este archivo de manera incorrecta, redirige a la página principal
    // header("Location: ./index.php");
    echo "cambio no realizado";
    exit();
}
?>
