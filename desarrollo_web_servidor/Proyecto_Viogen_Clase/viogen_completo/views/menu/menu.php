<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($datos['titulo']); ?></title>
</head>
<body>
    <h1>Sistema VioGén</h1>
    <p><a href="index.php?controller=login&amp;action=logout">Cerrar Sesión</a></p>
    
    <hr>
    
    <?php if (!empty($datos['mensaje'])): ?>
        <p style="color: green;">
            <?php echo htmlspecialchars($datos['mensaje']); ?>
        </p>
    <?php endif; ?>
    
    <h2>Menú Principal</h2>
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
               value="<?php echo htmlspecialchars($datos['busqueda']); ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <?php if (!empty($datos['busqueda'])): ?>
        <?php if (!empty($datos['resultados'])): ?>
            <h3>Resultados de búsqueda para: "<?php echo htmlspecialchars($datos['busqueda']); ?>"</h3>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre Completo Víctima</th>
                        <th>Tipo de Agresión</th>
                        <th>Fecha de Agresión</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['resultados'] as $agresion): ?>
                        <tr>
                            <td>
                                <?php 
                                $nombreCompleto = trim(
                                    ($agresion['victima_nombre'] ?? '') . ' ' . 
                                    ($agresion['victima_apellidos'] ?? '')
                                );
                                echo htmlspecialchars($nombreCompleto ?: 'Sin nombre');
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars(ucfirst($agresion['tipo_agresion'])); ?></td>
                            <td>
                                <?php 
                                $fecha = new DateTime($agresion['fecha_hora']);
                                echo $fecha->format('d/m/Y H:i');
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><small>Total de resultados: <?php echo count($datos['resultados']); ?></small></p>
        <?php else: ?>
            <p style="color: orange;">
                No se encontraron resultados para "<?php echo htmlspecialchars($datos['busqueda']); ?>"
            </p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
