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
                <label for="buscarUsuario">Buscar por Nombre o Tipo de usuario:</label>
                <input type="text" name="buscarUsuario" id="buscarUsuario" placeholder="Buscar...">
            </form>
        </div>

        <div id="formInsertar">
            <h3>Insertar Usuario</h3>
            <form method="post" id="formI">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" name="usuario" id="usuarioInputI">
                <span id="error_usuario"></span>
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="pwd" id="pwdInputI">
                <span id="error_pwd"></span>
                <label for="tipo_usuario">Tipo de Usuario:</label>
                <select name="tipo_usuario" id="tipoInputI">
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="admin">Admin</option>
                    <option value="gerente">Gerente</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="camarero">Camarero</option>
                </select>
                <span id="error_select"></span>
                <br>
                <br>
                <input type="submit" name="insertar" id="insertarB" value="Insertar Usuario">
            </form>
        </div>
        <div id="formInsertarMesa">
            <h3>Insertar Mesa</h3>
            <form method="post" id="formM">
                <label for="id_sala">Número Sala:</label>
                <input type="text" name="id_sala" id="idsalaInputI">
                <span id="error_idsala"></span>
                <label for="capacidad">Capacidad:</label>
                <input type="text" name="capacidad" id="capacidadInputI">
                <span id="error_capacidad"></span>
                <br>
                <br>
                <input type="submit" name="insertarM" id="insertarBMesa" value="Insertar Mesa">
            </form>
        </div>

        <div id="formInsertarSilla">
            <h3>Insertar Silla</h3>
            <form method="post" id="formS">
                <label for="id_mesa">Número de Mesa:</label>
                <input type="text" name="id_mesa" id="idmesaInputI">
                <span id="error_idmesa"></span>
                <br>
                <br>
                <input type="submit" name="insertarS" id="insertarBSilla" value="Insertar Silla">
            </form>
        </div>

        <div id="formInsertarSala">
            <h3>Insertar Sala</h3>
            <form method="post" id="formSL" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombresalaInputI">
                <span id="error_nombresala"></span>

                <label for="tipo_sala">Tipo de Sala:</label>
                <select name="tipo_sala" id="tiposalaInputI">
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="comedor">comedor</option>
                    <option value="terraza">terraza</option>
                    <option value="privada">privada</option>
                </select>
                <span id="error_tiposala"></span>

                <label for="capacidad">Capacidad:</label>
                <input type="text" name="capacidad" id="capacidadInputI2">
                <span id="error_capacidadsala"></span>

                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" id="imagenInput" accept="image/*">
                <span id="error_imagen"></span>

                <br>
                <br>

                <input type="submit" name="insertarSala" id="insertarBSala" value="Insertar Sala">
            </form>
        </div>
        <div id="crudUsuarios"></div>
        <div id="insertFormContainer"></div>
        <div id="crudRecursos"></div>


        <a href="./index.php" class="button">Volver Login</a>
    </div>
    <script src="./admin.js"></script>

</body>

</html>