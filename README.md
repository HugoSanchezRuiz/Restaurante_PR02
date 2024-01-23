# M12_Projecte02_Restaurant_PDO - Restaurante Morfeo - Nombre: Hugo Sánchez

Funcionamientos que ya se hicieron en la primera parte del proyecto:

Como se pedía en el enunciado del proyecto hemos creado una página web para los camareros que trabajan en un restaurante. Primero se accede a un login dónde el camarero mete su usuario y su contraseña y si coinciden en la base de datos se entra a la página de introducción dónde se le explica al camarero que debe hacer en la web. En el navbar tendremos un botón con las salas que si hacen click en ellas se mostrarán las mesas correspondientes de cada sala. También hay un botón de logout para cuando acabe su jornada laboral.

Una vez se accede a una sala, se ve cada mesa con una imagen como fondo en un botón para que sea clickable. Cuando pulsamos en la mesa se hará un insert o un update en función del estado de la mesa en ese momento. A la derecha tendremos el apartado de filtros dónde filtraremos para encontrar las mesas disponibles según su cantidad, el camarero que más ocupaciones ha realizado, el historial por fechas y el historial total. Se puede mostrar u ocultar el resultado del filtro clickando en los botones que hay abajo de cada uno. 

Además tambien tenemos un apartado de estadísticas, las cuáles mostramos en forma de gráfico con Chart.js, donde podremos observar las mesas más ocupadas de cada tipo de sala y a que horas esta más ocupadas.

Funcionamientos nuevos que he implementado en esta parte del proyecto:

He hecho que dependiendo del nombre con el que te logees, te envia a una página u otra. En la web hay tres tipos de usuario: camarero, admin y mantenimiento. Si eres camarero iras a la pagina de mostrar_mesas.php, y se podrá hacer reservas y ocupaciones. También podrá ver los filtros. Si eres admin iras a admin.php donde habrá un CRUD de usuarios, mesas, sillas, salas y ocupaciones/reservas. El admin podrá crear, ver, actualizar o eliminar cualquier valor de cualquier tabla de la base de datos. Si eres de mantenimiento iras a mantenimiento.php, donde el trabajador podrá cambiar el estado de cualquier recurso para habilitarlo en caso de que esté en buen estado o deshabilitarlo en caso de que no se pueda usar como un activo del restaurante.

Credenciales para acceder:

- Usuario: camarero_1
- Contraseña: camarero11234

- Usuario:camarero_2
- Contraseña: camarero21234

- Usuario:camarero_3
- Contraseña: camarero31234

- Usuario: camarero_4
- Contraseña: camarero41234

- Usuario: admin
- Contraseña: admin1234

- Usuario: mantenimiento
- Contraseña: mantenimiento1234



