<?php
include_once('./inc/conexion.php');

// Obtener la lista de mesas
$sqlSelectMesas = "SELECT * FROM tbl_mesa";
$stmtSelectMesas = $conn->prepare($sqlSelectMesas);
$stmtSelectMesas->execute();
$mesas = $stmtSelectMesas->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de sillas
$sqlSelectSillas = "SELECT * FROM tbl_silla";
$stmtSelectSillas = $conn->prepare($sqlSelectSillas);
$stmtSelectSillas->execute();
$sillas = $stmtSelectSillas->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de salas
$sqlSelectSalas = "SELECT * FROM tbl_sala";
$stmtSelectSalas = $conn->prepare($sqlSelectSalas);
$stmtSelectSalas->execute();
$salas = $stmtSelectSalas->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de ocupaciones
$sqlSelectOcupaciones = "SELECT * FROM tbl_ocupacion";
$stmtSelectOcupaciones = $conn->prepare($sqlSelectOcupaciones);
$stmtSelectOcupaciones->execute();
$ocupaciones = $stmtSelectOcupaciones->fetchAll(PDO::FETCH_ASSOC);

// Resto del código de obtener_crud.php

include_once("./inc/conexion.php");

// Operación de Mostrar Mesas
echo "<div>";
echo "<h2>Administrar Mesas</h2>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>ID Mesa</th>";
echo "<th>ID Sala</th>";
echo "<th>Capacidad</th>";
echo "<th>Acciones</th>";
echo "</tr>";

foreach ($mesas as $mesa) {
    echo "<tr>";
    echo "<td>{$mesa['id_mesa']}</td>";
    echo "<td>{$mesa['id_sala']}</td>";
    echo "<td>{$mesa['capacidad']}</td>";
    echo "<td>";
    echo "<button href='editar_mesa.php?id_mesa={$mesa['id_mesa']}'>Editar</button>";
    echo "<button onclick=\"confirmarEliminacionMesa({$mesa['id_mesa']})\">Eliminar</button>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "<br>";
echo "<br>";

echo "</div>";

echo "<h2>Administrar Sillas</h2>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>ID Silla</th>";
echo "<th>ID Mesa</th>";
echo "<th>Acciones</th>";
echo "</tr>";

foreach ($sillas as $silla) {
    echo "<tr>";
    echo "<td>{$silla['id_silla']}</td>";
    echo "<td>{$silla['id_mesa']}</td>";
    echo "<td>";
    echo "<button href='editar_silla.php?id_silla={$silla['id_silla']}'>Editar</button>";
    echo "<button onclick=\"confirmarEliminacionSilla({$silla['id_silla']})\">Eliminar</button>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "<br>";
echo "<br>";

// Operación de Mostrar Salas
echo "<h2>Administrar Salas</h2>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>ID Sala</th>";
echo "<th>Nombre</th>";
echo "<th>Tipo</th>";
echo "<th>Capacidad</th>";
echo "<th>Imagen</th>"; // Agregamos una nueva columna para la imagen
echo "<th>Acciones</th>";
echo "</tr>";

foreach ($salas as $sala) {
    echo "<tr>";
    echo "<td>{$sala['id_sala']}</td>";
    echo "<td>{$sala['nombre']}</td>";
    echo "<td>{$sala['tipo_sala']}</td>";
    echo "<td>{$sala['capacidad']}</td>";
    
    // Mostrar la imagen
    echo "<td>";
    if ($sala['imagen_contenido'] !== null) {
        $imagenBase64 = base64_encode($sala['imagen_contenido']);
        $imagenSrc = "data:{$sala['imagen_tipo']};base64,{$imagenBase64}";
        echo "<img src='{$imagenSrc}' alt='Imagen de la sala' style='max-width: 100px; max-height: 100px;'>";
    } else {
        echo "No hay imagen";
    }
    echo "</td>";
    
    echo "<td>";
    echo "<button href='editar_sala.php?id_sala={$sala['id_sala']}'>Editar</button>";
    echo "<button onclick=\"confirmarEliminacionSala({$sala['id_sala']})\">Eliminar</button>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";
?>
