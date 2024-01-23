<?php
session_start();
include_once("./inc/conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ./formulario.php'); // Redirige a la página de inicio de sesión
    exit();
}

$usuario = $_SESSION['usuario'];

// Realizar una consulta para obtener el ID del usuario por nombre
$query = "SELECT id_usuario FROM tbl_usuario WHERE nombre_usuario = :nombre";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nombre', $usuario, PDO::PARAM_STR);
$stmt->execute();

// Verificar si la consulta fue exitosa
if ($stmt) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_camarero = $row['id_usuario'];

} else {
    // Manejar el error según sea necesario
    die("Error al obtener el ID del usuario: " . $pdo->errorInfo()[2]);
}

// Si no se encuentra el camarero, $id_camarero seguirá siendo 0

$area = isset($_GET['area']) ? $_GET['area'] : null;
$table = isset($_GET['table']) ? $_GET['table'] : null;
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $(".comedor_opciones, .sala_opciones, .terraza_opciones").hide();

        <?php
        // Use the values of $area and $table to determine which options to show
        if ($area == 'terraza') {
            echo '$(".terraza_opciones").show(); $(".comedor_opciones, .sala_opciones").hide();';
        } elseif ($area == 'comedor') {
            echo '$(".comedor_opciones").show(); $(".terraza_opciones, .sala_opciones").hide();';
        } elseif ($area == 'sala') {
            echo '$(".sala_opciones").show(); $(".terraza_opciones, .comedor_opciones").hide();';
        }
        ?>
    });
</script>

<header>
    <div>
        <a href="./mostrar_mesas.php"><img id="logo" src="./src/LOGO3.png" alt="logo"></a>
    </div>
    <div class="responsive-header">
        <form method="get" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='terraza'>
            <input type='submit' name='table' value="Terrazas" class="secciones-secund">
        </form>
        <form method="get" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='comedor'>
            <input type='submit' name='table' value="Comedores" class="secciones-secund">
        </form>
        <form method="get" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='table' value="Salas Privadas" class="secciones-secund">
        </form>
        <a href="./estadisticas.php" class="secciones">
            <p class="extras">Estadísticas</p>
        </a>
        <a href="./cerrar_sesion.php" class="secciones">
            <p type="submit" name="cerrar_sesion" class="extras">Cerrar sesión</p>
        </a>
    </div>
    <hr class="hr-header">
    <!-- TERRAZAS -->
    <div class="flex terraza_opciones salas ">
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='terraza'>
            <input type='submit' name='terraza_1' value="Terraza 1" class="secciones-secund">
        </form>

        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='terraza'>
            <input type='submit' name='terraza_2' value="Terraza 2" class="secciones-secund">
        </form>

        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='terraza'>
            <input type='submit' name='terraza_3' value="Terraza 3" class="secciones-secund">
        </form>

        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='terraza'>
            <input type='submit' name='terraza_4' value="Terraza 4  " class="secciones-secund">
        </form>
    </div>
    <!-- COMEDOR -->
    <div class=' flex comedor_opciones salas '>
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='comedor_1' value="Comedor 1" class="secciones-secund">
        </form>
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='comedor_2' value="Comedor 2" class="secciones-secund">
        </form>
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='comedor_3' value="Comedor 3" class="secciones-secund">
        </form>
    </div>
    <!-- SALA -->
    <div class=' flex sala_opciones salas '>
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='sala_privada_1' value="Sala Privada 1" class="secciones-secund">
        </form>
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='sala_privada_2' value="Sala Privada 2" class="secciones-secund">
        </form>
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='sala_privada_3' value="Sala Privada 3" class="secciones-secund">
        </form>
        <form method="post" action="mostrar_mesas.php">
            <input type='hidden' name='area' value='sala'>
            <input type='submit' name='sala_privada_4' value="Sala Privada 4" class="secciones-secund">
        </form>
    </div>
    <hr class="hr-header">
    <div>
        <a href="./reserva.php?usuario=<?php echo $usuario; ?>">Reservar</a>
        <a href="./ver_reservas.php">Ver reservas</a>
    </div>
