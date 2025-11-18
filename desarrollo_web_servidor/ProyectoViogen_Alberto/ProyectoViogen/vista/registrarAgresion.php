<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Agresión - <?php echo APP_NAME; ?></title>
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
            <h2>Registro de Agresión</h2>
            
            <?php if (!empty($mensaje)): ?>
                <div class="mensaje mensaje-<?php echo $tipo_mensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($victimas)): ?>
                <div class="mensaje mensaje-info">
                    No hay víctimas registradas en el sistema. 
                    <a href="index.php?accion=registrarVictima">Registre una víctima primero</a>.
                </div>
            <?php else: ?>
            
            <form action="index.php?accion=guardarAgresion" method="POST">
                <div class="form-group">
                    <label for="victima_id" class="required">Víctima</label>
                    <select id="victima_id" name="victima_id" required>
                        <option value="">-- Seleccione una víctima --</option>
                        <?php foreach ($victimas as $victima): ?>
                            <option value="<?php echo $victima['id']; ?>" 
                                <?php echo ($datos['victima_id'] == $victima['id']) ? 'selected' : ''; ?>>
                                <?php 
                                    $nombreCompleto = trim($victima['nombre'] . ' ' . $victima['apellidos']);
                                    echo htmlspecialchars($nombreCompleto ?: 'Víctima ID: ' . $victima['id']); 
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="agresor">Agresor</label>
                    <input type="text" id="agresor" name="agresor" 
                           value="<?php echo htmlspecialchars($datos['agresor']); ?>"
                           placeholder="Descripción o datos identificativos del agresor">
                    <small>Texto con la descripción o datos identificativos del agresor (opcional)</small>
                </div>
                
                <div class="form-group">
                    <label for="tipo_agresion" class="required">Tipo de Agresión</label>
                    <select id="tipo_agresion" name="tipo_agresion" required>
                        <option value="">-- Seleccione el tipo --</option>
                        <?php foreach (TIPOS_AGRESION as $valor => $nombre): ?>
                            <option value="<?php echo $valor; ?>" 
                                <?php echo ($datos['tipo_agresion'] === $valor) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($nombre); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fecha" class="required">Fecha</label>
                    <input type="date" id="fecha" name="fecha" 
                           value="<?php echo htmlspecialchars($datos['fecha']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="hora" class="required">Hora</label>
                    <input type="time" id="hora" name="hora" 
                           value="<?php echo htmlspecialchars($datos['hora']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" 
                              placeholder="Observaciones adicionales sobre la agresión"><?php echo htmlspecialchars($datos['observaciones']); ?></textarea>
                </div>
                
                <p style="margin-bottom: 20px; color: #666; font-size: 14px;">
                    <strong>Nota:</strong> Los campos marcados con * son obligatorios.
                </p>
                
                <button type="submit" class="btn btn-primary">Registrar Agresión</button>
                <a href="index.php?accion=menu" class="btn btn-secondary">Cancelar</a>
            </form>
            
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
