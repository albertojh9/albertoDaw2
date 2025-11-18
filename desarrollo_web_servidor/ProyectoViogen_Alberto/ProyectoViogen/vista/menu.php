<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="vista/style.css">
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <h1><?php echo APP_NAME; ?></h1>
            <div class="user-info">
                Usuario: <?php echo htmlspecialchars($nombreUsuario); ?>
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
        
        <?php if (!empty($mensaje)): ?>
            <div class="mensaje mensaje-<?php echo $tipo_mensaje; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        
        <!-- Buscador de Agresiones -->
        <div class="card">
            <h2>Informe de Agresiones</h2>
            <p>Busque en todos los campos textuales del sistema (nombre, apellidos, teléfono, observaciones, agresor...)</p>
            
            <form action="index.php?accion=buscarAgresiones" method="POST" class="search-box">
                <input type="text" name="busqueda" 
                       value="<?php echo htmlspecialchars($busqueda ?? ''); ?>" 
                       placeholder="Introduzca texto para buscar...">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
            
            <?php if (!empty($busqueda)): ?>
                <h3>Resultados de búsqueda para: "<?php echo htmlspecialchars($busqueda); ?>"</h3>
                
                <?php if (!empty($resultados)): ?>
                    <div class="tabla-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Tipo de Agresión</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $agresion): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(trim($agresion['nombre_completo'])); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $agresion['tipo_agresion']; ?>">
                                                <?php echo htmlspecialchars(TIPOS_AGRESION[$agresion['tipo_agresion']]); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($agresion['fecha_hora'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p style="margin-top: 15px; color: #666;">
                        Se encontraron <?php echo count($resultados); ?> resultado(s).
                    </p>
                <?php else: ?>
                    <p style="color: #666; font-style: italic;">
                        No se encontraron resultados para la búsqueda.
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <!-- Accesos rápidos -->
        <div class="card">
            <h2>Acciones Rápidas</h2>
            <p style="margin-bottom: 20px;">
                <a href="index.php?accion=registrarVictima" class="btn btn-primary">Registrar Nueva Víctima</a>
                <a href="index.php?accion=registrarAgresion" class="btn btn-secondary">Registrar Nueva Agresión</a>
            </p>
        </div>
    </div>
</body>
</html>
