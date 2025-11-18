<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="vista/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1><?php echo APP_NAME; ?></h1>
            
            <?php if (!empty($mensaje)): ?>
                <div class="mensaje mensaje-<?php echo $tipo_mensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?accion=procesarLogin" method="POST">
                <div class="form-group">
                    <label for="nombre_usuario" class="required">Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" 
                           required minlength="<?php echo MIN_LENGTH_USUARIO; ?>"
                           placeholder="Introduzca su usuario">
                    <small>Mínimo <?php echo MIN_LENGTH_USUARIO; ?> caracteres</small>
                </div>
                
                <div class="form-group">
                    <label for="clave" class="required">Contraseña</label>
                    <input type="password" id="clave" name="clave" 
                           required minlength="<?php echo MIN_LENGTH_CLAVE; ?>"
                           placeholder="Introduzca su contraseña">
                    <small>Mínimo <?php echo MIN_LENGTH_CLAVE; ?> caracteres</small>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>
