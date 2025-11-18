<?php
/**
 * Archivo de configuración del sistema VioGen
 * Contiene todas las constantes de configuración
 * 
 * @author Alberto
 * @version 1.0
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'viogen');
define('DB_USER', 'uviogen');
define('DB_PASS', 'cviogen');
define('DB_CHARSET', 'utf8mb4');

// Configuración de la aplicación
define('APP_NAME', 'Sistema VioGen');
define('APP_VERSION', '1.0');

// Configuración de rutas (relativas)
define('BASE_PATH', dirname(__FILE__) . '/');
define('CONTROLADOR_PATH', BASE_PATH . 'controlador/');
define('MODELO_PATH', BASE_PATH . 'modelo/');
define('VISTA_PATH', BASE_PATH . 'vista/');

// Configuración de sesión
define('SESSION_NAME', 'viogen_session');
define('SESSION_LIFETIME', 3600); // 1 hora

// Tipos de documento permitidos
define('TIPOS_DOCUMENTO', ['NIF', 'NIE', 'Pasaporte']);

// Tipos de agresión permitidos
define('TIPOS_AGRESION', [
    'fisica' => 'Física',
    'psicologica' => 'Psicológica',
    'sexual' => 'Sexual',
    'vicaria' => 'Vicaria'
]);

// Configuración de validaciones
define('MIN_LENGTH_USUARIO', 4);
define('MIN_LENGTH_CLAVE', 4);

// Mensajes del sistema
define('MSG_LOGIN_EXITO', 'Sesión iniciada correctamente');
define('MSG_LOGIN_ERROR', 'Usuario o contraseña incorrectos');
define('MSG_LOGOUT_EXITO', 'Sesión cerrada correctamente');
define('MSG_VICTIMA_REGISTRADA', 'Víctima registrada correctamente');
define('MSG_AGRESION_REGISTRADA', 'Agresión registrada correctamente');
define('MSG_ERROR_CAMPOS', 'Por favor, complete los campos requeridos');
define('MSG_ERROR_DOCUMENTO', 'El documento de identificación no es válido');
define('MSG_ERROR_BD', 'Error al conectar con la base de datos');
define('MSG_ERROR_SESION', 'Debe iniciar sesión para acceder');

// Configuración de zona horaria
date_default_timezone_set('Europe/Madrid');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}
