<?php
/**
 * Controlador VictimaController
 * Gestiona el registro de víctimas
 */
class VictimaController {
    
    private $victimaModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->victimaModel = new Victima();
    }
    
    /**
     * Muestra el formulario de registro de víctima
     */
    public function crear() {
        $datos = [
            'titulo' => 'Registrar Víctima - VioGén',
            'errores' => [],
            'victima' => [
                'nombre' => '',
                'apellidos' => '',
                'tipo_documento' => '',
                'documento' => '',
                'telefono' => '',
                'observaciones' => ''
            ],
            'tipos_documento' => TIPOS_DOCUMENTO
        ];
        
        require_once VIEWS_PATH . 'victima/crear.php';
    }
    
    /**
     * Procesa el registro de víctima
     */
    public function guardar() {
        // Solo procesar si es POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=victima&action=crear');
            exit;
        }
        
        // Sanitizar datos
        $victima = [
            'nombre' => $this->sanitizar($_POST['nombre'] ?? ''),
            'apellidos' => $this->sanitizar($_POST['apellidos'] ?? ''),
            'tipo_documento' => $this->sanitizar($_POST['tipo_documento'] ?? ''),
            'documento' => $this->sanitizar($_POST['documento'] ?? ''),
            'telefono' => $this->sanitizar($_POST['telefono'] ?? ''),
            'observaciones' => $this->sanitizar($_POST['observaciones'] ?? '')
        ];
        
        // Validar datos
        $errores = $this->victimaModel->validar($victima);
        
        // Si hay errores, mostrar formulario con errores
        if (!empty($errores)) {
            $datos = [
                'titulo' => 'Registrar Víctima - VioGén',
                'errores' => $errores,
                'victima' => $victima,
                'tipos_documento' => TIPOS_DOCUMENTO
            ];
            require_once VIEWS_PATH . 'victima/crear.php';
            return;
        }
        
        // Intentar guardar
        $id = $this->victimaModel->crear($victima);
        
        if ($id) {
            $_SESSION['mensaje'] = MSG_VICTIMA_REGISTRADA;
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            $datos = [
                'titulo' => 'Registrar Víctima - VioGén',
                'errores' => ['general' => MSG_ERROR_REGISTRO],
                'victima' => $victima,
                'tipos_documento' => TIPOS_DOCUMENTO
            ];
            require_once VIEWS_PATH . 'victima/crear.php';
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
