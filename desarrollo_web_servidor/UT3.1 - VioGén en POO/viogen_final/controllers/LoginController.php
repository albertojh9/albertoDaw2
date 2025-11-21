<?php
/**
 * CONTROLADOR LOGIN
 * Gestiona autenticación
 */
class LoginController {
    private $usuarioModel;
    
    public function __construct() {
        $this->usuarioModel = new Usuario();
    }
    
    /**
     * Muestra el formulario de login
     */
    public function index() {
        // Si ya está logueado, ir al menú
        if (isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=menu&action=index');
            exit;
        }
        
        $error = '';
        require_once VIEWS_PATH . 'login/login.php';
    }
    
    /**
     * Procesa el login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        // Obtener y sanitizar datos
        $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
        $clave = $_POST['clave'] ?? '';
        
        // Validar longitud mínima - retornar 401 si están vacíos
        if (strlen($nombre) < 4 || strlen($clave) < 4) {
            http_response_code(401);
            $error = 'Usuario y contraseña deben tener al menos 4 caracteres';
            require_once VIEWS_PATH . 'login/login.php';
            return;
        }
        
        // Verificar credenciales
        $usuarioId = $this->usuarioModel->verificarCredenciales($nombre, $clave);
        
        if ($usuarioId) {
            // Login exitoso: crear sesión solo con ID
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuarioId;
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            // Login fallido - retornar 401
            http_response_code(401);
            $error = MSG_LOGIN_ERROR;
            require_once VIEWS_PATH . 'login/login.php';
        }
    }
    
    /**
     * Cierra la sesión
     */
    public function logout() {
        // Destruir sesión
        $_SESSION = [];
        session_destroy();
        
        // Volver al login
        header('Location: index.php');
        exit;
    }
}
