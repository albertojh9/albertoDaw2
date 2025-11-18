<?php
/**
 * Punto de entrada único de la aplicación VioGen
 * Implementa el patrón Front Controller
 * Incluye middleware de autenticación
 * 
 * @author Alberto
 * @version 1.0
 */

// Cargar configuración
require_once 'config.php';

// Obtener la acción solicitada
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'login';

// Acciones que no requieren autenticación
$acciones_publicas = ['login', 'procesarLogin'];

// Middleware de autenticación
if (!in_array($accion, $acciones_publicas)) {
    if (!isset($_SESSION['usuario_id'])) {
        // Error 401 - Unauthorized
        http_response_code(401);
        include VISTA_PATH . 'error401.php';
        exit;
    }
}

// Enrutamiento de acciones
switch ($accion) {
    // Autenticación
    case 'login':
        include CONTROLADOR_PATH . 'LoginControlador.php';
        mostrarLogin();
        break;
        
    case 'procesarLogin':
        include CONTROLADOR_PATH . 'LoginControlador.php';
        procesarLogin();
        break;
        
    case 'logout':
        include CONTROLADOR_PATH . 'LoginControlador.php';
        logout();
        break;
    
    // Menú principal
    case 'menu':
        include CONTROLADOR_PATH . 'MenuControlador.php';
        mostrarMenu();
        break;
    
    // Víctimas
    case 'registrarVictima':
        include CONTROLADOR_PATH . 'VictimaControlador.php';
        mostrarFormularioVictima();
        break;
        
    case 'guardarVictima':
        include CONTROLADOR_PATH . 'VictimaControlador.php';
        guardarVictima();
        break;
    
    // Agresiones
    case 'registrarAgresion':
        include CONTROLADOR_PATH . 'AgresionControlador.php';
        mostrarFormularioAgresion();
        break;
        
    case 'guardarAgresion':
        include CONTROLADOR_PATH . 'AgresionControlador.php';
        guardarAgresion();
        break;
    
    // Informes
    case 'buscarAgresiones':
        include CONTROLADOR_PATH . 'InformeControlador.php';
        buscarAgresiones();
        break;
    
    // Por defecto, mostrar login
    default:
        include CONTROLADOR_PATH . 'LoginControlador.php';
        mostrarLogin();
        break;
}
