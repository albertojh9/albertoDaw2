<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Agresión - Sistema VioGén</title>
</head>
<body>
    <h1>Sistema VioGén</h1>
    <h2>Registrar Agresión</h2>
    
    <p><a href="index.php?controller=menu&amp;action=index">Volver al Menú</a></p>
    
    <hr>
    
    <?php if (!empty($error)): ?>
        <p><strong>ERROR: <?php echo htmlspecialchars($error); ?></strong></p>
    <?php endif; ?>
    
    <?php if (empty($victimas)): ?>
        <p>⚠ No hay víctimas registradas. 
            <a href="index.php?controller=victima&amp;action=crear">Registre una víctima primero</a>.
        </p>
    <?php else: ?>
        <form action="index.php?controller=agresion&amp;action=guardar" method="POST">
            <p>
                <label for="id_victima">Víctima: *</label><br>
                <select id="id_victima" name="id_victima" required>
                    <option value="">-- Seleccione víctima --</option>
                    <?php foreach ($victimas as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php echo ($datos['id_victima'] == $v['id']) ? 'selected' : ''; ?>>
                            <?php 
                            $nombre = trim(($v['nombre'] ?? '') . ' ' . ($v['apellidos'] ?? ''));
                            echo htmlspecialchars($nombre ?: 'ID: ' . $v['id']);
                            if (!empty($v['documento'])) echo ' (' . htmlspecialchars($v['documento']) . ')';
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            
            <p>
                <label for="agresor">Agresor (opcional):</label><br>
                <textarea id="agresor" name="agresor" rows="3" cols="50"><?php echo htmlspecialchars($datos['agresor']); ?></textarea>
                <br><small>Descripción o datos identificativos del agresor</small>
            </p>
            
            <p>
                <label for="tipo_agresion">Tipo de Agresión: *</label><br>
                <select id="tipo_agresion" name="tipo_agresion" required>
                    <option value="">-- Seleccione tipo --</option>
                    <?php foreach (TIPOS_AGRESION as $tipo): ?>
                        <option value="<?php echo $tipo; ?>" <?php echo ($datos['tipo_agresion'] === $tipo) ? 'selected' : ''; ?>>
                            <?php echo ucfirst($tipo); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            
            <p>
                <label for="fecha_hora">Fecha y Hora: *</label><br>
                <input type="datetime-local" id="fecha_hora" name="fecha_hora" required
                       value="<?php echo htmlspecialchars($datos['fecha_hora']); ?>">
            </p>
            
            <p>
                <label for="observaciones">Observaciones:</label><br>
                <textarea id="observaciones" name="observaciones" rows="4" cols="50"><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
            </p>
            
            <p>
                <button type="submit">Registrar Agresión</button>
                <a href="index.php?controller=menu&amp;action=index">Cancelar</a>
            </p>
        </form>
    <?php endif; ?>
</body>
</html>
