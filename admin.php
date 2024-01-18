<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            color: #333;
        }

        a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }

        #crudSection {
            max-width: 800px;
            margin: 20px auto;
        }

        .user-item {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .btn-container {
            margin-top: 5px;
        }

        button {
            cursor: pointer;
            padding: 5px 10px;
            margin-right: 5px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 3px;
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
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <h3>Lista de Usuarios Registrados</h3>
    <a href="insertar_usuario.php" class="button">Insertar Usuario</a>

    <div id="crudContainer"></div>
    <div id="updateFormContainer"></div>
    <div id="insertFormContainer"></div>

    <a href="./index.php" class="button">Volver Login</a>

    <script>
        // Llamar a la función para mostrar el CRUD al cargar la página
        window.onload = function() {
            mostrarCRUD();
        };


        //ELIMINAR
        function confirmarEliminacion(nombreUsuario) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará el usuario: " + nombreUsuario,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Llamada Ajax para eliminar el usuario
                    eliminarUsuarioAjax(nombreUsuario);
                }
            });
        }

        function eliminarUsuarioAjax(nombreUsuario) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualizar la página después de eliminar el usuario cada 1 segundo
                    setInterval(function() {
                        window.location.reload();
                    }, 1000);
                }
            };
            xhr.open("GET", "borrar_usuario.php?nombre_usuario=" + nombreUsuario, true);
            xhr.send();
        }


        //ACTUALIZAR
        function mostrarFormularioActualizacion(idUsuario) {
            var updateFormContainer = document.getElementById("updateFormContainer");

            // Realizar una solicitud AJAX para obtener el contenido del formulario de actualización
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Colocar el contenido en el contenedor
                    updateFormContainer.innerHTML = xhr.responseText;
                    mostrarCRUD();
                }
            };
            xhr.open("GET", "mostrar_formulario_actualizar.php?id=" + idUsuario, true); // Reemplaza "obtener_formulario_actualizacion.php" con la ruta correcta
            xhr.send();
        }


        // Nueva función para actualizar dinámicamente los datos en el CRUD var // idUsuario = <php echo $datosUsuario['id_usuario']; ?>;
        function actualizarUsuarioEnCRUD() {
            var idUsuario = document.getElementsByName("id_usuario")[0].value;
            var nombreUsuario = document.getElementsByName("nombre_usuario")[0].value;
            var tipoUsuario = document.getElementsByName("tipo_usuario")[0].value;
            var contrasena = document.getElementsByName("contrasena")[0].value; // Asegúrate de que el campo esté presente en el formulario

            // Realizar una solicitud AJAX para actualizar dinámicamente los datos en el CRUD
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // La actualización ha sido completada
                    // Puedes mostrar un mensaje, actualizar más información, etc.
                    mostrarFormularioActualizacion(idUsuario); // Refrescar la lista después de la actualización
                }
            };
            xhr.open("POST", "actualizar_usuario.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("id=" + idUsuario + "&nombre=" + nombreUsuario + "&tipo=" + tipoUsuario + "&contrasena=" + contrasena);
        }

        //INSERTAR
        function mostrarFormularioInsertar() {
            var insertFormContainer = document.getElementById("insertFormContainer");

            // Realizar una solicitud AJAX para obtener el contenido del formulario de actualización
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Colocar el contenido en el contenedor
                    insertFormContainer.innerHTML = xhr.responseText;
                    mostrarCRUD();
                }
            };
            xhr.open("GET", "mostrar_formulario_insertar.php", true);
            xhr.send();
        }





        // MOSTRAR CRUD
        function mostrarCRUD() {
            var crudContainer = document.getElementById("crudContainer");

            // Realizar una solicitud AJAX para obtener el contenido del CRUD
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Colocar el contenido en el contenedor
                    crudContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "obtener_crud.php", true); // Reemplaza "obtener_crud.php" con la ruta correcta
            xhr.send();
        }
    </script>

</body>

</html>