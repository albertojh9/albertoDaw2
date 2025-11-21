<?php
/**
 * ============================================
 * PUNTO DE ENTRADA ÚNICO (FRONT CONTROLLER)
 * ============================================
 * Este archivo recibe TODAS las peticiones
 */

// 1. Iniciar sesión
session_start();

// 2. Cargar configuración y base de datos
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';

// 3. Obtener controlador y acción de la URL
$controller = $_GET['controller'] ?? 'login';
$action = $_GET['action'] ?? 'index';

// 4. Sanitizar (solo letras y números)
$controller = preg_replace('/[^a-zA-Z]/', '', $controller);
$action = preg_replace('/[^a-zA-Z]/', '', $action);

// ============================================
// MIDDLEWARE DE AUTENTICACIÓN (LO MÁS SIMPLE)
// ============================================
// Define qué rutas son públicas (no necesitan login)
$rutasPublicas = [
    'login' => ['index', 'login']  // LoginController puede acceder a index y login sin autenticación
];

// ¿Esta ruta necesita autenticación?
$necesitaLogin = true;

// Si el controlador y acción están en rutasPublicas, NO necesita login
if (isset($rutasPublicas[$controller]) && in_array($action, $rutasPublicas[$controller])) {
    $necesitaLogin = false;
}

// Si necesita login y NO hay sesión -> ERROR 401
if ($necesitaLogin && !isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>401 - No Autorizado</title>
    </head>
    <body>
        <h1>401 - No Autorizado</h1>
        <p>' . MSG_LOGIN_REQUIRED . '</p>
        <p><a href="index.php">Ir al Login</a></p>
    </body>
    </html>';
    exit;
}
// FIN DEL MIDDLEWARE
// ============================================

// 5. Cargar modelos (siempre los mismos)
require_once MODELS_PATH . 'Usuario.php';
require_once MODELS_PATH . 'Victima.php';
require_once MODELS_PATH . 'Agresion.php';

// 6. Construir nombre del controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = CONTROLLERS_PATH . $controllerName . '.php';

// 7. Verificar que existe el controlador
if (!file_exists($controllerFile)) {
    die('Error: Controlador no encontrado');
}

// 8. Cargar el controlador
require_once $controllerFile;

// 9. Crear instancia del controlador
$controllerInstance = new $controllerName();

// 10. Verificar que existe la acción
if (!method_exists($controllerInstance, $action)) {
    die('Error: Acción no encontrada');
}

// 11. Ejecutar la acción
$controllerInstance->$action();
