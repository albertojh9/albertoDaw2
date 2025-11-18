<?php
/**
 * Controlador de Informes
 * Gestiona la búsqueda y visualización de agresiones
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'Agresion.php';

/**
 * Busca agresiones por texto en todos los campos
 */
function buscarAgresiones() {
    $mensaje = '';
    $tipo_mensaje = '';
    $resultados = [];
    $busqueda = '';
    
    // Verificar si hay mensaje en sesión
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        $tipo_mensaje = $_SESSION['tipo_mensaje'] ?? 'info';
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
    }
    
    // Obtener nombre del usuario
    $nombreUsuario = $_SESSION['nombre_usuario'] ?? '';
    
    // Procesar búsqueda
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['q'])) {
        // Sanitizar el texto de búsqueda
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $busqueda = isset($_POST['busqueda']) ? trim(htmlspecialchars($_POST['busqueda'], ENT_QUOTES, 'UTF-8')) : '';
        } else {
            $busqueda = isset($_GET['q']) ? trim(htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8')) : '';
        }
        
        if (!empty($busqueda)) {
            // Realizar búsqueda
            $resultados = Agresion::buscar($busqueda);
        }
    }
    
    include VISTA_PATH . 'menu.php';
}
