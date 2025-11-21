<?php
/**
 * CONTROLADOR VICTIMA
 * Gestiona el registro de víctimas
 * LÓGICA PHP - Sanitiza TODO antes de pasar a la vista
 */
class VictimaController {
    private $victimaModel;
    
    public function __construct() {
        $this->victimaModel = new Victima();
    }
    
    /**
     * Muestra el formulario de registro
     */
    public function crear() {
        // LÓGICA: Preparar datos iniciales vacíos (ya sanitizados)
        $error = '';
        $datos = [
            'nombre' => '',
            'apellidos' => '',
            'tipo_documento' => '',
            'documento' => '',
            'telefono' => '',
            'observaciones' => ''
        ];
        
        // LÓGICA: Preparar opciones de tipos de documento (sanitizadas)
        $tiposDocumento = [];
        foreach (TIPOS_DOCUMENTO as $tipo) {
            $tiposDocumento[] = [
                'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                'texto' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8')
            ];
        }
        
        // Pasar variables a la vista (ya sanitizadas)
        require_once VIEWS_PATH . 'victima/crearVictima.php';
    }
    
    /**
     * Procesa el registro de víctima
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=victima&action=crear');
            exit;
        }
        
        // LÓGICA: Sanitizar todos los datos de entrada
        $datos = [
            'nombre' => htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'apellidos' => htmlspecialchars(trim($_POST['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'tipo_documento' => htmlspecialchars(trim($_POST['tipo_documento'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'documento' => htmlspecialchars(trim($_POST['documento'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'telefono' => htmlspecialchars(trim($_POST['telefono'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'observaciones' => htmlspecialchars(trim($_POST['observaciones'] ?? ''), ENT_QUOTES, 'UTF-8')
        ];
        
        // LÓGICA: Validar - al menos nombre u observaciones
        if (empty($datos['nombre']) && empty($datos['observaciones'])) {
            $error = htmlspecialchars('Debe proporcionar al menos un nombre o una observación', ENT_QUOTES, 'UTF-8');
            
            // Preparar opciones sanitizadas
            $tiposDocumento = [];
            foreach (TIPOS_DOCUMENTO as $tipo) {
                $tiposDocumento[] = [
                    'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                    'texto' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8')
                ];
            }
            
            require_once VIEWS_PATH . 'victima/crearVictima.php';
            return;
        }
        
        // LÓGICA: Validar documento si se proporciona
        if (!empty($datos['documento'])) {
            if ($datos['tipo_documento'] === 'NIF' && !$this->victimaModel->validarNIF($datos['documento'])) {
                $error = htmlspecialchars('NIF no válido', ENT_QUOTES, 'UTF-8');
                
                // Preparar opciones sanitizadas
                $tiposDocumento = [];
                foreach (TIPOS_DOCUMENTO as $tipo) {
                    $tiposDocumento[] = [
                        'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                        'texto' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8')
                    ];
                }
                
                require_once VIEWS_PATH . 'victima/crear.php';
                return;
            }
            if ($datos['tipo_documento'] === 'NIE' && !$this->victimaModel->validarNIE($datos['documento'])) {
                $error = htmlspecialchars('NIE no válido', ENT_QUOTES, 'UTF-8');
                
                // Preparar opciones sanitizadas
                $tiposDocumento = [];
                foreach (TIPOS_DOCUMENTO as $tipo) {
                    $tiposDocumento[] = [
                        'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                        'texto' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8')
                    ];
                }
                
                require_once VIEWS_PATH . 'victima/crear.php';
                return;
            }
        }
        
        // LÓGICA: Guardar en BD (datos ya sanitizados)
        if ($this->victimaModel->crear($datos)) {
            $_SESSION['mensaje'] = htmlspecialchars(MSG_VICTIMA_OK, ENT_QUOTES, 'UTF-8');
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            $error = htmlspecialchars(MSG_ERROR, ENT_QUOTES, 'UTF-8');
            
            // Preparar opciones sanitizadas
            $tiposDocumento = [];
            foreach (TIPOS_DOCUMENTO as $tipo) {
                $tiposDocumento[] = [
                    'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                    'texto' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8')
                ];
            }
            
            require_once VIEWS_PATH . 'victima/crearVictima.php';
        }
    }
}
