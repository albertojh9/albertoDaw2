<?php
/**
 * CONTROLADOR MENU
 * Gestiona el menú principal y buscador
 */
class MenuController {
    private $agresionModel;
    
    public function __construct() {
        $this->agresionModel = new Agresion();
    }
    
    /**
     * Muestra el menú principal con buscador
     */
    public function index() {
        $mensaje = $_SESSION['mensaje'] ?? '';
        unset($_SESSION['mensaje']);
        
        // Procesar búsqueda si existe
        $busqueda = '';
        $resultados = [];
        
        if (isset($_GET['busqueda']) || isset($_POST['busqueda'])) {
            $busqueda = htmlspecialchars(trim($_GET['busqueda'] ?? $_POST['busqueda'] ?? ''), ENT_QUOTES, 'UTF-8');
            if (!empty($busqueda)) {
                $resultados = $this->agresionModel->buscar($busqueda);
            }
        }
        
        require_once VIEWS_PATH . 'menu/menu.php';
    }
}
