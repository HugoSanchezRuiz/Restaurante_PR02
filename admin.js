/////// MOSTRAR CONTENIDOS
document.addEventListener("DOMContentLoaded", function () {
    var formBusqueda = document.getElementById('frmbusqueda');
    var resultadoContainer = document.getElementById('crudUsuarios');
    var buscarUsuarioInput = document.getElementById('buscarUsuario');

    buscarUsuarioInput.addEventListener('keyup', function () {
        var searchValue = buscarUsuarioInput.value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'filtro.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                resultadoContainer.innerHTML = xhr.responseText;
            }
        };

        xhr.send('buscarUsuario=' + encodeURIComponent(searchValue));
    });


});

document.addEventListener("DOMContentLoaded", function () {
    var formBusqueda = document.getElementById('frmbusqueda1');
    var resultadoContainer = document.getElementById('filtro_mesa');
    var buscarMesaInput = document.getElementById('buscarMesa');

    buscarMesaInput.addEventListener('keyup', function () {
        var searchValue = buscarMesaInput.value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'filtro_mesa.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                resultadoContainer.innerHTML = xhr.responseText;
            }
        };

        xhr.send('buscarMesa=' + encodeURIComponent(searchValue));
    });

    // Evitar el envío del formulario al presionar "Enter"
    formBusqueda.addEventListener('submit', function (event) {
        event.preventDefault();
    });
});
// Llamar a la función para mostrar el CRUD al cargar la página
window.onload = function () {

    //document.getElementById("verUsuarios").onclick = MostrarOcultar;
    // Mostrar el CRUD de usuarios al cargar la página
    if (!document.getElementById('buscarUsuario').value.trim()) {
        mostrarCRUDUsuarios();
    }
    ocultarElemento("crudRecursos");
    ocultarElemento("formInsertar");
    ocultarElemento("formInsertarMesa");
    ocultarElemento("formInsertarSilla");
    ocultarElemento("formInsertarSala");
    ocultarElemento("filtro1");
    ocultarElemento("updateForm");
    ocultarElemento("filtro_mesa");


    ///// INSERTAR USUARIO

    document.getElementById("insertarB").addEventListener("click", function (event) {
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
            document.getElementById('error_select').innerText = 'Por favor, eligue una opción en el select.';
            return false;
        }

        // Si todo está bien, el formulario se envía
        insertarUser();
        return true;

    });


    ///// INSERTAR MESA
    document.getElementById("insertarBMesa").addEventListener("click", function (event) {
        var idSalaInput = document.getElementById('idsalaInputI');
        var capacidadInput = document.getElementById('capacidadInputI');
        var errorIdSala = document.getElementById('error_idsala');
        var errorCapacidad = document.getElementById('error_capacidad');

        // Restablecer mensajes de error
        errorIdSala.textContent = '';
        errorCapacidad.textContent = '';

        // Verificar si los campos están vacíos o no contienen solo números
        if (idSalaInput.value.trim() === '' || !/^\d+$/.test(idSalaInput.value)) {
            errorIdSala.textContent = 'Por favor, ingresa un número válido para Número Sala.';
            return false;
        }

        if (capacidadInput.value.trim() === '' || !/^\d+$/.test(capacidadInput.value)) {
            errorCapacidad.textContent = 'Por favor, ingresa un número válido para Capacidad.';
            return false;
        }

        insertarMesa();
        return true;

    });



    ///// INSERTAR SILLA
    document.getElementById("insertarBSilla").addEventListener("click", function (event) {

        event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

        var idMesaInput = document.getElementById('idmesaInputI');
        var errorIdMesa = document.getElementById('error_idmesa');

        // Restablecer mensaje de error
        errorIdMesa.textContent = '';

        // Verificar si el campo está vacío o no contiene solo números
        if (idMesaInput.value.trim() === '' || !/^\d+$/.test(idMesaInput.value)) {
            errorIdMesa.textContent = 'Por favor, ingresa un número válido para Número de Mesa.';
            event.preventDefault(); // Evitar el envío del formulario
            return false;
        }

        insertarSilla();
        return true;
    });

    ///// INSERTAR SALA
    document.getElementById("insertarBSala").addEventListener("click", function (event) {
        event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

        var nombreSalaInput = document.getElementById('nombresalaInputI');
        var tipoSalaInput = document.getElementById('tiposalaInputI');
        var capacidadSalaInput = document.getElementById('capacidadInputI2');
        var imagenInput = document.getElementById('imagenInput');
        var errorNombreSala = document.getElementById('error_nombresala');
        var errorTipoSala = document.getElementById('error_tiposala');
        var errorCapacidadSala = document.getElementById('error_capacidadsala');
        var errorImagen = document.getElementById('error_imagen');

        // Restablecer mensajes de error
        errorNombreSala.textContent = '';
        errorTipoSala.textContent = '';
        errorCapacidadSala.textContent = '';
        errorImagen.textContent = '';

        // Verificar si los campos están vacíos o no contienen solo números
        if (nombreSalaInput.value.trim() === '') {
            errorNombreSala.textContent = 'Por favor, ingresa un nombre para la sala.';
            return;
        }

        if (tipoSalaInput.value === '') {
            errorTipoSala.textContent = 'Por favor, selecciona un tipo de sala.';
            return;
        }

        if (capacidadSalaInput.value.trim() === '' || !/^\d+$/.test(capacidadSalaInput.value)) {
            errorCapacidadSala.textContent = 'Por favor, ingresa una capacidad válida para la sala.';
            return;
        }

        // Verificar si se ha seleccionado un archivo
        if (imagenInput.files.length === 0) {
            errorImagen.textContent = 'Por favor, selecciona una imagen para la sala.';
            return;
        }

        // Si todos los campos son válidos, el formulario se enviará normalmente
        insertarSala();
    });

};

