<?php
/**
 * Controlador MenuController
 * Gestiona el menú principal de la aplicación
 */
class MenuController {
    
    private $agresionModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->agresionModel = new Agresion();
    }
    
    /**
     * Muestra el menú principal con buscador de agresiones
     */
    public function index() {
        $busqueda = '';
        $resultados = [];
        
        // Procesar búsqueda si existe
        if (isset($_GET['busqueda']) || isset($_POST['busqueda'])) {
            $busqueda = $this->sanitizar($_GET['busqueda'] ?? $_POST['busqueda'] ?? '');
            if (!empty($busqueda)) {
                $resultados = $this->agresionModel->buscar($busqueda);
            }
        }
        
        $datos = [
            'titulo' => 'Menú Principal - VioGén',
            'mensaje' => $_SESSION['mensaje'] ?? null,
            'busqueda' => $busqueda,
            'resultados' => $resultados
        ];
        
        // Limpiar mensaje después de mostrarlo
        unset($_SESSION['mensaje']);
        
        require_once VIEWS_PATH . 'menu/menu.php';
    }
    
    /**
     * Sanitiza una cadena de texto
     * @param string $dato Dato a sanitizar
     * @return string Dato sanitizado
     */
    private function sanitizar($dato) {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
        return $dato;
    }
}
