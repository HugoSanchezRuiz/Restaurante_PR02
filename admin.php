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

// Obtener la lista de reservas
$sqlSelectReservas = "SELECT * FROM tbl_ocupacion";
$stmtSelectReservas = $conn->prepare($sqlSelectReservas);
$stmtSelectReservas->execute();
$reservas = $stmtSelectReservas->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            place-items: center;
            background: #0d2b33;
        }


        #container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            align-items: center;
            justify-content: center;
            margin: auto;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            color: #333;
        }

        .button {
            display: inline-block;
            background-color: #0d2b33;
            color: white;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            margin: 5px;
        }

        .button:hover {
            background: #0d2b33;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            color: #333;
        }

        a {
            display: inline-block;
            margin-bottom: 10px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

        #crudSection {
            max-width: 800px;
            margin: 20px auto;
        }

        .user-item {
            background-color: #0d2b33;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .usuario-container {
            display: flex;
            align-items: center;
        }
        

        .btn-container {
            margin-left: 10px;
        }

        button {
            cursor: pointer;
            padding: 10px 15px;
            margin-right: 5px;
            background-color: #0d2b33;
            color: white;
            border: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0d2b33;
        }

        #updateFormContainer {
            max-width: 400px;
            margin-top: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input,
        select {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #0d2b33;
            color: white;
        }

        input[type="submit"] {
            background-color: #0d2b33;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #0d2b33;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="container">

        <h3>Página de Administración</h3>
        <button id="verUsuarios" class="button">Ver usuarios</button>
        <button id="recurso" class="button">Ver recursos</button>
        <button id="insertar" class="button">Insertar Usuario</button>
        <button id="insertarM" class="button">Insertar Mesa</button>
        <button id="insertarS" class="button">Insertar Silla</button>
        <button id="insertarSL" class="button">Insertar Sala</button>

        <div id="formInsertar">
            <h3>Insertar Usuario</h3>
            <form method="post" id="formI">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" name="nombre_usuario" required>
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" required>
                <label for="tipo_usuario">Tipo de Usuario:</label>
                <select name="tipo_usuario" required>
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="admin">Admin</option>
                    <option value="gerente">Gerente</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="camarero">Camarero</option>
                </select>
                <br>
                <br>
                <input type="submit" name="insertar" id="insertarB" value="Insertar Usuario">
            </form>
        </div>
        <div id="formInsertarMesa">
            <h3>Insertar Mesa</h3>
            <form method="post" id="formM">
                <label for="id_sala">Número Sala:</label>
                <input type="text" name="id_sala" required>
                <label for="capacidad">Capacidad:</label>
                <input type="text" name="capacidad" required>
                <br>
                <br>
                <input type="submit" name="insertarM" id="insertarBMesa" value="Insertar Mesa">
            </form>
        </div>

        <div id="formInsertarSilla">
            <h3>Insertar Silla</h3>
            <form method="post" id="formS">
                <label for="id_mesa">Número de Mesa:</label>
                <input type="text" name="id_mesa" required>
                <br>
                <br>
                <input type="submit" name="insertarS" id="insertarBSilla" value="Insertar Silla">
            </form>
        </div>

        <div id="formInsertarSala">
            <h3>Insertar Sala</h3>
            <form method="post" id="formSL">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>
                <label for="tipo_sala">Tipo de Sala:</label>
                <select name="tipo_sala" required>
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="comedor">comedor</option>
                    <option value="terraza">terraza</option>
                    <option value="privada">privada</option>
                </select>
                <label for="capacidad">Capacidad:</label>
                <input type="text" name="capacidad" required>
                <br>
                <br>
                <input type="submit" name="insertarSala" id="insertarBSala" value="Insertar Sala">
            </form>
        </div>
        <div id="crudUsuarios"></div>
        <div id="updateFormContainer"></div>
        <div id="insertFormContainer"></div>

        <div id="crudRecursos">
            <h2>Administrar Mesas</h2>

            <table border="1">
                <tr>
                    <th>ID Mesa</th>
                    <th>ID Sala</th>
                    <th>Capacidad</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($mesas as $mesa) : ?>
                    <tr>
                        <td><?= $mesa['id_mesa'] ?></td>
                        <td><?= $mesa['id_sala'] ?></td>
                        <td><?= $mesa['capacidad'] ?></td>
                        <td>
                            <button href="editar_mesa.php?id_mesa=<?= $mesa['id_mesa'] ?>">Editar</button>
                            <button onclick="confirmarEliminacionMesa(<?= $silla['id_mesa'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <br>

            <h2>Administrar Sillas</h2>

            <table border="1">
                <tr>
                    <th>ID Silla</th>
                    <th>ID Mesa</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($sillas as $silla) : ?>
                    <tr>
                        <td><?= $silla['id_silla'] ?></td>
                        <td><?= $silla['id_mesa'] ?></td>
                        <td>
                            <button href="editar_silla.php?id_silla=<?= $silla['id_silla'] ?>">Editar</button>
                            <button onclick="confirmarEliminacionSilla(<?= $silla['id_silla'] ?>)">Eliminar</button>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <br>

            <h2>Administrar Salas</h2>

            <table border="1">
                <tr>
                    <th>ID Sala</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Capacidad</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($salas as $sala) : ?>
                    <tr>
                        <td><?= $sala['id_sala'] ?></td>
                        <td><?= $sala['nombre'] ?></td>
                        <td><?= $sala['tipo_sala'] ?></td>
                        <td><?= $sala['capacidad'] ?></td>
                        <td>
                            <button href="editar_sala.php?id_sala=<?= $sala['id_sala'] ?>">Editar</button>
                            <button onclick="confirmarEliminacionSala(<?= $silla['id_sala'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <br>

            <h2>Administrar Reservas/Ocupaciones</h2>

            <table border="1">
                <tr>
                    <th>ID Reserva</th>
                    <th>ID Mesa</th>
                    <th>ID Usuario</th>
                    <th>ID Silla</th>
                    <th>Fecha Reserva</th>
                    <th>Hora Reserva</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Es Reserva</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($reservas as $reserva) : ?>
                    <tr>
                        <td><?= $reserva['id_ocupacion'] ?></td>
                        <td><?= $reserva['id_mesa'] ?></td>
                        <td><?= $reserva['id_usuario'] ?></td>
                        <td><?= $reserva['id_silla'] ?></td>
                        <td><?= $reserva['fecha_reserva'] ?></td>
                        <td><?= $reserva['hora_reserva'] ?></td>
                        <td><?= $reserva['fecha_inicio'] ?></td>
                        <td><?= $reserva['fecha_fin'] ?></td>
                        <td><?= $reserva['es_reserva'] ? 'Sí' : 'No' ?></td>
                        <td>
                            <button href="editar_reserva.php?id_reserva=<?= $reserva['id_ocupacion'] ?>">Editar</button>
                            <button href="borrar_reserva.php?id_reserva=<?= $reserva['id_ocupacion'] ?>">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>




        <a href="./index.php" class="button">Volver Login</a>
    </div>

    <script>
        /////// MOSTRAR CONTENIDOS

        // Llamar a la función para mostrar el CRUD al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            // Mostrar el CRUD de usuarios al cargar la página
            mostrarCRUDUsuarios();
            ocultarElemento("crudRecursos");
            ocultarElemento("formInsertar");
            ocultarElemento("formInsertarMesa");
            ocultarElemento("formInsertarSilla");
            ocultarElemento("formInsertarSala");

            ///// INSERTAR UUSUARIO

            document.getElementById("insertarB").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                var form = document.getElementById("formI");
                var formData = new FormData(form);

                // Realizar la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // Éxito al insertar el usuario
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario Insertado',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            // Puedes realizar acciones adicionales si es necesario
                        } else {
                            // Error al insertar el usuario
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al Insertar Usuario',
                                text: xhr.responseText
                            });
                        }
                    }
                };

                xhr.open("POST", "insertar_usuario.php", true); // Reemplaza "insertar_usuario.php" con la ruta correcta
                xhr.send(formData);
            });

            ///// INSERTAR MESA
            document.getElementById("insertarBMesa").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                var form = document.getElementById("formM");
                var formData = new FormData(form);

                // Realizar la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // Éxito al insertar el usuario
                            Swal.fire({
                                icon: 'success',
                                title: 'Mesa Insertada',
                                showConfirmButton: true,
                                timer: 5000
                            });
                            // Puedes realizar acciones adicionales si es necesario
                        } else {
                            // Error al insertar el usuario
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al Insertar Mesa',
                                text: xhr.responseText
                            });
                        }
                    }
                };

                xhr.open("POST", "insertar_mesas.php", true);
                xhr.send(formData);
            });

            ///// INSERTAR SILLA
            document.getElementById("insertarBSilla").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                var form = document.getElementById("formS");
                var formData = new FormData(form);

                // Realizar la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // Éxito al insertar el usuario
                            Swal.fire({
                                icon: 'success',
                                title: 'Silla Insertada',
                                showConfirmButton: true,
                                timer: 5000
                            });
                            // Puedes realizar acciones adicionales si es necesario
                        } else {
                            // Error al insertar el usuario
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al Insertar Silla',
                                text: xhr.responseText
                            });
                        }
                    }
                };

                xhr.open("POST", "insertar_silla.php", true);
                xhr.send(formData);
            });

            ///// INSERTAR SALA
            document.getElementById("insertarBSala").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                var form = document.getElementById("formSL");
                var formData = new FormData(form);

                // Realizar la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // Éxito al insertar el usuario
                            Swal.fire({
                                icon: 'success',
                                title: 'Sala Insertada',
                                showConfirmButton: true,
                                timer: 5000
                            });
                            // Puedes realizar acciones adicionales si es necesario
                        } else {
                            // Error al insertar el usuario
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al Insertar Sala',
                                text: xhr.responseText
                            });
                        }
                    }
                };

                xhr.open("POST", "insertar_sala.php", true);
                xhr.send(formData);
            });

            ////// ACTUALIZAR


            document.getElementById("actualizarB").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                var form = document.querySelector("form");
                var formData = new FormData(form);

                // Realizar la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            // Éxito al actualizar el usuario
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario Actualizado',
                                showConfirmButton: true,
                                timer: 5000
                            });
                            // Puedes realizar acciones adicionales si es necesario
                        } else {
                            // Error al actualizar el usuario
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al Actualizar Usuario',
                                text: xhr.responseText
                            });
                        }
                    }
                };

                xhr.open("POST", "actualizar_usuario.php", true); // Reemplaza "actualizar_usuario.php" con la ruta correcta
                xhr.send(formData);
            });
        });

        //ACTUALIZAR MOSTRAR
        function mostrarFormularioActualizacion(idUsuario) {
            var updateFormContainer = document.getElementById("updateFormContainer");

            // Realizar una solicitud AJAX para obtener el contenido del formulario de actualización
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Colocar el contenido en el contenedor
                    updateFormContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "mostrar_formulario_actualizar.php?id=" + idUsuario, true); // Reemplaza "obtener_formulario_actualizacion.php" con la ruta correcta
            xhr.send();
        }

        document.getElementById("verUsuarios").addEventListener("click", function() {
            // Mostrar el CRUD de usuarios
            mostrarCRUDUsuarios();
            // Mostrar el CRUD de recursos
            mostrarElemento("crudUsuarios");
            // Ocultar el CRUD de recursos y el formulario de insertar
            ocultarElemento("crudRecursos");
            ocultarElemento("formInsertar");
            ocultarElemento("formInsertarMesa");
            ocultarElemento("formInsertarSilla");
            ocultarElemento("formInsertarSala");
        });

        document.getElementById("insertarM").addEventListener("click", function(event) {
            event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

            ocultarElemento("crudUsuarios");
            ocultarElemento("crudRecursos");
            ocultarElemento("formInsertar");
            ocultarElemento("formInsertarSilla");
            ocultarElemento("formInsertarSala");

            // Mostrar el form de mesa
            mostrarElemento("formInsertarMesa");
        });

        document.getElementById("recurso").addEventListener("click", function() {
            // Ocultar el CRUD de usuarios y el formulario de insertar
            ocultarElemento("crudUsuarios");
            ocultarElemento("formInsertar");
            ocultarElemento("formInsertarMesa");
            ocultarElemento("formInsertarSilla");
            ocultarElemento("formInsertarSala");

            // Mostrar el CRUD de recursos
            mostrarElemento("crudRecursos");
        });

        document.getElementById("insertar").addEventListener("click", function() {
            // Ocultar el CRUD de usuarios y el CRUD de recursos
            ocultarElemento("crudUsuarios");
            ocultarElemento("crudRecursos");
            ocultarElemento("formInsertarMesa");
            ocultarElemento("formInsertarSilla");
            ocultarElemento("formInsertarSala");

            // Mostrar el formulario de insertar
            mostrarElemento("formInsertar");
        });

        document.getElementById("insertarS").addEventListener("click", function() {
            // Mostrar el CRUD de usuarios
            mostrarCRUDUsuarios();
            // Mostrar el CRUD de recursos
            mostrarElemento("formInsertarSilla");
            // Ocultar el CRUD de recursos y el formulario de insertar
            ocultarElemento("crudUsuarios");
            ocultarElemento("crudRecursos");
            ocultarElemento("formInsertar");
            ocultarElemento("formInsertarMesa");
            ocultarElemento("formInsertarSala");
        });

        document.getElementById("insertarSL").addEventListener("click", function() {
            // Mostrar el CRUD de usuarios
            mostrarCRUDUsuarios();
            // Mostrar el CRUD de recursos
            mostrarElemento("formInsertarSala");
            // Ocultar el CRUD de recursos y el formulario de insertar
            ocultarElemento("crudUsuarios");
            ocultarElemento("crudRecursos");
            ocultarElemento("formInsertar");
            ocultarElemento("formInsertarMesa");
            ocultarElemento("formInsertarSilla");
        });

        // Función para ocultar un elemento por su ID
        function ocultarElemento(id) {
            var elemento = document.getElementById(id);
            if (elemento) {
                elemento.style.display = "none";
            }
        }

        // Función para mostrar un elemento por su ID
        function mostrarElemento(id) {
            var elemento = document.getElementById(id);
            if (elemento) {
                elemento.style.display = "block";
            }
        }


        ////////////// ELIMINAR
        function confirmarEliminacionUsuario(idUsuario) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará el usuario id: " + idUsuario,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Llamada Ajax para eliminar el usuario
                    eliminarUsuarioAjax(idUsuario);
                }
            });
        }

        function confirmarEliminacionMesa(idMesa) {
            console.log("Confirmar eliminación de mesa");
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la mesa con id: " + idMesa,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, elimina'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarMesaAjax(idMesa);
                }
            });
        }

        function confirmarEliminacionSala(idSala) {
            console.log("Confirmar eliminación de sala");
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la sala con id: " + idSala,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, elimina'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarSalaAjax(idSala);
                }
            });
        }

        function confirmarEliminacionSilla(idSilla) {
            console.log("Confirmar eliminación de silla");
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la silla con id: " + idSilla,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, elimina'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarSillaAjax(idSilla);
                }
            });
        }

        function eliminarUsuarioAjax(idUsuario) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualizar la página después de eliminar el usuario cada 1 segundo
                    setInterval(function() {
                        mostrarCRUDUsuarios();
                    }, 1000);
                }
            };
            xhr.open("GET", "borrar_usuario.php?id_usuario=" + idUsuario, true);
            xhr.send();
        }

        function eliminarMesaAjax(idMesa) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualizar la página después de eliminar el usuario cada 1 segundo
                    setInterval(function() {
                        window.location.reload();
                    }, 1000);
                }
            };
            xhr.open("GET", "borrar_mesa.php?id_mesa=" + idMesa, true);
            xhr.send();
        }

        function eliminarSillaAjax(idSilla) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualizar la página después de eliminar el usuario cada 1 segundo
                    setInterval(function() {
                        mostrarCRUDUsuarios();
                    }, 1000);
                }
            };
            xhr.open("GET", "borrar_silla.php?id_silla=" + idSilla, true);
            xhr.send();
        }

        function eliminarSalaAjax(idSala) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualizar la página después de eliminar el usuario cada 1 segundo
                    setInterval(function() {
                        window.location.reload();
                    }, 1000);
                }
            };
            xhr.open("GET", "borrar_sala.php?id_sala=" + idSala, true);
            xhr.send();
        }

        // Nueva función para actualizar dinámicamente los datos en el CRUD var // idUsuario = <php echo $datosUsuario['id_usuario']; ?>;
        function actualizarUsuarioEnCRUD(datosActualizados) {
            var idUsuario = datosActualizados.id;
            var nombreUsuario = datosActualizados.nombre;
            var tipoUsuario = datosActualizados.tipo;
            var contrasena = datosActualizados.contrasena;

            // Asignar los valores a los campos del formulario
            document.getElementsByName("id_usuario")[0].value = idUsuario;
            document.getElementsByName("nombre_usuario")[0].value = nombreUsuario;
            document.getElementsByName("tipo_usuario")[0].value = tipoUsuario;
            document.getElementsByName("contrasena")[0].value = contrasena;

            // Realizar una solicitud AJAX para actualizar dinámicamente los datos en el CRUD
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    print("Hola");
                }
            };
            // var datosActualizados = JSON.parse(xhr.responseText);
            // actualizarUsuarioEnCRUD(datosActualizados);
            xhr.open("POST", "actualizar_usuario.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id=" + idUsuario + "&nombre=" + nombreUsuario + "&tipo=" + tipoUsuario + "&contrasena=" + contrasena);
        }



        ////////// MOSTRAR CRUD DE USUARIOS
        function mostrarCRUDUsuarios() {
            var crudContainerUsuarios = document.getElementById("crudUsuarios");

            // Realizar una solicitud AJAX para obtener el contenido del CRUD de usuarios
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Colocar el contenido en el contenedor de usuarios
                    crudContainerUsuarios.innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "obtener_crud.php", true); // Reemplaza "obtener_crud_usuarios.php" con la ruta correcta
            xhr.send();
        }
    </script>

</body>

</html>