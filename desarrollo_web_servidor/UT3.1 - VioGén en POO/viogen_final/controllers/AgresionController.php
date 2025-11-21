<?php
/**
 * CONTROLADOR AGRESION
 * Gestiona el registro de agresiones
 */
class AgresionController {
    private $agresionModel;
    private $victimaModel;
    
    public function __construct() {
        $this->agresionModel = new Agresion();
        $this->victimaModel = new Victima();
    }
    
    /**
     * Muestra el formulario de registro
     */
    public function crear() {
        $error = '';
        $datos = [
            'id_victima' => '',
            'agresor' => '',
            'tipo_agresion' => '',
            'fecha_hora' => '',
            'observaciones' => ''
        ];
        $victimas = $this->victimaModel->obtenerTodas();
        require_once VIEWS_PATH . 'agresion/crear.php';
    }
    
    /**
     * Procesa el registro de agresión
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=agresion&action=crear');
            exit;
        }
        
        // Sanitizar datos
        $datos = [
            'id_victima' => filter_var($_POST['id_victima'] ?? '', FILTER_VALIDATE_INT),
            'agresor' => htmlspecialchars(trim($_POST['agresor'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'tipo_agresion' => htmlspecialchars(trim($_POST['tipo_agresion'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'fecha_hora' => htmlspecialchars(trim($_POST['fecha_hora'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'observaciones' => htmlspecialchars(trim($_POST['observaciones'] ?? ''), ENT_QUOTES, 'UTF-8')
        ];
        
        // Convertir fecha de HTML5 a MySQL
        if (!empty($datos['fecha_hora'])) {
            $fecha = DateTime::createFromFormat('Y-m-d\TH:i', $datos['fecha_hora']);
            if ($fecha) {
                $datos['fecha_hora'] = $fecha->format('Y-m-d H:i:s');
            }
        }
        
        // Validar campos obligatorios
        $errores = [];
        if (!$datos['id_victima']) $errores[] = 'Debe seleccionar una víctima';
        if (empty($datos['tipo_agresion'])) $errores[] = 'Debe seleccionar un tipo de agresión';
        if (empty($datos['fecha_hora'])) $errores[] = 'Debe proporcionar fecha y hora';
        
        if (!empty($errores)) {
            $error = implode('. ', $errores);
            // Restaurar formato para el formulario
            if (!empty($_POST['fecha_hora'])) {
                $datos['fecha_hora'] = $_POST['fecha_hora'];
            }
            $victimas = $this->victimaModel->obtenerTodas();
            require_once VIEWS_PATH . 'agresion/crear.php';
            return;
        }
        
        // Guardar en BD
        if ($this->agresionModel->crear($datos)) {
            $_SESSION['mensaje'] = MSG_AGRESION_OK;
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            $error = MSG_ERROR;
            $victimas = $this->victimaModel->obtenerTodas();
            require_once VIEWS_PATH . 'agresion/crear.php';
        }
    }
}
