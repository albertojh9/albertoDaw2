<?php
/**
 * ARCHIVO DE CONFIGURACIÓN
 * Contiene todas las constantes del sistema
 */

// === CONFIGURACIÓN DE BASE DE DATOS ===
define('DB_HOST', 'localhost');
define('DB_NAME', 'viogen');
define('DB_USER', 'uviogen');
define('DB_PASS', 'cviogen');
define('DB_CHARSET', 'utf8mb4');

// === CONFIGURACIÓN DE RUTAS ===
define('BASE_PATH', dirname(__DIR__));
define('CONTROLLERS_PATH', BASE_PATH . '/controllers/');
define('MODELS_PATH', BASE_PATH . '/models/');
define('VIEWS_PATH', BASE_PATH . '/views/');

// === CONFIGURACIÓN DE SESIÓN ===
define('SESSION_NAME', 'viogen_session');

// === TIPOS VÁLIDOS ===
define('TIPOS_DOCUMENTO', ['NIF', 'NIE', 'Pasaporte']);
define('TIPOS_AGRESION', ['física', 'psicológica', 'sexual', 'vicaria']);

// === MENSAJES DEL SISTEMA ===
define('MSG_LOGIN_ERROR', 'Usuario o contraseña incorrectos');
define('MSG_LOGIN_REQUIRED', 'Debe iniciar sesión para acceder');
define('MSG_VICTIMA_OK', 'Víctima registrada correctamente');
define('MSG_AGRESION_OK', 'Agresión registrada correctamente');
define('MSG_ERROR', 'Error al guardar los datos');
