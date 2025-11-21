<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Víctima - Sistema VioGén</title>
</head>
<body>
    <h1>Sistema VioGén</h1>
    <h2>Registrar Víctima</h2>
    
    <p><a href="index.php?controller=menu&amp;action=index">Volver al Menú</a></p>
    
    <hr>
    
    <?php if (!empty($error)): ?>
        <p><strong>ERROR:</strong> <?php echo $error; ?></p>
    <?php endif; ?>
    
    <p>Todos los campos son opcionales, pero debe proporcionar al menos un nombre o una observación.</p>
    
    <form action="index.php?controller=victima&amp;action=guardar" method="POST">
        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo $datos['nombre']; ?>">
        </p>
        
        <p>
            <label for="apellidos">Apellidos:</label><br>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $datos['apellidos']; ?>">
        </p>
        
        <p>
            <label for="tipo_documento">Tipo de Documento:</label><br>
            <select id="tipo_documento" name="tipo_documento">
                <option value="">-- Seleccione --</option>
                <?php foreach ($tiposDocumento as $tipo): ?>
                    <option value="<?php echo $tipo['valor']; ?>" <?php echo ($datos['tipo_documento'] === $tipo['valor']) ? 'selected' : ''; ?>>
                        <?php echo $tipo['texto']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><small>El documento será validado según el tipo</small>
        </p>
        
        <p>
            <label for="documento">Número de Documento:</label><br>
            <input type="text" id="documento" name="documento" value="<?php echo $datos['documento']; ?>">
        </p>
        
        <p>
            <label for="telefono">Teléfono:</label><br>
            <input type="text" id="telefono" name="telefono" value="<?php echo $datos['telefono']; ?>">
        </p>
            
        <p>
            <label for="observaciones">Observaciones:</label><br>
            <textarea id="observaciones" name="observaciones" rows="4" cols="50"><?php echo $datos['observaciones']; ?></textarea>
        </p>
        
        <p>
            <button type="submit">Registrar Víctima</button>
            <a href="index.php?controller=menu&amp;action=index">Cancelar</a>
        </p>
    </form>
</body>
</html>
