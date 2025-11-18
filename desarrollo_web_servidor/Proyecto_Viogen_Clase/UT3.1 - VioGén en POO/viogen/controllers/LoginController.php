<?php
/**
 * Controlador LoginController
 * Gestiona las acciones de autenticación: login y logout
 */
class LoginController {
    
    private $usuarioModel;
    
    /**
     * Constructor - inicializa el modelo de usuario
     */
    public function __construct() {
        $this->usuarioModel = new Usuario();
    }
    
    /**
     * Muestra el formulario de login
     */
    public function index() {
        // Si ya está logueado, redirigir al menú principal
        if ($this->estaAutenticado()) {
            header('Location: index.php?controller=menu&action=index');
            exit;
        }
        
        $datos = [
            'titulo' => 'Iniciar Sesión - VioGén',
            'errores' => [],
            'nombre' => ''
        ];
        
        require_once VIEWS_PATH . 'login/login.php';
    }
    
    /**
     * Procesa el formulario de login
     */
    public function login() {
        // Solo procesar si es POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        // Sanitizar datos de entrada
        $nombre = $this->sanitizar($_POST['nombre'] ?? '');
        $clave = $_POST['clave'] ?? ''; // No sanitizar la clave para no alterar caracteres especiales
        
        // Validar datos
        $errores = $this->usuarioModel->validarLogin($nombre, $clave);
        
        // Si hay errores de validación, mostrar formulario con errores
        if (!empty($errores)) {
            $datos = [
                'titulo' => 'Iniciar Sesión - VioGén',
                'errores' => $errores,
                'nombre' => $nombre
            ];
            require_once VIEWS_PATH . 'login/login.php';
            return;
        }
        
        // Verificar credenciales
        $usuarioId = $this->usuarioModel->verificarCredenciales($nombre, $clave);
        
        if ($usuarioId) {
            // Login exitoso - crear sesión
            $this->iniciarSesion($usuarioId);
            
            // Redirigir al menú principal
            header('Location: index.php?controller=menu&action=index');
            exit;
        } else {
            // Login fallido
            $datos = [
                'titulo' => 'Iniciar Sesión - VioGén',
                'errores' => ['general' => MSG_LOGIN_ERROR],
                'nombre' => $nombre
            ];
            require_once VIEWS_PATH . 'login/login.php';
        }
    }
    
    /**
     * Cierra la sesión del usuario
     */
    public function logout() {
        // Destruir todas las variables de sesión
        $_SESSION = [];
        
        // Destruir la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Destruir la sesión
        session_destroy();
        
        // Redirigir al login
        header('Location: index.php');
        exit;
    }
    
    /**
     * Inicia la sesión del usuario
     * @param int $usuarioId ID del usuario autenticado
     */
    private function iniciarSesion($usuarioId) {
        // Regenerar ID de sesión por seguridad
        session_regenerate_id(true);
        
        // Guardar solo el ID del usuario (no la clave)
        $_SESSION['usuario_id'] = $usuarioId;
        $_SESSION['login_time'] = time();
    }
    
    /**
     * Verifica si el usuario está autenticado
     * @return bool
     */
    private function estaAutenticado() {
        return isset($_SESSION['usuario_id']);
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
