<?php
/**
 * Punto de entrada único de la aplicación VioGén
 * Implementa el patrón Front Controller
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';

// Obtener controlador y acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'login';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Sanitizar parámetros
$controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
$action = preg_replace('/[^a-zA-Z0-9]/', '', $action);

// Lista de rutas públicas (no requieren autenticación)
$rutasPublicas = [
    'login' => ['index', 'login']
];

// Middleware de autenticación
$requiereAutenticacion = true;

// Verificar si la ruta actual es pública
if (isset($rutasPublicas[$controller])) {
    if (in_array($action, $rutasPublicas[$controller])) {
        $requiereAutenticacion = false;
    }
}

// Verificar autenticación si es necesario
if ($requiereAutenticacion) {
    if (!isset($_SESSION['usuario_id'])) {
        // No autenticado - devolver error 401
        http_response_code(401);
        header('Content-Type: text/html; charset=UTF-8');
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>401 - No Autorizado</title>
        </head>
        <body>
            <h1>401 - No Autorizado</h1>
            <p>Debe iniciar sesión para acceder a esta página.</p>
            <p><a href="index.php">Ir al Login</a></p>
        </body>
        </html>';
        exit;
    }
}

// Construir nombre del controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = CONTROLLERS_PATH . $controllerName . '.php';

// Verificar que el archivo del controlador existe
if (!file_exists($controllerFile)) {
    http_response_code(404);
    die('Controlador no encontrado: ' . htmlspecialchars($controllerName));
}

// Cargar modelos necesarios
$modelFile = MODELS_PATH . 'Usuario.php';
if (file_exists($modelFile)) {
    require_once $modelFile;
}

// Cargar el controlador
require_once $controllerFile;

// Instanciar el controlador
$controllerInstance = new $controllerName();

// Verificar que la acción existe
if (!method_exists($controllerInstance, $action)) {
    http_response_code(404);
    die('Acción no encontrada: ' . htmlspecialchars($action));
}

// Ejecutar la acción
$controllerInstance->$action();
