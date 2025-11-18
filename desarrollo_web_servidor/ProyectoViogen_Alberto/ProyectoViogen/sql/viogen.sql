-- Script de creación de la base de datos VioGen
-- Autor: Alberto
-- Fecha: 2024

-- Crear la base de datos
DROP DATABASE IF EXISTS viogen;
CREATE DATABASE viogen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear el usuario y asignar privilegios
DROP USER IF EXISTS 'uviogen'@'localhost';
CREATE USER 'uviogen'@'localhost' IDENTIFIED BY 'cviogen';
GRANT ALL PRIVILEGES ON viogen.* TO 'uviogen'@'localhost';
FLUSH PRIVILEGES;

-- Usar la base de datos
USE viogen;

-- Tabla de usuarios del sistema
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de víctimas
CREATE TABLE victimas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellidos VARCHAR(150),
    tipo_documento ENUM('NIF', 'NIE', 'Pasaporte'),
    numero_documento VARCHAR(20),
    telefono VARCHAR(20),
    observaciones TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla de agresiones
CREATE TABLE agresiones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    victima_id INT NOT NULL,
    agresor VARCHAR(255),
    tipo_agresion ENUM('fisica', 'psicologica', 'sexual', 'vicaria') NOT NULL,
    fecha_hora DATETIME NOT NULL,
    observaciones TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT,
    FOREIGN KEY (victima_id) REFERENCES victimas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Índices para mejorar las búsquedas
CREATE INDEX idx_victimas_nombre ON victimas(nombre);
CREATE INDEX idx_victimas_apellidos ON victimas(apellidos);
CREATE INDEX idx_victimas_telefono ON victimas(telefono);
CREATE INDEX idx_agresiones_fecha ON agresiones(fecha_hora);
CREATE INDEX idx_agresiones_tipo ON agresiones(tipo_agresion);
