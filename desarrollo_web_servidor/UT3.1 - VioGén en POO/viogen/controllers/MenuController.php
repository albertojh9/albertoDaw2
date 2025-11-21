<?php
/**
 * Controlador MenuController
 * Gestiona el menú principal de la aplicación
 */
class MenuController {
    
    /**
     * Muestra el menú principal
     */
    public function index() {
        $datos = [
            'titulo' => 'Menú Principal - VioGén',
            'mensaje' => $_SESSION['mensaje'] ?? null
        ];
        
        // Limpiar mensaje después de mostrarlo
        unset($_SESSION['mensaje']);
        
        require_once VIEWS_PATH . 'menu/menu.php';
    }
}
