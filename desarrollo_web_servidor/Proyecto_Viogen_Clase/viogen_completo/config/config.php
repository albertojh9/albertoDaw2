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

// Tipos de documento válidos
define('TIPOS_DOCUMENTO', ['NIF', 'NIE', 'Pasaporte']);

// Tipos de agresión válidos
define('TIPOS_AGRESION', ['física', 'psicológica', 'sexual', 'vicaria']);

// Mensajes del sistema
define('MSG_LOGIN_ERROR', 'Usuario o contraseña incorrectos');
define('MSG_LOGIN_REQUIRED', 'Debe iniciar sesión para acceder');
define('MSG_LOGOUT_SUCCESS', 'Sesión cerrada correctamente');
define('MSG_FIELD_REQUIRED', 'Este campo es obligatorio');
define('MSG_MIN_LENGTH', 'Debe tener al menos %d caracteres');
define('MSG_VICTIMA_REGISTRADA', 'Víctima registrada correctamente');
define('MSG_AGRESION_REGISTRADA', 'Agresión registrada correctamente');
define('MSG_ERROR_REGISTRO', 'Error al registrar los datos');
define('MSG_NOMBRE_O_OBS_REQUERIDO', 'Debe proporcionar al menos un nombre o una observación');
define('MSG_DOCUMENTO_INVALIDO', 'El documento no es válido para el tipo seleccionado');