</header>

<?php
// Función para mostrar las mesas ocupadas por los camareros que más mesas han ocupado
function mostrarCamarerosOrdenadosPorMesas($pdo)
{
    try {
        // Consulta SQL para mostrar los camareros ordenados por la cantidad de mesas que han ocupado
        $sqlCamareros = "
        SELECT
        c.nombre_usuario as nombre_camarero,
        COUNT(o.id_mesa) as num_mesas_ocupadas,
        GROUP_CONCAT(o.id_mesa ORDER BY o.id_mesa) as mesas_ocupadas_ids,
        GROUP_CONCAT(o.num_veces_ocupada ORDER BY o.id_mesa) as veces_ocupada,
        GROUP_CONCAT(o.id_ocupacion ORDER BY o.fecha_inicio) as ocupacion_ids,
        GROUP_CONCAT(DISTINCT o.fecha_inicio ORDER BY o.fecha_inicio) as fechas_inicio
    FROM tbl_usuario c
    LEFT JOIN (
        SELECT
            o.id_usuario,
            o.id_mesa,
            COUNT(*) as num_veces_ocupada,
            GROUP_CONCAT(o.id_ocupacion) as id_ocupacion,
            GROUP_CONCAT(o.fecha_inicio ORDER BY o.fecha_inicio) as fecha_inicio
        FROM tbl_ocupacion o
        GROUP BY o.id_usuario, o.id_mesa
    ) o ON c.id_usuario = o.id_usuario
    WHERE c.tipo_usuario = 'camarero'
    GROUP BY c.id_usuario
    ORDER BY num_mesas_ocupadas DESC;
    
        ";

        $stmtCamareros = $pdo->prepare($sqlCamareros);
        $stmtCamareros->execute();
        $resultCamareros = $stmtCamareros->fetchAll(PDO::FETCH_ASSOC);

        if ($resultCamareros) {
            foreach ($resultCamareros as $row) {
                echo "<p>------------------------</p>";
                echo "<p>Camarero: " . $row['nombre_camarero'] . " - Mesas Ocupadas: " . $row['num_mesas_ocupadas'] . "</p>";

                if ($row['num_mesas_ocupadas'] > 0) {
                    echo "<p>Mesas Ocupadas:</p>";

                    $mesasIds = explode(",", $row['mesas_ocupadas_ids']);
                    $vecesOcupada = explode(",", $row['veces_ocupada']);
                    $fechasInicio = explode(",", $row['fechas_inicio']);

                    $totalVecesOcupadas = 0;

                    for ($i = 0; $i < count($mesasIds); $i++) {
                        if ($mesasIds[$i] != null && $vecesOcupada[$i] != null) {
                            echo "Mesa " . $mesasIds[$i] . " - Veces Ocupada: " . $vecesOcupada[$i];
                            $totalVecesOcupadas += $vecesOcupada[$i];

                            // Si la mesa se ha ocupado más de una vez, mostrar las fechas correspondientes
                            if ($vecesOcupada[$i] > 1) {
                                echo "<ul>";
                                for ($j = 0; $j < $vecesOcupada[$i]; $j++) {
                                    echo "<li>Ocupación " . ($j + 1) . ": " . $fechasInicio[$i * $vecesOcupada[$i] + $j] . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                if ($fechasInicio[$i] != null) {
                                    echo " - Fecha Inicio: " . $fechasInicio[$i];
                                    echo "<br>";
                                }
                            }

                            echo "<br>";
                            echo "<br>";
                        }
                    }
                    echo "Total ocupaciones: " . $totalVecesOcupadas;
                }
            }
        } else {
            echo "<p>No hay resultados.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Iniciar sesión
// session_start();

// Establecer valores predeterminados para los filtros si no están configurados
if (!isset($_SESSION['capacidadFiltro'])) {
    $_SESSION['capacidadFiltro'] = null;
}

if (!isset($_SESSION['fechaFiltro'])) {
    $_SESSION['fechaFiltro'] = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['capacidadFiltro'])) {
        $_SESSION['capacidadFiltro'] = $_POST['capacidadFiltro'];
    }
    if (isset($_POST['fechaFiltro'])) {
        $_SESSION['fechaFiltro'] = $_POST['fechaFiltro'];
    }
}

function filtrarMesasPorCapacidad($pdo, $capacidadFiltro)
{
    try {
        // Consulta SQL para filtrar mesas por capacidad
        $sqlFiltro = "
            SELECT m.id_mesa, m.capacidad, s.nombre as sala_nombre 
            FROM tbl_mesa m 
            INNER JOIN tbl_sala s ON m.id_sala = s.id_sala 
            WHERE m.capacidad = :capacidadFiltro AND m.ocupada = 0 
            ORDER BY m.capacidad
        ";

        $stmtFiltro = $pdo->prepare($sqlFiltro);
        $stmtFiltro->bindParam(':capacidadFiltro', $capacidadFiltro, PDO::PARAM_INT);
        $stmtFiltro->execute();
        $resultFiltro = $stmtFiltro->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Filtradas por capacidad: $capacidadFiltro personas</h2>";
        if ($resultFiltro) {
            foreach ($resultFiltro as $row) {
                echo "<p>Mesa: " . $row['id_mesa'] . " - Capacidad: " . $row['capacidad'] . " - Sala: " . $row['sala_nombre'] . "</p>";
            }
        } else {
            echo "<br>";
            echo "<p>No hay mesas disponibles con la capacidad seleccionada.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function filtrarMesasPorFecha($pdo, $fechaFiltro)
{
    try {
        // Consulta SQL para filtrar mesas por fecha
        $sqlFiltroFecha = "
            SELECT m.id_mesa, s.nombre AS nombre_sala, o.fecha_inicio, o.fecha_fin
            FROM tbl_ocupacion o
            JOIN tbl_mesa m ON o.id_mesa = m.id_mesa
            JOIN tbl_sala s ON m.id_sala = s.id_sala
            WHERE  o.fecha_fin IS NOT NULL AND DATE (o.fecha_inicio) = :fechaFiltro
            ORDER BY o.fecha_inicio
        ";

        $stmtFiltroFecha = $pdo->prepare($sqlFiltroFecha);
        $stmtFiltroFecha->bindParam(':fechaFiltro', $fechaFiltro, PDO::PARAM_STR);
        $stmtFiltroFecha->execute();
        $resultFiltroFecha = $stmtFiltroFecha->fetchAll(PDO::FETCH_ASSOC);

        echo "<br>";
        echo "<h4>$fechaFiltro</h4>";
        if ($resultFiltroFecha) {
            foreach ($resultFiltroFecha as $row) {
                echo "<br>";
                echo "ID Mesa: " . $row["id_mesa"] . "<br>";
                echo "Sala: " . $row["nombre_sala"] . "<br>";
                echo "Fecha Inicio: " . $row["fecha_inicio"] . "<br>";
                echo "Fecha Fin: " . $row["fecha_fin"] . "<br>";
            }
        } else {
            echo "<p>No hay ocupaciones de mesas en la fecha seleccionada.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/home.css">
    <script>
        function toggleFilter(filterId) {
            var filter = document.getElementById(filterId);
            filter.classList.toggle("hidden");
            filter.classList.toggle("visible");
        }
    </script>
</head>

<body>
    <div class="row flex">
        <div id="restaurante">

            <?php
            function mostrarMesas($nombreSala, $pdo)
            {
                try {
                    $pdo->beginTransaction();

                    $sqlSala = "SELECT
                        ms.id_mesa,
                        ms.capacidad,
                        ms.ocupada
                    FROM
                        tbl_mesa ms
                    JOIN
                        tbl_sala sl ON ms.id_sala = sl.id_sala
                    WHERE
                        sl.nombre = :nombreSala";

                    $stmtSala = $pdo->prepare($sqlSala);
                    $stmtSala->bindParam(':nombreSala', $nombreSala, PDO::PARAM_STR);

                    if (!$stmtSala->execute()) {
                        throw new Exception("Error al ejecutar la consulta");
                    }

                    $resultSala = $stmtSala->fetchAll(PDO::FETCH_ASSOC);

                    if ($resultSala === false) {
                        throw new Exception("Error al obtener los resultados de la consulta");
                    }

                    $numMesas = count($resultSala);
                    $claseFormulario = '';

                    if ($numMesas == 2) {
                        $claseFormulario = 'dos-mesas';
                    } elseif ($numMesas == 4) {
                        $claseFormulario = 'cuatro-mesas';
                    } elseif ($numMesas == 6) {
                        $claseFormulario = 'seis-mesas';
                    }

                    echo "<h2 class='migadepan'>Mesas de $nombreSala</h2>";
                    echo "<form method='post' action='cambiar_estado_mesa.php?usuario=" . $_SESSION['usuario'] . "' class='sala-distribucion $claseFormulario'>";

                    foreach ($resultSala as $row) {
                        echo "<button type='submit' name='mesa_id' value='" . $row['id_mesa'] . "' ";
                        echo "class='mesa-" . $row['capacidad'];

                        if ($row['ocupada']) {
                            echo "-ocupada";
                        }

                        echo " mesa-fondo";
                        echo "'>";
                        echo "</button>";
                    }

                    echo "</form>";
                    $pdo->commit();
                } catch (Exception $e) {
                    $pdo->rollBack();
                    echo "Error: " . $e->getMessage();
                }
            }


            if (isset($_POST['terraza_1'])) {
                mostrarMesas('terraza_1', $conn);
            } elseif (isset($_POST['terraza_2'])) {
                mostrarMesas('terraza_2', $conn);
            } elseif (isset($_POST['terraza_3'])) {
                mostrarMesas('terraza_3', $conn);
            } elseif (isset($_POST['terraza_4'])) {
                mostrarMesas('terraza_4', $conn);
            } elseif (isset($_POST['comedor_1'])) {
                mostrarMesas('comedor_1', $conn);
            } elseif (isset($_POST['comedor_2'])) {
                mostrarMesas('comedor_2', $conn);
            } elseif (isset($_POST['comedor_3'])) {
                mostrarMesas('comedor_3', $conn);
            } elseif (isset($_POST['sala_privada_1'])) {
                mostrarMesas('sala_privada_1', $conn);
            } elseif (isset($_POST['sala_privada_2'])) {
                mostrarMesas('sala_privada_2', $conn);
            } elseif (isset($_POST['sala_privada_3'])) {
                mostrarMesas('sala_privada_3', $conn);
            } elseif (isset($_POST['sala_privada_4'])) {
                mostrarMesas('sala_privada_4', $conn);
            } else {
                // Redirigir o manejar de alguna manera si se accede a esta página de manera incorrecta
                // header("Location: ./home.php");
                // header("Location: mostrar_mesas.php");
                // exit();
            }
            ?>

        </div>
    </div>
    <div id="filtro">
        <div class="filtros-separaciones">
            <div class="margen-1">
                <h2 class="filtro-margin-top">Mesas Disponibles</h2>
                <form action="mostrar_mesas.php" method="post">
                    <select name="capacidadFiltro" class="select-personas">
                        <option disabled selected>Selecciona opción</option>
                        <option value="2">2 personas</option>
                        <option value="3">3 personas</option>
                        <option value="4">4 personas</option>
                        <option value="6">6 personas</option>
                        <option value="8">8 personas</option>
                        <option value="10">10 personas</option>
                        <option value="15">15 personas</option>
                    </select>
                    <input class="aceptar-select-personas" type="submit" value="Enviar">
                </form>
                <div class="margen-2-primera">
                    <div class="visible" id="capacidadFilter">
                        <?php
                        if (isset($_SESSION['capacidadFiltro'])) {
                            try {
                                $capacidadFiltro = $_SESSION['capacidadFiltro'];
                                echo "<div id='capacidadFilter' class='visible'>";
                                filtrarMesasPorCapacidad($conn, $capacidadFiltro);
                                echo "</div>";
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <button class="botones-ocultar" onclick="toggleFilter('capacidadFilter')">Mostrar/Ocultar Filtro de Capacidad</button>
        </div>

        <div class="filtros-separaciones">
            <div class="margen-1">
                <h2 class="filtro-margin-top">Camareros</h2>
                <h4>(Ordenados por la cantidad de mesas ocupadas)</h4>
                <br>
                <div class="margen-2-segunda">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Solo asignar las variables de sesión si el formulario ha sido enviado
                        if (isset($_POST['capacidadFiltro'])) {
                            $_SESSION['capacidadFiltro'] = $_POST['capacidadFiltro'];
                        }
                        if (isset($_POST['fechaFiltro'])) {
                            $_SESSION['fechaFiltro'] = $_POST['fechaFiltro'];
                        }
                    }

                    echo "<div id='camareroFilter' class='visible'>";
                    try {
                        mostrarCamarerosOrdenadosPorMesas($conn);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    echo "</div>";
                    ?>
                </div>
            </div>
            <button class="botones-ocultar" onclick="toggleFilter('camareroFilter')">Mostrar/Ocultar Filtro de Camareros</button>
        </div>
    </div>

    <div id="historial">
        <div class="filtros-separaciones">
            <div class="margen-1">
                <div class="historial">
                    <h2 class="filtro-margin-top">Historial</h2>
                    <div class="margen-2-tercera">
                        <?php
                        try {
                            $sqlHistorial = "SELECT
                            m.id_mesa,
                            s.nombre AS nombre_sala,
                            o.fecha_inicio,
                            o.fecha_fin
                        FROM
                            tbl_ocupacion o
                            JOIN tbl_mesa m ON o.id_mesa = m.id_mesa
                            JOIN tbl_sala s ON m.id_sala = s.id_sala
                        WHERE
                            o.fecha_fin IS NOT NULL
                        ORDER BY
                            o.fecha_inicio";

                            // Ejecutar la consulta
                            $resultHistorial = $conn->query($sqlHistorial);

                            // Verificar si se obtuvieron resultados
                            if ($resultHistorial->rowCount() > 0) {
                                // Mostrar los resultados
                                foreach ($resultHistorial as $row) {
                                    echo "ID Mesa: " . $row["id_mesa"] . "<br>";
                                    echo "Sala: " . $row["nombre_sala"] . "<br>";
                                    echo "Fecha Inicio: " . $row["fecha_inicio"] . "<br>";
                                    echo "Fecha Fin: " . $row["fecha_fin"] . "<br>";
                                    echo "<br>";
                                }
                            } else {
                                echo "No se encontraron resultados";
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="filtros-separaciones">
            <div class="margen-1">
                <h2 class="filtro-margin-top">Historial por fecha</h2>
                <form action="mostrar_mesas.php" method="post" onsubmit="return validar_fecha()">
                    <input class="select-fecha" type="date" id="fecha" name="fechaFiltro">
                    <input class="aceptar-select-fecha" type="submit" value="Filtrar">
                    <span id="error_fecha"></span>
                </form>
                <div class="margen-2-cuarta">
                    <?php
                    if (isset($_SESSION['fechaFiltro'])) {
                        try {
                            echo "<div id='fechaFilter' class='visible'>";
                            filtrarMesasPorFecha($conn, $_SESSION['fechaFiltro']);
                            echo "</div>";
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    }
                    $conn = null; // Cerrar la conexión PDO
                    ?>
                </div>
            </div>
            <button class="botones-ocultar" onclick="toggleFilter('fechaFilter')">Mostrar/Ocultar Filtro por Fecha</button><br>
        </div>
    </div>
    </div>
</body>

</html>