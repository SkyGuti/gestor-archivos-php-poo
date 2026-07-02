CREATE DATABASE IF NOT EXISTS gestor_archivos_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE gestor_archivos_db;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nombre, usuario, clave, rol) VALUES
('Administrador', 'admin', '$2y$12$eN/p7cuxvzMubaQsqEDAJuP58w9kXgOQUK9FzMtnUP4JG/lQ3utSG', 'admin'),
('Usuario de prueba', 'usuario', '$2y$12$liWknS8ZzxT.aT.65w8P8.VjgTXHBuR6xf0J2wF1gjIutk326prhq', 'usuario');