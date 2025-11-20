<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($datos['titulo']); ?></title>
</head>
<body>
    <h1>Sistema VioGén</h1>
    
    <?php if (isset($datos['errores']['general'])): ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($datos['errores']['general']); ?>
        </p>
    <?php endif; ?>
    
    <form action="index.php?controller=login&amp;action=login" method="POST">
        <p>
            <label for="nombre">Nombre de usuario:</label><br>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                value="<?php echo htmlspecialchars($datos['nombre']); ?>"
                autocomplete="username"
            >
            <?php if (isset($datos['errores']['nombre'])): ?>
                <br><span style="color: red;"><?php echo htmlspecialchars($datos['errores']['nombre']); ?></span>
            <?php endif; ?>
        </p>
        
        <p>
            <label for="clave">Contraseña:</label><br>
            <input 
                type="password" 
                id="clave" 
                name="clave"
                autocomplete="current-password"
            >
            <?php if (isset($datos['errores']['clave'])): ?>
                <br><span style="color: red;"><?php echo htmlspecialchars($datos['errores']['clave']); ?></span>
            <?php endif; ?>
        </p>
        
        <p>
            <button type="submit">Iniciar Sesión</button>
        </p>
    </form>
    
    <p><small>Sistema de Valoración Policial del Riesgo</small></p>
</body>
</html>
