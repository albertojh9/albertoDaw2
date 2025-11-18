<?php
/**
 * Controlador de Login
 * Gestiona la autenticación de usuarios
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'Usuario.php';

/**
 * Muestra el formulario de login
 */
function mostrarLogin() {
    $mensaje = '';
    $tipo_mensaje = '';
    
    // Verificar si hay mensaje en sesión
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        $tipo_mensaje = $_SESSION['tipo_mensaje'] ?? 'info';
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
    }
    
    include VISTA_PATH . 'login.php';
}

/**
 * Procesa el formulario de login
 */
function procesarLogin() {
    $mensaje = '';
    $tipo_mensaje = 'error';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitizar entradas
        $nombreUsuario = isset($_POST['nombre_usuario']) ? trim(htmlspecialchars($_POST['nombre_usuario'], ENT_QUOTES, 'UTF-8')) : '';
        $clave = isset($_POST['clave']) ? $_POST['clave'] : '';
        
        // Validar longitud mínima
        if (strlen($nombreUsuario) < MIN_LENGTH_USUARIO || strlen($clave) < MIN_LENGTH_CLAVE) {
            $mensaje = 'El usuario y la clave deben tener al menos ' . MIN_LENGTH_USUARIO . ' caracteres';
        } else {
            // Verificar credenciales
            $usuario = Usuario::verificarCredenciales($nombreUsuario, $clave);
            
            if ($usuario) {
                // Crear sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                
                // Redirigir al menú principal
                $_SESSION['mensaje'] = MSG_LOGIN_EXITO;
                $_SESSION['tipo_mensaje'] = 'exito';
                header('Location: index.php?accion=menu');
                exit;
            } else {
                $mensaje = MSG_LOGIN_ERROR;
            }
        }
    }
    
    include VISTA_PATH . 'login.php';
}

/**
 * Cierra la sesión del usuario
 */
function logout() {
    // Destruir la sesión
    session_unset();
    session_destroy();
    
    // Iniciar nueva sesión para mensaje
    session_name(SESSION_NAME);
    session_start();
    
    $_SESSION['mensaje'] = MSG_LOGOUT_EXITO;
    $_SESSION['tipo_mensaje'] = 'info';
    
    // Redirigir al login
    header('Location: index.php?accion=login');
    exit;
}
