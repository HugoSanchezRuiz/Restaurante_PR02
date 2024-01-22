<?php
include_once("./inc/conexion.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap">
    <link rel="stylesheet" href="./css/admin.css">
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

        <br>
        <br>

        <div id="filtro">
            <form id="frmbusqueda">
                <label for="buscarUsuario">Buscar por Nombre:</label>
                <input type="text" name="buscarUsuario" id="buscarUsuario" placeholder="Buscar...">
            </form>
        </div>

        <div id="formInsertar">
            <h3>Insertar Usuario</h3>
            <form method="post" id="formI" onsubmit="return validar()">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" name="usuario" id="usuarioInputI" required>
                <span id="error_usuario"></span>
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="pwd" id="pwdInputI" required>
                <span id="error_pwd"></span>
                <label for="tipo_usuario">Tipo de Usuario:</label>
                <select name="tipo_usuario" id="tipoInputI" required>
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
            <form method="post" id="formM" onsubmit="return validarFormulario('formM')">
                <label for="id_sala">Número Sala:</label>
                <input type="text" name="id_sala" id="idsalaInputI" required>
                <label for="capacidad">Capacidad:</label>
                <input type="text" name="capacidad" id="capacidadInputI" required>
                <br>
                <br>
                <input type="submit" name="insertarM" id="insertarBMesa" value="Insertar Mesa">
            </form>
        </div>

        <div id="formInsertarSilla">
            <h3>Insertar Silla</h3>
            <form method="post" id="formS" onsubmit="return validarFormulario('formS')">
                <label for="id_mesa">Número de Mesa:</label>
                <input type="text" name="id_mesa" id="idmesaInputI" required>
                <br>
                <br>
                <input type="submit" name="insertarS" id="insertarBSilla" value="Insertar Silla">
            </form>
        </div>

        <div id="formInsertarSala">
            <h3>Insertar Sala</h3>
            <form method="post" id="formSL" onsubmit="return validarFormulario('formSL')">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombresalaInputI" required>
                <label for="tipo_sala">Tipo de Sala:</label>
                <select name="tipo_sala" id="tiposalaInputI" required>
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="comedor">comedor</option>
                    <option value="terraza">terraza</option>
                    <option value="privada">privada</option>
                </select>
                <label for="capacidad">Capacidad:</label>
                <input type="text" name="capacidad" id="capacidadInputI2" required>
                <br>
                <br>
                <input type="submit" name="insertarSala" id="insertarBSala" value="Insertar Sala">
            </form>
        </div>
        <div id="crudUsuarios"></div>
        <!-- <div id="updateFormContainer"></div> -->
        <div id="insertFormContainer"></div>
        <div id="crudRecursos"></div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_usuario"])) {
            $sqlUsuario = "SELECT id_usuario, nombre_usuario, tipo_usuario FROM tbl_usuario WHERE id_usuario = ?";
            $stmtUsuario = $conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$idUsuario]);

            $datosUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

            if (!$datosUsuario) {
                header("Location: ./index.php");
                exit();
            }
        }
        ?>
        <div id="updateForm">
            <form id="updateForm" action="#" method="post">
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $datosUsuario['id_usuario']; ?>">

                <label for="nombre_usuario">Nuevo Nombre de Usuario:</label>
                <input type="text" name="nombre_usuario" id="nombre_usuario" value="<?php echo $datosUsuario['nombre_usuario']; ?>" required>

                <label for="contrasena">Nueva Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena">

                <label for="tipo_usuario">Nuevo Tipo de Usuario:</label>
                <select name="tipo_usuario" id="tipo_usuario" required>
                    <option value="admin" <?php echo ($datosUsuario['tipo_usuario'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="gerente" <?php echo ($datosUsuario['tipo_usuario'] === 'gerente') ? 'selected' : ''; ?>>Gerente</option>
                    <option value="mantenimiento" <?php echo ($datosUsuario['tipo_usuario'] === 'mantenimiento') ? 'selected' : ''; ?>>Mantenimiento</option>
                    <option value="camarero" <?php echo ($datosUsuario['tipo_usuario'] === 'camarero') ? 'selected' : ''; ?>>Camarero</option>
                </select>

                <input type="submit" name="actualizar" id="actualizarB" value="Actualizar Usuario">
            </form>
        </div>

        <a href="./index.php" class="button">Volver Login</a>
    </div>

    <script>
        /////// MOSTRAR CONTENIDOS

        // Llamar a la función para mostrar el CRUD al cargar la página
        window.onload = function() {
            //document.getElementById("verUsuarios").onclick = MostrarOcultar;
            // Mostrar el CRUD de usuarios al cargar la página
            mostrarCRUDUsuarios();
            ocultarElemento("crudRecursos");
            ocultarElemento("formInsertar");
            ocultarElemento("formInsertarMesa");
            ocultarElemento("formInsertarSilla");
            ocultarElemento("formInsertarSala");
            ocultarElemento("updateForm");

            ///// INSERTAR UUSUARIO

            document.getElementById("insertarB").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                // Funcion que proteje la contraseña
                function contieneLetrasYNumeros(str) {
                    return /[a-zA-Z]/.test(str) && /\d/.test(str);
                }
                // Obtenemos los valores de los campos
                var usuario = document.getElementById('usuarioInputI').value.trim();
                var pwd = document.getElementById('pwdInputI').value.trim();
                var tipoUsuario = document.getElementById('tipoInputI').value;

                // Validación del nombre de usuario
                if (usuario === "") {
                    document.getElementById('error_usuario').innerText = 'Por favor, ingresa el nombre de usuario.';
                    return false;
                } else {
                    document.getElementById('error_usuario').innerText = '';
                }

                // Validación de la contraseña
                if (pwd === "") {
                    document.getElementById('error_pwd').innerText = 'Por favor, ingresa la contraseña.';
                    return false;
                } else if (pwd.length < 6) {
                    document.getElementById('error_pwd').innerText = 'La contraseña debe tener al menos 6 caracteres.';
                    return false;
                } else if (!contieneLetrasYNumeros(pwd)) {
                    document.getElementById('error_pwd').innerText = 'La contraseña debe contener una combinación de letras y números.';
                    return false;
                } else {
                    document.getElementById('error_pwd').innerText = '';
                }

                // Validación del tipo de usuario
                if (tipoUsuario === "") {
                    alert('Por favor, selecciona un tipo de usuario.');
                    return false;
                }

                // Otras validaciones según sea necesario

                // Si todo está bien, el formulario se envía
                insertarUser();
                return true;

            });

            ///// INSERTAR MESA
            document.getElementById("insertarBMesa").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                var form = document.getElementById("formM");
                var idsalaInput = document.getElementById("idsalaInputI");
                var capacidadInput = document.getElementById("capacidadInputI");
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
                            idsalaInput.value = "";
                            capacidadInput.value = "";
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
                var idmesaInput = document.getElementById("idmesaInputI");
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
                            idmesaInput.value = "";
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
                var nombresalaInput = document.getElementById("nombresalaInputI");
                var tiposalaInput = document.getElementById("tiposalaInputI");
                var capacidadInput = document.getElementById("capacidadInputI2");
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
                            capacidadInput.value = "";
                            tiposalaInput.value = "";
                            nombresalaInput.value = "";
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



            // Se acaba el window.onload


            document.getElementById("insertarM").addEventListener("click", function(event) {
                event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

                ocultarElemento("crudUsuarios");
                ocultarElemento("crudRecursos");
                ocultarElemento("formInsertar");
                ocultarElemento("formInsertarSilla");
                ocultarElemento("formInsertarSala");
                ocultarElemento("filtro");

                // Mostrar el form de mesa
                mostrarElemento("formInsertarMesa");
            });

            document.getElementById("recurso").addEventListener("click", function() {
                mostrarCRUDRecurso();
                // Ocultar el CRUD de usuarios y el formulario de insertar
                ocultarElemento("crudUsuarios");
                ocultarElemento("formInsertar");
                ocultarElemento("formInsertarMesa");
                ocultarElemento("formInsertarSilla");
                ocultarElemento("formInsertarSala");
                ocultarElemento("filtro");

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
                ocultarElemento("filtro");

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
                ocultarElemento("filtro");
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
                ocultarElemento("filtro");
            });
            /////// MOSTRAR U OCULTAR CONTENIDO
            document.getElementById("verUsuarios").addEventListener("click", function() {
                // function MostrarOcultar() {
                // Mostrar el CRUD de usuarios
                mostrarCRUDUsuarios();
                // Mostrar el CRUD de recursos
                mostrarElemento("crudUsuarios");
                mostrarElemento("filtro");
                // Ocultar el CRUD de recursos y el formulario de insertar
                ocultarElemento("crudRecursos");
                ocultarElemento("formInsertar");
                ocultarElemento("formInsertarMesa");
                ocultarElemento("formInsertarSilla");
                ocultarElemento("formInsertarSala");
            });

            document.getElementById("act").addEventListener("click", function() {
                // function MostrarOcultar() {
                // Mostrar el CRUD de usuarios
                mostrarCRUDUsuarios();
                // Mostrar el CRUD de recursos
                mostrarElemento("crudUsuarios");
                mostrarElemento("updateForm");
                // Ocultar el CRUD de recursos y el formulario de insertar
                ocultarElemento("crudRecursos");
                ocultarElemento("formInsertar");
                ocultarElemento("formInsertarMesa");
                ocultarElemento("formInsertarSilla");
                ocultarElemento("formInsertarSala");
                ocultarElemento("filtro");
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
        };


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

        function confirmarEliminacionReserva(idReserva) {
            console.log("Confirmar eliminación de silla");
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la reserva con id: " + idReserva,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, elimina'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarReservaAjax(idReserva);
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
                        mostrarCRUDRecurso();
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
                        mostrarCRUDRecurso();
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
                        mostrarCRUDRecurso();
                    }, 1000);
                }
            };
            xhr.open("GET", "borrar_sala.php?id_sala=" + idSala, true);
            xhr.send();
        }

        function eliminarReservaAjax(idReserva) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualizar la página después de eliminar el usuario cada 1 segundo
                    setInterval(function() {
                        mostrarCRUDRecurso();
                    }, 1000);
                }
            };
            xhr.open("GET", "borrar_reserva.php?id_reserva=" + idReserva, true);
            xhr.send();
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

        function mostrarCRUDRecurso() {
            var crudContainerRecurso = document.getElementById("crudRecursos");

            // Realizar una solicitud AJAX para obtener el contenido del CRUD de usuarios
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Colocar el contenido en el contenedor de usuarios
                    crudContainerRecurso.innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "obtener_crud_recurso.php", true); // Reemplaza "obtener_crud_usuarios.php" con la ruta correcta
            xhr.send();
        }

        function validarFormulario(formId) {
            // Obtener el formulario por su ID
            var formulario = document.getElementById(formId);

            // Obtener todos los elementos de entrada del formulario
            var inputs = formulario.getElementsByTagName('input');
            var selects = formulario.getElementsByTagName('select');

            // Validar campos de texto y contraseña
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type === 'text' || inputs[i].type === 'password') {
                    if (inputs[i].value.trim() === '') {
                        alert('Por favor, complete todos los campos obligatorios.');
                        return false; // Evita que el formulario se envíe
                    }
                }
            }

            // Validar campos de selección (select)
            for (var i = 0; i < selects.length; i++) {
                if (selects[i].value === '') {
                    alert('Por favor, seleccione un valor para todos los campos obligatorios.');
                    return false; // Evita que el formulario se envíe
                }
            }

            // Si llegamos aquí, todos los campos requeridos están llenos
            return true;
        }

        ////// FILTRO

        // Listar usuarios
        function listarProductos(valor) {
            var resultado = document.getElementById('resultado');

            var formdata = new FormData();
            formdata.append('search', valor);

            var ajax = new XMLHttpRequest();
            ajax.open('POST', 'actualizar_filtro.php');

            ajax.onload = function() {
                var str = "";
                if (ajax.status === 200) {
                    var json = JSON.parse(ajax.responseText);
                    var divResultado = "";
                    json.forEach(function(item) {
                        str = "<div class='search-result' id='resultado_" + item.id_user + "'>";
                        str += "<p>Username: " + item.username + " | Nombre: " + item.nombre + "</p>";

                        // Verificar si ya se envió una solicitud
                        if (item.solicitud_enviada) {
                            str += "<p>Ya has enviado una solicitud a este usuario.</p>";
                        } else {
                            // Muestra el botón para enviar la solicitud
                            str += "<form class='solicitud-form' id='form_" + item.id_user + "'>";
                            str += "<input type='hidden' name='usuario_id' value='" + item.id_user + "'>";
                            str += "<button type='button' id='enso' onclick='enviarSolicitud(" + item.id_user + ")'>Enviar Solicitud de Amistad</button>";
                            str += "</form>";
                        }

                        str += "</div>";
                        divResultado += str;
                    });

                    resultado.innerHTML = divResultado;
                } else {
                    resultado.innerText = "Error";
                }
            };

            if (valor === "") {
                resultado.innerHTML = '';
            } else {
                ajax.send(formdata);
            }
        }

        function actualizarFiltro() {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        document.getElementById("resultado").innerHTML = xhr.responseText;
                    } else {
                        console.error("Error al actualizar el filtro: " + xhr.status);
                    }
                }
            };

            xhr.open("GET", "actualizar_filtro.php", true);
            xhr.send();
        };

        ////// ACTUALIZAR

        document.getElementById("updateForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

            var form = document.getElementById("updateForm");
            var formData = new FormData(form);

            // Realizar la solicitud AJAX para actualizar el usuario
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

        function insertarUser() {
            var form = document.getElementById("formI");
            var usuarioInput = document.getElementById("usuarioInputI");
            var pwdInput = document.getElementById("pwdInputI");
            var tipoInput = document.getElementById("tipoInputI");
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
                        usuarioInput.value = "";
                        pwdInput.value = "";
                        tipoInput.value = "";
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
        }
    </script>

</body>

</html>