// Se acaba el window.onload


// ACTUALIZAR
function mostrarSweetAlert(idUsuario, nombreUsuario, tipoUsuario, contrasena) {
    Swal.fire({
        title: '¿Quieres actualizar este usuario?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir a actualizar_usuario.php con los parámetros
            window.location.href = `actualizar_usuario.php?id_usuario=${idUsuario}&nombre_usuario=${nombreUsuario}&tipo_usuario=${tipoUsuario}&contrasena=${contrasena}`;
        }
    });
}

function mostrarSweetAlertSilla(idSilla, idMesa) {
    Swal.fire({
        title: '¿Quieres actualizar esta silla?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir a actualizar_silla.php con los parámetros
            window.location.href = `actualizar_silla.php?id_silla=${idSilla}&id_mesa=${idMesa}`;
        }
    });
}

function mostrarSweetAlertSala(idSala, nombreSala, tipoSala, capacidad, imagen) {
    Swal.fire({
        title: '¿Quieres actualizar esta sala?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir a actualizar_sala.php con los parámetros
            window.location.href = `actualizar_sala.php?id_sala=${idSala}&nombre_sala=${nombreSala}&tipo_sala=${tipoSala}&capacidad=${capacidad}&imagen=${imagen}`;
        }
    });
}






/// Mostrar u ocultar contenido según el botón que se clicke
document.getElementById("insertarM").addEventListener("click", function (event) {
    event.preventDefault(); // Evitar la recarga de la página al enviar el formulario

    ocultarElemento("crudUsuarios");
    ocultarElemento("crudRecursos");
    ocultarElemento("formInsertar");
    ocultarElemento("formInsertarSilla");
    ocultarElemento("formInsertarSala");
    ocultarElemento("filtro1");
    ocultarElemento("filtro");
    ocultarElemento("filtro_mesa");

    // Mostrar el form de mesa
    mostrarElemento("formInsertarMesa");
});

document.getElementById("recurso").addEventListener("click", function () {
    mostrarCRUDRecurso();
    // Ocultar el CRUD de usuarios y el formulario de insertar
    ocultarElemento("crudUsuarios");
    ocultarElemento("formInsertar");
    ocultarElemento("formInsertarMesa");
    ocultarElemento("formInsertarSilla");
    ocultarElemento("formInsertarSala");
    ocultarElemento("filtro");
    ocultarElemento("filtro_mesa");
    

    // Mostrar el CRUD de recursos
    mostrarElemento("crudRecursos");
    mostrarElemento("filtro1");
    mostrarElemento("filtro_mesa");
});

document.getElementById("insertar").addEventListener("click", function () {
    // Ocultar el CRUD de usuarios y el CRUD de recursos
    ocultarElemento("crudUsuarios");
    ocultarElemento("crudRecursos");
    ocultarElemento("formInsertarMesa");
    ocultarElemento("formInsertarSilla");
    ocultarElemento("formInsertarSala");
    ocultarElemento("filtro_mesa");
    ocultarElemento("filtro1");
    ocultarElemento("filtro");

    // Mostrar el formulario de insertar
    mostrarElemento("formInsertar");
});

document.getElementById("insertarS").addEventListener("click", function () {
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
    ocultarElemento("filtro_mesa");
    ocultarElemento("filtro");
    ocultarElemento("filtro1");
});

document.getElementById("insertarSL").addEventListener("click", function () {
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
    ocultarElemento("filtro_mesa");
    ocultarElemento("filtro1");
    ocultarElemento("filtro");
});
/////// MOSTRAR U OCULTAR CONTENIDO
document.getElementById("verUsuarios").addEventListener("click", function () {
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
    ocultarElemento("filtro_mesa");
    ocultarElemento("filtro1");
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
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar la página después de eliminar el usuario cada 1 segundo
            setInterval(function () {
                mostrarCRUDUsuarios();
            }, 1000);
        }
    };
    xhr.open("GET", "borrar_usuario.php?id_usuario=" + idUsuario, true);
    xhr.send();
}

