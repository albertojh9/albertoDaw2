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
    
    <h2>Registrar Víctima</h2>
    
    <?php if (isset($datos['errores']['general'])): ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($datos['errores']['general']); ?>
        </p>
    <?php endif; ?>
    
    <p><small>Todos los campos son opcionales, pero debe proporcionar al menos un nombre o una observación.</small></p>
    
    <form action="index.php?controller=victima&amp;action=guardar" method="POST">
        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" 
                   value="<?php echo htmlspecialchars($datos['victima']['nombre']); ?>">
        </p>
        
        <p>
            <label for="apellidos">Apellidos:</label><br>
            <input type="text" id="apellidos" name="apellidos" 
                   value="<?php echo htmlspecialchars($datos['victima']['apellidos']); ?>">
        </p>
        
        <p>
            <label for="tipo_documento">Tipo de Documento:</label><br>
            <select id="tipo_documento" name="tipo_documento">
                <option value="">-- Seleccione --</option>
                <?php foreach ($datos['tipos_documento'] as $tipo): ?>
                    <option value="<?php echo $tipo; ?>" 
                        <?php echo ($datos['victima']['tipo_documento'] === $tipo) ? 'selected' : ''; ?>>
                        <?php echo $tipo; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><small>El documento será validado según el tipo seleccionado.</small>
        </p>
        
        <p>
            <label for="documento">Número de Documento:</label><br>
            <input type="text" id="documento" name="documento" 
                   value="<?php echo htmlspecialchars($datos['victima']['documento']); ?>">
            <?php if (isset($datos['errores']['documento'])): ?>
                <br><span style="color: red;"><?php echo htmlspecialchars($datos['errores']['documento']); ?></span>
            <?php endif; ?>
        </p>
        
        <p>
            <label for="telefono">Teléfono:</label><br>
            <input type="tel" id="telefono" name="telefono" 
                   value="<?php echo htmlspecialchars($datos['victima']['telefono']); ?>">
        </p>
        
        <p>
            <label for="observaciones">Observaciones:</label><br>
            <textarea id="observaciones" name="observaciones" rows="4" cols="50"><?php echo htmlspecialchars($datos['victima']['observaciones']); ?></textarea>
        </p>
        
        <p>
            <button type="submit">Registrar Víctima</button>
            <a href="index.php?controller=menu&amp;action=index">Cancelar</a>
        </p>
    </form>
</body>
</html>
