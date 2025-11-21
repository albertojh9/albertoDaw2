<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema VioGén</title>
</head>
<body>
    <h1>Sistema VioGén</h1>
    <h2>Iniciar Sesión</h2>
    
    <?php if (!empty($error)): ?>
        <p><strong>ERROR:</strong> <?php echo $error; ?></p>
    <?php endif; ?>
    
    <form action="index.php?controller=login&amp;action=login" method="POST">
        <p>
            <label for="nombre">Usuario (mínimo 4 caracteres):</label><br>
            <input type="text" id="nombre" name="nombre" required>
        </p>
        
        <p>
            <label for="clave">Contraseña (mínimo 4 caracteres):</label><br>
            <input type="password" id="clave" name="clave" required>
        </p>
        
        <p>
            <button type="submit">Iniciar Sesión</button>
        </p>
    </form>
    
    <hr>
    <p>Usuario de prueba: abcd / 1234</p>
</body>
</html>
