<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Víctima - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="vista/style.css">
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <h1><?php echo APP_NAME; ?></h1>
            <div class="user-info">
                Usuario: <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>
            </div>
        </div>
        
        <!-- Navegación -->
        <nav class="nav">
            <ul>
                <li><a href="index.php?accion=menu">Inicio</a></li>
                <li><a href="index.php?accion=registrarVictima">Registrar Víctima</a></li>
                <li><a href="index.php?accion=registrarAgresion">Registrar Agresión</a></li>
                <li><a href="index.php?accion=logout" class="logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
        
        <div class="card">
            <h2>Registro de Víctima</h2>
            
            <?php if (!empty($mensaje)): ?>
                <div class="mensaje mensaje-<?php echo $tipo_mensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?accion=guardarVictima" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" 
                           value="<?php echo htmlspecialchars($datos['nombre']); ?>"
                           placeholder="Nombre de la víctima">
                </div>
                
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" 
                           value="<?php echo htmlspecialchars($datos['apellidos']); ?>"
                           placeholder="Apellidos de la víctima">
                </div>
                
                <div class="form-group">
                    <label for="tipo_documento">Tipo de Documento</label>
                    <select id="tipo_documento" name="tipo_documento">
                        <option value="">-- Seleccione --</option>
                        <?php foreach (TIPOS_DOCUMENTO as $tipo): ?>
                            <option value="<?php echo $tipo; ?>" 
                                <?php echo ($datos['tipo_documento'] === $tipo) ? 'selected' : ''; ?>>
                                <?php echo $tipo; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small>Con validación según el tipo seleccionado</small>
                </div>
                
                <div class="form-group">
                    <label for="numero_documento">Número de Documento</label>
                    <input type="text" id="numero_documento" name="numero_documento" 
                           value="<?php echo htmlspecialchars($datos['numero_documento']); ?>"
                           placeholder="Número del documento de identificación">
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" 
                           value="<?php echo htmlspecialchars($datos['telefono']); ?>"
                           placeholder="Teléfono de contacto">
                </div>
                
                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" 
                              placeholder="Observaciones adicionales"><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
                </div>
                
                <p style="margin-bottom: 20px; color: #666; font-size: 14px;">
                    <strong>Nota:</strong> Todos los campos son opcionales, pero debe indicar al menos un nombre o unas observaciones.
                </p>
                
                <button type="submit" class="btn btn-primary">Registrar Víctima</button>
                <a href="index.php?accion=menu" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
