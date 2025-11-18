-- Script de carga inicial de datos VioGen
-- Autor: Alberto
-- Fecha: 2024

USE viogen;

-- Usuario del sistema: abcd / 1234
-- La clave se almacena con hash SHA256
INSERT INTO usuarios (nombre_usuario, clave) VALUES 
('abcd', SHA2('1234', 256));

-- Víctimas de ejemplo para pruebas
INSERT INTO victimas (nombre, apellidos, tipo_documento, numero_documento, telefono, observaciones, usuario_id) VALUES
('María', 'García López', 'NIF', '12345678A', '600111222', 'Primera víctima registrada en el sistema', 1),
('Ana', 'Martínez Ruiz', 'NIE', 'X1234567B', '600333444', 'Caso derivado de servicios sociales', 1),
('Laura', 'Fernández Pérez', 'Pasaporte', 'AB1234567', '600555666', 'Requiere seguimiento especial', 1),
('Carmen', 'Rodríguez Sánchez', 'NIF', '87654321C', '600777888', NULL, 1),
('Elena', 'López García', 'NIF', '11223344D', '600999000', 'Caso urgente', 1);

-- Agresiones de ejemplo para pruebas
INSERT INTO agresiones (victima_id, agresor, tipo_agresion, fecha_hora, observaciones, usuario_id) VALUES
(1, 'Juan Pérez García - Expareja', 'fisica', '2024-10-15 14:30:00', 'Agresión con lesiones leves en brazo izquierdo', 1),
(1, 'Juan Pérez García', 'psicologica', '2024-10-20 09:00:00', 'Amenazas verbales por teléfono', 1),
(2, 'Pedro Sánchez Martín', 'sexual', '2024-10-18 23:45:00', 'Incidente en domicilio', 1),
(3, 'Antonio López Ruiz - Cónyuge', 'vicaria', '2024-10-22 16:00:00', 'Amenazas dirigidas a los hijos menores', 1),
(3, 'Antonio López Ruiz', 'fisica', '2024-10-25 20:30:00', 'Agresión física con objeto contundente', 1),
(4, NULL, 'psicologica', '2024-10-28 11:00:00', 'Acoso continuado por redes sociales', 1),
(5, 'Miguel Torres Vega', 'fisica', '2024-11-01 08:15:00', 'Lesiones en rostro y cuello', 1);
