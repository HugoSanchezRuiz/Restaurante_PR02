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

$id_camarero = 0;

for ($i = 1; $i <= $numero_maximo_camareros; $i++) {
    $nombre_camarero = 'camarero_' . $i;

    if ($usuario === $nombre_camarero) {
        $id_camarero = $i;
        break;
    }
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
        $stmtEstadoActual->execute([$mesa_id]);
        $resultEstadoActual = $stmtEstadoActual->fetch(PDO::FETCH_ASSOC);

        if ($resultEstadoActual) {
            $ocupada = $resultEstadoActual['ocupada'];

            // Invierte el estado de ocupación
            $nuevoEstado = !$ocupada;

            // Actualiza el estado de ocupación en la base de datos
            $sqlActualizarEstado = "UPDATE tbl_mesa SET ocupada = ? WHERE id_mesa = ?";
            $stmtActualizarEstado = $conn->prepare($sqlActualizarEstado);
            $stmtActualizarEstado->execute([$nuevoEstado, $mesa_id]);

            if ($stmtActualizarEstado) {
                // Si la mesa está ocupada, inserta una nueva fila en tbl_ocupacion con la fecha de inicio
                if ($nuevoEstado == 1) {
                    //$id_camarero = 1; // Reemplaza con el ID del camarero actual
                    $sqlInsertarOcupacion = "INSERT INTO tbl_ocupacion (id_mesa, id_camarero, fecha_inicio, fecha_fin) VALUES (?, ?, NOW(), NULL)";
                    $stmtInsertarOcupacion = $conn->prepare($sqlInsertarOcupacion);
                    $stmtInsertarOcupacion->execute([$mesa_id, $id_camarero]);

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
                    $stmtActualizarOcupacion->execute([$mesa_id]);

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

                // Agrega el script de SweetAlert para la notificación y redirección
                echo "
    <script>
        Swal.fire({
            title: 'Aceptado',
            text: 'Has entrado a la página principal',
            icon: 'success'
        }).then(() => {
            const usuario = '" . $usuarioRecibido . "';
            window.location.href = './mostrar_mesas.php?usuario=' + usuario;
        });
    </script>
";
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
        // header("Location: ./mostrar_mesas.php");
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
