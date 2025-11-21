USE viogen;

-- Usuario de prueba: abcd / 1234
INSERT INTO Usuario (nombre, clave) VALUES ('abcd', '1234');

-- Víctimas de ejemplo
INSERT INTO Victima (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
VALUES ('María', 'García López', 'NIF', '12345678Z', '600123456', 'Primera víctima registrada');

INSERT INTO Victima (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
VALUES ('Ana', 'Martínez Ruiz', 'NIE', 'X1234567L', '600654321', 'Víctima con seguimiento activo');

INSERT INTO Victima (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
VALUES (NULL, NULL, NULL, NULL, NULL, 'Víctima anónima - solo observaciones');

-- Agresiones de ejemplo
INSERT INTO Agresion (id_victima, agresor, tipo_agresion, fecha_hora, observaciones)
VALUES (1, 'Expareja - Juan Pérez', 'física', '2024-11-15 14:30:00', 'Agresión física con lesiones leves');

INSERT INTO Agresion (id_victima, agresor, tipo_agresion, fecha_hora, observaciones)
VALUES (1, 'Expareja - Juan Pérez', 'psicológica', '2024-11-20 09:00:00', 'Amenazas verbales y acoso');

INSERT INTO Agresion (id_victima, agresor, tipo_agresion, fecha_hora, observaciones)
VALUES (2, 'Familiar cercano', 'sexual', '2024-11-18 18:45:00', 'Requiere atención médica');
