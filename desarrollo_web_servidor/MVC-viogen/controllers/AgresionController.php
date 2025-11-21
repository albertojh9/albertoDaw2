<?php
/**
 * CONTROLADOR AGRESION
 * Gestiona el registro de agresiones
 * LÓGICA PHP - Sanitiza TODO antes de pasar a la vista
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
        // LÓGICA: Preparar datos iniciales vacíos (ya sanitizados)
        $error = '';
        $datos = [
            'id_victima' => '',
            'agresor' => '',
            'tipo_agresion' => '',
            'fecha_hora' => '',
            'observaciones' => ''
        ];
        
        // LÓGICA: Obtener y preparar lista de víctimas (sanitizadas)
        $victimasRaw = $this->victimaModel->obtenerTodas();
        $victimas = [];
        foreach ($victimasRaw as $v) {
            $nombre = trim(($v['nombre'] ?? '') . ' ' . ($v['apellidos'] ?? ''));
            $texto = $nombre ?: 'ID: ' . $v['id'];
            if (!empty($v['documento'])) {
                $texto .= ' (' . $v['documento'] . ')';
            }
            
            $victimas[] = [
                'id' => $v['id'],
                'texto' => htmlspecialchars($texto, ENT_QUOTES, 'UTF-8')
            ];
        }
        
        // LÓGICA: Preparar opciones de tipos de agresión (sanitizadas)
        $tiposAgresion = [];
        foreach (TIPOS_AGRESION as $tipo) {
            $tiposAgresion[] = [
                'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                'texto' => htmlspecialchars(ucfirst($tipo), ENT_QUOTES, 'UTF-8')
            ];
        }
        
        // Pasar variables a la vista (ya sanitizadas)
        require_once VIEWS_PATH . 'agresion/crearAgresion.php';
    }
    
    /**
     * Procesa el registro de agresión
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=agresion&action=crear');
            exit;
        }
        
        // LÓGICA: Sanitizar datos
        $datos = [
            'id_victima' => filter_var($_POST['id_victima'] ?? '', FILTER_VALIDATE_INT),
            'agresor' => htmlspecialchars(trim($_POST['agresor'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'tipo_agresion' => htmlspecialchars(trim($_POST['tipo_agresion'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'fecha_hora' => htmlspecialchars(trim($_POST['fecha_hora'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'observaciones' => htmlspecialchars(trim($_POST['observaciones'] ?? ''), ENT_QUOTES, 'UTF-8')
        ];
        
        // LÓGICA: Convertir fecha de HTML5 a MySQL
        $fechaOriginal = $datos['fecha_hora'];
        if (!empty($datos['fecha_hora'])) {
            $fecha = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['fecha_hora']);
            if ($fecha) {
                $datos['fecha_hora'] = $fecha->format('Y-m-d H:i:s');
            }
        }
        
        // LÓGICA: Validar campos obligatorios
        $errores = [];
        if (!$datos['id_victima']) $errores[] = 'Debe seleccionar una víctima';
        if (empty($datos['tipo_agresion'])) $errores[] = 'Debe seleccionar un tipo de agresión';
        if (empty($datos['fecha_hora'])) $errores[] = 'Debe proporcionar fecha y hora';
        
        if (!empty($errores)) {
            $error = htmlspecialchars(implode('. ', $errores), ENT_QUOTES, 'UTF-8');
            
            // Restaurar formato para el formulario
            $datos['fecha_hora'] = $fechaOriginal;
            
            // Preparar víctimas y tipos (sanitizados)
            $victimasRaw = $this->victimaModel->obtenerTodas();
            $victimas = [];
            foreach ($victimasRaw as $v) {
                $nombre = trim(($v['nombre'] ?? '') . ' ' . ($v['apellidos'] ?? ''));
                $texto = $nombre ?: 'ID: ' . $v['id'];
                if (!empty($v['documento'])) {
                    $texto .= ' (' . $v['documento'] . ')';
                }
                
                $victimas[] = [
                    'id' => $v['id'],
                    'texto' => htmlspecialchars($texto, ENT_QUOTES, 'UTF-8')
                ];
            }
            
            $tiposAgresion = [];
            foreach (TIPOS_AGRESION as $tipo) {
                $tiposAgresion[] = [
                    'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                    'texto' => htmlspecialchars(ucfirst($tipo), ENT_QUOTES, 'UTF-8')
                ];
            }
            
            require_once VIEWS_PATH . 'agresion/crearAgresion.php';
            return;
        }
        
        // LÓGICA: Guardar en BD
        if ($this->agresionModel->crear($datos)) {
            $_SESSION['mensaje'] = htmlspecialchars(MSG_AGRESION_OK, ENT_QUOTES, 'UTF-8');
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            $error = htmlspecialchars(MSG_ERROR, ENT_QUOTES, 'UTF-8');
            
            // Restaurar formato
            $datos['fecha_hora'] = $fechaOriginal;
            
            // Preparar víctimas y tipos (sanitizados)
            $victimasRaw = $this->victimaModel->obtenerTodas();
            $victimas = [];
            foreach ($victimasRaw as $v) {
                $nombre = trim(($v['nombre'] ?? '') . ' ' . ($v['apellidos'] ?? ''));
                $texto = $nombre ?: 'ID: ' . $v['id'];
                if (!empty($v['documento'])) {
                    $texto .= ' (' . $v['documento'] . ')';
                }
                
                $victimas[] = [
                    'id' => $v['id'],
                    'texto' => htmlspecialchars($texto, ENT_QUOTES, 'UTF-8')
                ];
            }
            
            $tiposAgresion = [];
            foreach (TIPOS_AGRESION as $tipo) {
                $tiposAgresion[] = [
                    'valor' => htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'),
                    'texto' => htmlspecialchars(ucfirst($tipo), ENT_QUOTES, 'UTF-8')
                ];
            }
            
            require_once VIEWS_PATH . 'agresion/crearAgresion.php';
        }
    }
}
