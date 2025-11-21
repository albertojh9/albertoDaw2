<?php
/**
 * CONTROLADOR VICTIMA
 * Gestiona el registro de víctimas
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
        $error = '';
        $datos = [
            'nombre' => '',
            'apellidos' => '',
            'tipo_documento' => '',
            'documento' => '',
            'telefono' => '',
            'observaciones' => ''
        ];
        require_once VIEWS_PATH . 'victima/crear.php';
    }
    
    /**
     * Procesa el registro de víctima
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=victima&action=crear');
            exit;
        }
        
        // Sanitizar todos los datos
        $datos = [
            'nombre' => htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'apellidos' => htmlspecialchars(trim($_POST['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'tipo_documento' => htmlspecialchars(trim($_POST['tipo_documento'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'documento' => htmlspecialchars(trim($_POST['documento'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'telefono' => htmlspecialchars(trim($_POST['telefono'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'observaciones' => htmlspecialchars(trim($_POST['observaciones'] ?? ''), ENT_QUOTES, 'UTF-8')
        ];
        
        // Validar: al menos nombre u observaciones
        if (empty($datos['nombre']) && empty($datos['observaciones'])) {
            $error = 'Debe proporcionar al menos un nombre o una observación';
            require_once VIEWS_PATH . 'victima/crear.php';
            return;
        }
        
        // Validar documento si se proporciona
        if (!empty($datos['documento'])) {
            if ($datos['tipo_documento'] === 'NIF' && !$this->victimaModel->validarNIF($datos['documento'])) {
                $error = 'NIF no válido';
                require_once VIEWS_PATH . 'victima/crear.php';
                return;
            }
            if ($datos['tipo_documento'] === 'NIE' && !$this->victimaModel->validarNIE($datos['documento'])) {
                $error = 'NIE no válido';
                require_once VIEWS_PATH . 'victima/crear.php';
                return;
            }
        }
        
        // Guardar en BD
        if ($this->victimaModel->crear($datos)) {
            $_SESSION['mensaje'] = MSG_VICTIMA_OK;
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            $error = MSG_ERROR;
            require_once VIEWS_PATH . 'victima/crear.php';
        }
    }
}
