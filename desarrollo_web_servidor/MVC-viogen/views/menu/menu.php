<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal - Sistema VioGén</title>
</head>
<body>
    <h1>Sistema VioGén - Menú Principal</h1>
    
    <p><a href="index.php?controller=login&amp;action=logout">Cerrar Sesión</a></p>
    
    <hr>
    
    <?php if (!empty($mensaje)): ?>
        <p><strong>✓ <?php echo $mensaje; ?></strong></p>
    <?php endif; ?>
    
    <h2>Opciones</h2>
    <ul>
        <li><a href="index.php?controller=victima&amp;action=crear">Registrar Víctima</a></li>
        <li><a href="index.php?controller=agresion&amp;action=crear">Registrar Agresión</a></li>
    </ul>
    
    <hr>
    
    <h2>Informe de Agresiones</h2>
    <form action="index.php" method="GET">
        <input type="hidden" name="controller" value="menu">
        <input type="hidden" name="action" value="index">
        <input type="text" name="busqueda" placeholder="Buscar por nombre, teléfono, observaciones..." 
               value="<?php echo $busqueda; ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <?php if (!empty($busqueda)): ?>
        <h3>Resultados para: "<?php echo $busqueda; ?>"</h3>
        
        <?php if (!empty($resultados)): ?>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre Completo Víctima</th>
                        <th>Tipo de Agresión</th>
                        <th>Fecha de Agresión</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $resultado): ?>
                        <tr>
                            <td><?php echo $resultado['nombre_completo']; ?></td>
                            <td><?php echo $resultado['tipo_agresion']; ?></td>
                            <td><?php echo $resultado['fecha_formateada']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><strong>Total: <?php echo count($resultados); ?> resultado(s)</strong></p>
        <?php else: ?>
            <p>⚠ No se encontraron resultados</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
