<?php
/**
 * Controlador del Menú Principal
 * Gestiona la vista del menú y la búsqueda de agresiones
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'Agresion.php';

/**
 * Muestra el menú principal con el buscador de agresiones
 */
function mostrarMenu() {
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
    
    include VISTA_PATH . 'menu.php';
}
