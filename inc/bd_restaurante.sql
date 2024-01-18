-- CREATE DATABASE bd_restaurante;

-- USE bd_restaurante;

-- -- Tabla de Camareros -> Esta tabla contiene todos los camareros del restaurante (escalable)
-- CREATE TABLE tbl_camarero (
--     id_camarero INT PRIMARY KEY AUTO_INCREMENT,
--     nombre VARCHAR(50) NOT NULL,
--     contra VARCHAR(100) NOT NULL
-- );

-- -- Tabla de Salas -> Esta tabla contiene todas las salas del restaurante (escalable)
-- CREATE TABLE tbl_sala (
--     id_sala INT PRIMARY KEY AUTO_INCREMENT,
--     nombre VARCHAR(50) NOT NULL,
--     tipo_sala ENUM('terraza', 'comedor', 'privada') NOT NULL,
--     capacidad INT NOT NULL
-- );

-- -- Tabla de Mesas -> Esta tabla contiene todas las mesas del restaurante (escalable)
-- CREATE TABLE tbl_mesa (
--     id_mesa INT PRIMARY KEY AUTO_INCREMENT,
--     id_sala INT,
--     capacidad INT NOT NULL,
--     ocupada BOOLEAN NOT NULL DEFAULT FALSE,
--     FOREIGN KEY (id_sala) REFERENCES tbl_sala(id_sala)
-- );

-- -- Tabla de Ocupaciones -> a esta tabla se le hará un insert cuando alguna persona ocupe alguna mesa o la desocupe
-- CREATE TABLE tbl_ocupacion (
--     id_ocupacion INT PRIMARY KEY AUTO_INCREMENT,
--     id_mesa INT,
--     id_camarero INT,
--     fecha_inicio DATETIME NOT NULL,
--     fecha_fin DATETIME NULL,
--     FOREIGN KEY (id_mesa) REFERENCES tbl_mesa(id_mesa),
--     FOREIGN KEY (id_camarero) REFERENCES tbl_camarero(id_camarero)
-- );

-- INSERT INTO tbl_camarero (nombre, contra) VALUES
--     ('camarero_1', SHA2('camarero11234', 256)),
--     ('camarero_2', SHA2('camarero21234', 256)),
--     ('camarero_3', SHA2('camarero31234', 256)),
--     ('camarero_4', SHA2('camarero41234', 256)),
--     ('camarero_5', SHA2('camarero51234', 256)),
--     ('camarero_6', SHA2('camarero61234', 256));
    
-- -- Inserción de Salas
-- INSERT INTO tbl_sala (nombre, tipo_sala, capacidad) VALUES
--     ('terraza_1', 'terraza', 4),
--     ('terraza_2', 'terraza', 4),
--     ('terraza_3', 'terraza', 4),
--     ('terraza_4', 'terraza', 4),
--     ('comedor_1', 'comedor', 6),
--     ('comedor_2', 'comedor', 6),
--     ('comedor_3', 'comedor', 6),
--     ('sala_privada_1', 'privada', 2),
--     ('sala_privada_2', 'privada', 2),
--     ('sala_privada_3', 'privada', 2),
--     ('sala_privada_4', 'privada', 2);

-- -- Inserción de Mesas
-- INSERT INTO tbl_mesa (id_sala, capacidad) VALUES
--     (1, 2),
--     (1, 2),
--     (1, 3),
--     (1, 3),
--     (2, 2),
--     (2, 2),
--     (2, 3),
--     (2, 3),
--     (3, 2),
--     (3, 2),
--     (3, 3),
--     (3, 3),
--     (4, 2),
--     (4, 2),
--     (4, 3),
--     (4, 3),
--     (5, 6),
--     (5, 6),
--     (5, 6),
--     (5, 6),
--     (5, 6),
--     (5, 6),
--     (6, 6),
--     (6, 6),
--     (6, 6),
--     (6, 6),
--     (6, 6),
--     (6, 6),
--     (7, 4),
--     (7, 4),
--     (7, 4),
--     (7, 4),
--     (7, 4),
--     (7, 4),
--     (8, 10),
--     (8, 10),
--     (9, 8),
--     (9, 8),
--     (10, 8),
--     (10, 8),
--     (11, 15),
--     (11, 15);



-- Creación de la base de datos
CREATE DATABASE bd_restaurante2;

-- Uso de la base de datos
USE bd_restaurante;

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
    capacidad INT NOT NULL
);

-- Tabla de Mesas
CREATE TABLE tbl_mesa (
    id_mesa INT PRIMARY KEY AUTO_INCREMENT,
    id_sala INT,
    capacidad INT NOT NULL,
    ocupada BOOLEAN NOT NULL DEFAULT FALSE,
    ocupacion_maxima INT NOT NULL DEFAULT 0,
    FOREIGN KEY (id_sala) REFERENCES tbl_sala(id_sala)
);

-- Tabla de Sillas
CREATE TABLE tbl_silla (
    id_silla INT PRIMARY KEY AUTO_INCREMENT,
    id_mesa INT,
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

-- Inserción de Salas
INSERT INTO tbl_sala (nombre, tipo_sala, capacidad) VALUES
    ('terraza_1', 'terraza', 4),
    ('terraza_2', 'terraza', 4),
    ('terraza_3', 'terraza', 4),
    ('terraza_4', 'terraza', 4),
    ('comedor_1', 'comedor', 6),
    ('comedor_2', 'comedor', 6),
    ('comedor_3', 'comedor', 6),
    ('sala_privada_1', 'privada', 2),
    ('sala_privada_2', 'privada', 2),
    ('sala_privada_3', 'privada', 2),
    ('sala_privada_4', 'privada', 2);

-- Inserción de Mesas
INSERT INTO tbl_mesa (id_sala, capacidad) VALUES
    (1, 2),
    (1, 2),
    (1, 3),
    (1, 3),
    (2, 2),
    (2, 2),
    (2, 3),
    (2, 3),
    (3, 2),
    (3, 2),
    (3, 3),
    (3, 3),
    (4, 2),
    (4, 2),
    (4, 3),
    (4, 3),
    (5, 6),
    (5, 6),
    (5, 6),
    (5, 6),
    (5, 6),
    (5, 6),
    (6, 6),
    (6, 6),
    (6, 6),
    (6, 6),
    (6, 6),
    (6, 6),
    (7, 4),
    (7, 4),
    (7, 4),
    (7, 4),
    (7, 4),
    (7, 4),
    (8, 10),
    (8, 10),
    (9, 8),
    (9, 8),
    (10, 8),
    (10, 8),
    (11, 15),
    (11, 15);

-- Inserción de Sillas para llenar las mesas
INSERT INTO tbl_silla (id_mesa)
SELECT id_mesa FROM tbl_mesa;

-- Insertar sillas adicionales para llenar todas las mesas
INSERT INTO tbl_silla (id_mesa)
SELECT id_mesa
FROM tbl_mesa
JOIN (
    SELECT 1 AS n
    UNION SELECT 2
    UNION SELECT 3
    UNION SELECT 4
    UNION SELECT 5
    UNION SELECT 6
    -- Agrega más números según el máximo de capacidad de las mesas
) s ON s.n <= tbl_mesa.capacidad;



-- Inserción de Ocupaciones (ocupaciones directas y reservas)
INSERT INTO tbl_ocupacion (id_mesa, id_usuario, id_silla, fecha_inicio, es_reserva) VALUES
    (1, 1, 1, '2024-01-20 18:30:00', FALSE),
    (2, 1, 2, '2024-01-21 19:00:00', TRUE),
    (3, 2, 1, '2024-01-22 20:00:00', FALSE);
