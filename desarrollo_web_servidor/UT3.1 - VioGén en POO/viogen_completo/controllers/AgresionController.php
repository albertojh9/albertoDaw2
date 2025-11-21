<?php
/**
 * Controlador AgresionController
 * Gestiona el registro de agresiones
 */
class AgresionController {
    
    private $agresionModel;
    private $victimaModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->agresionModel = new Agresion();
        $this->victimaModel = new Victima();
    }
    
    /**
     * Muestra el formulario de registro de agresión
     */
    public function crear() {
        $datos = [
            'titulo' => 'Registrar Agresión - VioGén',
            'errores' => [],
            'agresion' => [
                'id_victima' => '',
                'agresor' => '',
                'tipo_agresion' => '',
                'fecha_hora' => '',
                'observaciones' => ''
            ],
            'victimas' => $this->victimaModel->obtenerTodas(),
            'tipos_agresion' => TIPOS_AGRESION
        ];
        
        require_once VIEWS_PATH . 'agresion/crear.php';
    }
    
    /**
     * Procesa el registro de agresión
     */
    public function guardar() {
        // Solo procesar si es POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=agresion&action=crear');
            exit;
        }
        
        // Sanitizar datos
        $agresion = [
            'id_victima' => filter_var($_POST['id_victima'] ?? '', FILTER_VALIDATE_INT),
            'agresor' => $this->sanitizar($_POST['agresor'] ?? ''),
            'tipo_agresion' => $this->sanitizar($_POST['tipo_agresion'] ?? ''),
            'fecha_hora' => $this->sanitizar($_POST['fecha_hora'] ?? ''),
            'observaciones' => $this->sanitizar($_POST['observaciones'] ?? '')
        ];
        
        // Convertir formato de fecha si es necesario
        if (!empty($agresion['fecha_hora'])) {
            $fecha = DateTime::createFromFormat('Y-m-d\TH:i', $agresion['fecha_hora']);
            if ($fecha) {
                $agresion['fecha_hora'] = $fecha->format('Y-m-d H:i:s');
            }
        }
        
        // Validar datos
        $errores = $this->agresionModel->validar($agresion);
        
        // Si hay errores, mostrar formulario con errores
        if (!empty($errores)) {
            // Restaurar formato de fecha para el formulario
            if (!empty($_POST['fecha_hora'])) {
                $agresion['fecha_hora'] = $_POST['fecha_hora'];
            }
            
            $datos = [
                'titulo' => 'Registrar Agresión - VioGén',
                'errores' => $errores,
                'agresion' => $agresion,
                'victimas' => $this->victimaModel->obtenerTodas(),
                'tipos_agresion' => TIPOS_AGRESION
            ];
            require_once VIEWS_PATH . 'agresion/crear.php';
            return;
        }
        
        // Intentar guardar
        $id = $this->agresionModel->crear($agresion);
        
        if ($id) {
            $_SESSION['mensaje'] = MSG_AGRESION_REGISTRADA;
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            // Restaurar formato de fecha para el formulario
            if (!empty($_POST['fecha_hora'])) {
                $agresion['fecha_hora'] = $_POST['fecha_hora'];
            }
            
            $datos = [
                'titulo' => 'Registrar Agresión - VioGén',
                'errores' => ['general' => MSG_ERROR_REGISTRO],
                'agresion' => $agresion,
                'victimas' => $this->victimaModel->obtenerTodas(),
                'tipos_agresion' => TIPOS_AGRESION
            ];
            require_once VIEWS_PATH . 'agresion/crear.php';
        }
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
