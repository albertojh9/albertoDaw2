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
    
    <h2>Buscar Agresiones</h2>
    <form action="index.php?controller=agresion&amp;action=buscar" method="POST">
        <input type="text" name="busqueda" placeholder="Buscar por nombre, teléfono, observaciones...">
        <button type="submit">Buscar</button>
    </form>
    
    <hr>
    
    <h2>Menú Principal</h2>
    <ul>
        <li><a href="index.php?controller=victima&amp;action=crear">Registrar Víctima</a></li>
        <li><a href="index.php?controller=agresion&amp;action=crear">Registrar Agresión</a></li>
    </ul>
</body>
</html>
