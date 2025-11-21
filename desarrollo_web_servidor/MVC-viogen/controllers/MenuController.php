<?php
/**
 * CONTROLADOR MENU
 * Gestiona el menú principal y buscador
 * LÓGICA PHP - Sanitiza TODO antes de pasar a la vista
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
        // LÓGICA: Preparar mensaje (ya está sanitizado desde donde se guarda)
        $mensaje = htmlspecialchars($_SESSION['mensaje'] ?? '', ENT_QUOTES, 'UTF-8');
        unset($_SESSION['mensaje']);
        
        // LÓGICA: Procesar búsqueda
        $busqueda = '';
        $resultados = [];
        
        if (isset($_GET['busqueda']) || isset($_POST['busqueda'])) {
            // Sanitizar búsqueda
            $busqueda = htmlspecialchars(trim($_GET['busqueda'] ?? $_POST['busqueda'] ?? ''), ENT_QUOTES, 'UTF-8');
            if (!empty($busqueda)) {
                $resultadosRaw = $this->agresionModel->buscar($busqueda);
                $resultados = $this->prepararDatosResultados($resultadosRaw);
            }
        }
        
        // Pasar variables a la vista (ya sanitizadas)
        require_once VIEWS_PATH . 'menu/menu.php';
    }
    
    /**
     * Prepara los datos de resultados CON SANITIZACIÓN
     */
    private function prepararDatosResultados($resultados) {
        $resultadosPreparados = [];
        foreach ($resultados as $r) {
            $nombreCompleto = trim(($r['nombre'] ?? '') . ' ' . ($r['apellidos'] ?? ''));
            $fecha = new DateTime($r['fecha_hora']);
            
            // SANITIZAR TODOS LOS DATOS antes de pasarlos a la vista
            $resultadosPreparados[] = [
                'nombre_completo' => htmlspecialchars($nombreCompleto ?: 'Sin nombre', ENT_QUOTES, 'UTF-8'),
                'tipo_agresion' => htmlspecialchars(ucfirst($r['tipo_agresion']), ENT_QUOTES, 'UTF-8'),
                'fecha_formateada' => $fecha->format('d/m/Y H:i')  // Fecha no necesita sanitización
            ];
        }
        return $resultadosPreparados;
    }
}
