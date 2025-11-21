<?php
/**
 * Modelo Usuario
 * Gestiona las operaciones relacionadas con los usuarios del sistema
 */
class Usuario {
    
    private $db;
    private $table = 'Usuario';
    
    // Propiedades del usuario
    private $id;
    private $nombre;
    private $clave;
    
    /**
     * Constructor - inicializa la conexión a BD
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Busca un usuario por nombre de usuario
     * @param string $nombre Nombre del usuario
     * @return array|false Datos del usuario o false si no existe
     */
    public function buscarPorNombre($nombre) {
        $sql = "SELECT id, nombre, clave FROM {$this->table} WHERE nombre = :nombre";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Verifica las credenciales del usuario
     * @param string $nombre Nombre de usuario
     * @param string $clave Contraseña
     * @return int|false ID del usuario si es válido, false si no
     */
    public function verificarCredenciales($nombre, $clave) {
        $usuario = $this->buscarPorNombre($nombre);
        
        if ($usuario) {
            // Verificar si la clave está hasheada o en texto plano
            // Para compatibilidad con datos iniciales en texto plano
            if ($usuario['clave'] === $clave || password_verify($clave, $usuario['clave'])) {
                return $usuario['id'];
            }
        }
        
        return false;
    }
    
    /**
     * Valida los datos de login
     * @param string $nombre Nombre de usuario
     * @param string $clave Contraseña
     * @return array Array de errores (vacío si no hay errores)
     */
    public function validarLogin($nombre, $clave) {
        $errores = [];
        
        // Validar nombre
        if (empty($nombre)) {
            $errores['nombre'] = MSG_FIELD_REQUIRED;
        } elseif (strlen($nombre) < 4) {
            $errores['nombre'] = sprintf(MSG_MIN_LENGTH, 4);
        }
        
        // Validar clave
        if (empty($clave)) {
            $errores['clave'] = MSG_FIELD_REQUIRED;
        } elseif (strlen($clave) < 4) {
            $errores['clave'] = sprintf(MSG_MIN_LENGTH, 4);
        }
        
        return $errores;
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
}
