<?php
/**
 * MODELO USUARIO
 * Gestiona operaciones de usuarios
 */
class Usuario {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Verifica las credenciales del usuario
     * Retorna el ID del usuario si es correcto, false si no
     */
    public function verificarCredenciales($nombre, $clave) {
        $sql = "SELECT id FROM Usuario WHERE nombre = :nombre AND clave = :clave";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nombre' => $nombre, ':clave' => $clave]);
        $usuario = $stmt->fetch();
        
        return $usuario ? $usuario['id'] : false;
    }
}
