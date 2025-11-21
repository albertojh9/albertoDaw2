<?php
/**
 * CONTROLADOR LOGIN
 * Gestiona autenticación
 * LÓGICA PHP - Sanitiza TODO antes de pasar a la vista
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
        
        // Preparar datos para la vista (sanitizados)
        $error = '';  // Vacío = ya sanitizado
        
        // Cargar la vista
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
        
        // LÓGICA: Obtener y sanitizar datos
        $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
        $clave = $_POST['clave'] ?? '';
        
        // LÓGICA: Validar longitud mínima
        if (strlen($nombre) < 4 || strlen($clave) < 4) {
            // Sanitizar mensaje de error ANTES de pasar a la vista
            $error = htmlspecialchars('Usuario y contraseña deben tener al menos 4 caracteres', ENT_QUOTES, 'UTF-8');
            require_once VIEWS_PATH . 'login/login.php';
            return;
        }
        
        // LÓGICA: Verificar credenciales
        $usuarioId = $this->usuarioModel->verificarCredenciales($nombre, $clave);
        
        if ($usuarioId) {
            // LÓGICA: Login exitoso - crear sesión
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuarioId;
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            // LÓGICA: Login fallido - Sanitizar mensaje ANTES de vista
            $error = htmlspecialchars(MSG_LOGIN_ERROR, ENT_QUOTES, 'UTF-8');
            require_once VIEWS_PATH . 'login/login.php';
        }
    }
    
    /**
     * Cierra la sesión
     */
    public function logout() {
        // LÓGICA: Destruir sesión
        $_SESSION = [];
        session_destroy();
        
        // LÓGICA: Volver al login
        header('Location: index.php');
        exit;
    }
}