function eliminarMesaAjax(idMesa) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar la página después de eliminar el usuario cada 1 segundo
            setInterval(function () {
                mostrarCRUDRecurso();
            }, 1000);
        }
    };
    xhr.open("GET", "borrar_mesa.php?id_mesa=" + idMesa, true);
    xhr.send();
}

function eliminarSillaAjax(idSilla) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar la página después de eliminar el usuario cada 1 segundo
            setInterval(function () {
                mostrarCRUDRecurso();
            }, 1000);
        }
    };
    xhr.open("GET", "borrar_silla.php?id_silla=" + idSilla, true);
    xhr.send();
}

function eliminarSalaAjax(idSala) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar la página después de eliminar el usuario cada 1 segundo
            setInterval(function () {
                mostrarCRUDRecurso();
            }, 1000);
        }
    };
    xhr.open("GET", "borrar_sala.php?id_sala=" + idSala, true);
    xhr.send();
}

function eliminarReservaAjax(idReserva) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar la página después de eliminar el usuario cada 1 segundo
            setInterval(function () {
                mostrarCRUDRecurso();
            }, 1000);
        }
    };
    xhr.open("GET", "borrar_reserva.php?id_reserva=" + idReserva, true);
    xhr.send();
}



////////// MOSTRAR CRUDS DE USUARIOS Y RECURSOS
function mostrarCRUDUsuarios() {
    var crudContainerUsuarios = document.getElementById("crudUsuarios");

    // Realizar una solicitud AJAX para obtener el contenido del CRUD de usuarios
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
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
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Colocar el contenido en el contenedor de usuarios
            crudContainerRecurso.innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "obtener_crud_recurso.php", true); // Reemplaza "obtener_crud_usuarios.php" con la ruta correcta
    xhr.send();
}


//// INSERTAR

function insertarUser() {
    var form = document.getElementById("formI");
    var usuarioInput = document.getElementById("usuarioInputI");
    var pwdInput = document.getElementById("pwdInputI");
    var tipoInput = document.getElementById("tipoInputI");
    var formData = new FormData(form);

    // Realizar la solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                if (xhr.responseText === "Usuario Insertado") {
                    // Éxito al insertar el usuario
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario Insertado',
                        showConfirmButton: false,
                        text: xhr.responseText,
                        timer: 1500
                    });
                    usuarioInput.value = "";
                    pwdInput.value = "";
                    tipoInput.value = "";
                    // Puedes realizar acciones adicionales si es necesario
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Insertar Usuario',
                        text: xhr.responseText
                    });
                }

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

function insertarMesa() {
    var form = document.getElementById("formM");
    var idsalaInput = document.getElementById("idsalaInputI");
    var capacidadInput = document.getElementById("capacidadInputI");
    var formData = new FormData(form);

    // Realizar la solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                if (xhr.responseText === "Mesa insertada con éxito.") {
                    // Éxito al insertar la mesa
                    Swal.fire({
                        icon: 'success',
                        title: 'Mesa Insertada',
                        showConfirmButton: true,
                        timer: 5000
                    }).then(function () {
                        // Puedes realizar acciones adicionales si es necesario
                        idsalaInput.value = "";
                        capacidadInput.value = "";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Insertar Mesa',
                        text: xhr.responseText
                    });
                }

            } else {
                // Error al insertar la mesa
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
}


function insertarSilla() {
    var form = document.getElementById("formS");
    var idmesaInput = document.getElementById("idmesaInputI");
    var formData = new FormData(form);

    // Realizar la solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                if (xhr.responseText === "Silla insertada con éxito.") {
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
}

function insertarSala() {
    var form = document.getElementById("formSL");
    var nombresalaInput = document.getElementById("nombresalaInputI");
    var tiposalaInput = document.getElementById("tiposalaInputI");
    var capacidadInput = document.getElementById("capacidadInputI2");
    var imagenInput = document.getElementById("imagenInput");
    var formData = new FormData(form);

    // Agregar la imagen al FormData
    formData.append("imagen", imagenInput.files[0]); // Solo la primera imagen si permites múltiples archivos

    // Realizar la solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // Éxito al insertar la sala
                if (xhr.responseText === "Sala insertada con éxito.") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sala Insertada',
                        showConfirmButton: true,
                        text: "Sala Insertada",
                        timer: 5000
                    });
                    capacidadInput.value = "";
                    tiposalaInput.value = "";
                    nombresalaInput.value = "";
                    imagenInput.value = "";
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sala Insertada',
                        showConfirmButton: true,
                        text: "Sala Insertada",
                        timer: 5000
                    });
                }
                if (xhr.responseText === "Error: El nombre de la sala ya existe.") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Insertar Sala',
                        text: xhr.responseText
                    });
                }

                // Puedes realizar acciones adicionales si es necesario
            } else {
                // Error al insertar la sala
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
}



