<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($datos['titulo']); ?></title>
</head>
<body>
    <h1>Sistema VioGén</h1>
    <p>
        <a href="index.php?controller=menu&amp;action=index">Volver al Menú</a> | 
        <a href="index.php?controller=login&amp;action=logout">Cerrar Sesión</a>
    </p>
    
    <hr>
    
    <h2>Registrar Agresión</h2>
    
    <?php if (isset($datos['errores']['general'])): ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($datos['errores']['general']); ?>
        </p>
    <?php endif; ?>
    
    <?php if (empty($datos['victimas'])): ?>
        <p style="color: orange;">
            No hay víctimas registradas. 
            <a href="index.php?controller=victima&amp;action=crear">Registre una víctima primero</a>.
        </p>
    <?php else: ?>
        <form action="index.php?controller=agresion&amp;action=guardar" method="POST">
            <p>
                <label for="id_victima">Víctima: *</label><br>
                <select id="id_victima" name="id_victima" required>
                    <option value="">-- Seleccione víctima --</option>
                    <?php foreach ($datos['victimas'] as $victima): ?>
                        <option value="<?php echo $victima['id']; ?>"
                            <?php echo ($datos['agresion']['id_victima'] == $victima['id']) ? 'selected' : ''; ?>>
                            <?php 
                            $nombreCompleto = trim(($victima['nombre'] ?? '') . ' ' . ($victima['apellidos'] ?? ''));
                            echo htmlspecialchars($nombreCompleto ?: 'ID: ' . $victima['id']);
                            if (!empty($victima['documento'])) {
                                echo ' (' . htmlspecialchars($victima['documento']) . ')';
                            }
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($datos['errores']['id_victima'])): ?>
                    <br><span style="color: red;"><?php echo htmlspecialchars($datos['errores']['id_victima']); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="agresor">Agresor:</label><br>
                <textarea id="agresor" name="agresor" rows="3" cols="50" 
                          placeholder="Descripción o datos identificativos del agresor"><?php echo htmlspecialchars($datos['agresion']['agresor']); ?></textarea>
                <br><small>Texto con la descripción o datos identificativos del agresor. No obligatorio.</small>
            </p>
            
            <p>
                <label for="tipo_agresion">Tipo de Agresión: *</label><br>
                <select id="tipo_agresion" name="tipo_agresion" required>
                    <option value="">-- Seleccione tipo --</option>
                    <?php foreach ($datos['tipos_agresion'] as $tipo): ?>
                        <option value="<?php echo $tipo; ?>"
                            <?php echo ($datos['agresion']['tipo_agresion'] === $tipo) ? 'selected' : ''; ?>>
                            <?php echo ucfirst($tipo); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($datos['errores']['tipo_agresion'])): ?>
                    <br><span style="color: red;"><?php echo htmlspecialchars($datos['errores']['tipo_agresion']); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="fecha_hora">Fecha y Hora: *</label><br>
                <input type="datetime-local" id="fecha_hora" name="fecha_hora" required
                       value="<?php echo htmlspecialchars($datos['agresion']['fecha_hora']); ?>">
                <?php if (isset($datos['errores']['fecha_hora'])): ?>
                    <br><span style="color: red;"><?php echo htmlspecialchars($datos['errores']['fecha_hora']); ?></span>
                <?php endif; ?>
            </p>
            
            <p>
                <label for="observaciones">Observaciones:</label><br>
                <textarea id="observaciones" name="observaciones" rows="4" cols="50"><?php echo htmlspecialchars($datos['agresion']['observaciones']); ?></textarea>
            </p>
            
            <p>
                <button type="submit">Registrar Agresión</button>
                <a href="index.php?controller=menu&amp;action=index">Cancelar</a>
            </p>
        </form>
    <?php endif; ?>
</body>
</html>
