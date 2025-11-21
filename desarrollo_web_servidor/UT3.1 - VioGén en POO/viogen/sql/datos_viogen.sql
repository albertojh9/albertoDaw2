-- Archivo de carga inicial de datos para VioGén
-- Este archivo debe ejecutarse después de viogen.sql

USE viogen;

-- Insertar usuario de prueba (nombre: abcd, clave: 1234)
-- La clave se guarda en texto plano según la estructura de la tabla
INSERT INTO Usuario (nombre, clave) VALUES ('abcd', '1234');

-- Datos de ejemplo adicionales para pruebas

-- Víctimas de ejemplo
INSERT INTO Victima (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
VALUES ('María', 'García López', 'NIF', '12345678A', '600123456', 'Primera víctima registrada para pruebas');

INSERT INTO Victima (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
VALUES ('Ana', 'Martínez Ruiz', 'NIE', 'X1234567B', '600654321', 'Víctima con seguimiento activo');

INSERT INTO Victima (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
VALUES (NULL, NULL, NULL, NULL, NULL, 'Víctima anónima - solo observaciones disponibles');

-- Agresiones de ejemplo
INSERT INTO Agresion (id_victima, agresor, tipo_agresion, fecha_hora, observaciones)
VALUES (1, 'Expareja - Juan Pérez', 'física', '2024-01-15 14:30:00', 'Agresión física con lesiones leves');

INSERT INTO Agresion (id_victima, agresor, tipo_agresion, fecha_hora, observaciones)
VALUES (1, 'Expareja - Juan Pérez', 'psicológica', '2024-01-20 09:00:00', 'Amenazas verbales y acoso');

INSERT INTO Agresion (id_victima, agresor, tipo_agresion, fecha_hora, observaciones)
VALUES (2, 'Familiar cercano', 'psicológica', '2024-02-01 18:45:00', 'Control económico y aislamiento social');
