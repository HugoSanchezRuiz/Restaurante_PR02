-- Creación de la base de datos
CREATE DATABASE bd_restaurante2;

-- Uso de la base de datos
USE bd_restaurante2;

-- Tabla de Usuarios
CREATE TABLE tbl_usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(100) NOT NULL,
    tipo_usuario ENUM('admin', 'gerente', 'mantenimiento', 'camarero') NOT NULL,
    UNIQUE KEY (nombre_usuario)
);

-- Tabla de Salas
CREATE TABLE tbl_sala (
    id_sala INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    tipo_sala ENUM('terraza', 'comedor', 'privada') NOT NULL,
    capacidad INT NOT NULL,
    habilitada BOOLEAN NOT NULL DEFAULT TRUE
);

-- Tabla de Mesas
CREATE TABLE tbl_mesa (
    id_mesa INT PRIMARY KEY AUTO_INCREMENT,
    id_sala INT,
    capacidad INT NOT NULL,
    ocupada BOOLEAN NOT NULL DEFAULT FALSE,
    ocupacion_maxima INT NOT NULL DEFAULT 0,
    habilitada BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (id_sala) REFERENCES tbl_sala(id_sala)
);

-- Tabla de Sillas
CREATE TABLE tbl_silla (
    id_silla INT PRIMARY KEY AUTO_INCREMENT,
    id_mesa INT,
    habilitada BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (id_mesa) REFERENCES tbl_mesa(id_mesa)
);

-- Tabla de Ocupaciones
CREATE TABLE tbl_ocupacion (
    id_ocupacion INT PRIMARY KEY AUTO_INCREMENT,
    id_mesa INT,
    id_usuario INT,
    id_silla INT,
    fecha_reserva DATE,
    hora_reserva TIME,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NULL,
    es_reserva BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_mesa) REFERENCES tbl_mesa(id_mesa),
    FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario),
    FOREIGN KEY (id_silla) REFERENCES tbl_silla(id_silla)
);



-- Inserción de Usuarios (Camareros, Administradores, Gerentes, Mantenimiento)
INSERT INTO tbl_usuario (nombre_usuario, contrasena, tipo_usuario) VALUES
    ('camarero_1', SHA2('camarero11234', 256), 'camarero'),
    ('camarero_2', SHA2('camarero21234', 256), 'camarero'),
    ('camarero_3', SHA2('camarero31234', 256), 'camarero'),
    ('camarero_4', SHA2('camarero41234', 256), 'camarero'),
    ('admin', SHA2('admin1234', 256), 'admin'),
    ('gerente', SHA2('gerente1234', 256), 'gerente'),
    ('mantenimiento', SHA2('mantenimiento1234', 256), 'mantenimiento');

-- Inserción de Salas con habilitada por defecto
INSERT INTO tbl_sala (nombre, tipo_sala, capacidad, habilitada) VALUES
    ('terraza_1', 'terraza', 4, TRUE),
    ('terraza_2', 'terraza', 4, TRUE),
    ('terraza_3', 'terraza', 4, TRUE),
    ('terraza_4', 'terraza', 4, TRUE),
    ('comedor_1', 'comedor', 6, TRUE),
    ('comedor_2', 'comedor', 6, TRUE),
    ('comedor_3', 'comedor', 6, TRUE),
    ('sala_privada_1', 'privada', 2, TRUE),
    ('sala_privada_2', 'privada', 2, TRUE),
    ('sala_privada_3', 'privada', 2, TRUE),
    ('sala_privada_4', 'privada', 2, TRUE);


-- Inserción de Mesas con habilitada por defecto
INSERT INTO tbl_mesa (id_sala, capacidad, habilitada) VALUES
    (1, 2, TRUE),
    (1, 2, TRUE),
    (1, 3, TRUE),
    (1, 3, TRUE),
    (2, 2, TRUE),
    (2, 2, TRUE),
    (2, 3, TRUE),
    (2, 3, TRUE),
    (3, 2, TRUE),
    (3, 2, TRUE),
    (3, 3, TRUE),
    (3, 3, TRUE),
    (4, 2, TRUE),
    (4, 2, TRUE),
    (4, 3, TRUE),
    (4, 3, TRUE),
    (5, 6, TRUE),
    (5, 6, TRUE),
    (5, 6, TRUE),
    (5, 6, TRUE),
    (5, 6, TRUE),
    (5, 6, TRUE),
    (6, 6, TRUE),
    (6, 6, TRUE),
    (6, 6, TRUE),
    (6, 6, TRUE),
    (6, 6, TRUE),
    (6, 6, TRUE),
    (7, 4, TRUE),
    (7, 4, TRUE),
    (7, 4, TRUE),
    (7, 4, TRUE),
    (7, 4, TRUE),
    (7, 4, TRUE),
    (8, 10, TRUE),
    (8, 10, TRUE),
    (9, 8, TRUE),
    (9, 8, TRUE),
    (10, 8, TRUE),
    (10, 8, TRUE),
    (11, 15, TRUE),
    (11, 15, TRUE);


-- Insertar sillas para todas las mesas
INSERT INTO tbl_silla (id_mesa)
SELECT id_mesa
FROM tbl_mesa;

-- Insertar sillas adicionales para llenar todas las mesas habilitadas
INSERT INTO tbl_silla (id_mesa)
SELECT m.id_mesa
FROM tbl_mesa m
JOIN (
    SELECT 1 AS n
    UNION SELECT 2
    UNION SELECT 3
    UNION SELECT 4
    UNION SELECT 5
    UNION SELECT 6
    -- Agrega más números según el máximo de capacidad de las mesas
) s ON s.n <= m.capacidad
WHERE m.habilitada = TRUE;




-- Inserción de Ocupaciones (ocupaciones directas y reservas)
INSERT INTO tbl_ocupacion (id_mesa, id_usuario, id_silla, fecha_inicio, es_reserva) VALUES
    (1, 1, 1, '2024-01-20 18:30:00', FALSE),
    (2, 1, 2, '2024-01-21 19:00:00', TRUE),
    (3, 2, 1, '2024-01-22 20:00:00', FALSE);
