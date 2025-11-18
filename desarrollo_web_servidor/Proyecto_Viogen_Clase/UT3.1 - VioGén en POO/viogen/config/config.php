<?php
/**
 * Archivo de configuración del sistema VioGén
 * Contiene todas las constantes de configuración
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'viogen');
define('DB_USER', 'uviogen');
define('DB_PASS', 'cviogen');
define('DB_CHARSET', 'utf8mb4');

// Configuración de rutas
define('BASE_PATH', dirname(__DIR__));
define('CONTROLLERS_PATH', BASE_PATH . '/controllers/');
define('MODELS_PATH', BASE_PATH . '/models/');
define('VIEWS_PATH', BASE_PATH . '/views/');

// Configuración de sesión
define('SESSION_NAME', 'viogen_session');
define('SESSION_LIFETIME', 3600); // 1 hora

// Mensajes del sistema
define('MSG_LOGIN_ERROR', 'Usuario o contraseña incorrectos');
define('MSG_LOGIN_REQUIRED', 'Debe iniciar sesión para acceder');
define('MSG_LOGOUT_SUCCESS', 'Sesión cerrada correctamente');
define('MSG_FIELD_REQUIRED', 'Este campo es obligatorio');
define('MSG_MIN_LENGTH', 'Debe tener al menos %d caracteres');
