<?php
/**
 * Modelo de Usuario
 * Gestiona las operaciones relacionadas con usuarios
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'BaseDatos.php';

class Usuario {
    
    /**
     * Verifica las credenciales del usuario
     * @param string $nombreUsuario Nombre de usuario
     * @param string $clave Contraseña
     * @return array|false Datos del usuario o false si no existe
     */
    public static function verificarCredenciales($nombreUsuario, $clave) {
        $conexion = BaseDatos::getConexion();
        
        $sql = "SELECT id, nombre_usuario FROM usuarios 
                WHERE nombre_usuario = :nombre_usuario 
                AND clave = SHA2(:clave, 256)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre_usuario' => $nombreUsuario,
            ':clave' => $clave
        ]);
        
        return $stmt->fetch();
    }
    
    /**
     * Obtiene un usuario por su ID
     * @param int $id ID del usuario
     * @return array|false Datos del usuario o false si no existe
     */
    public static function obtenerPorId($id) {
        $conexion = BaseDatos::getConexion();
        
        $sql = "SELECT id, nombre_usuario, fecha_creacion FROM usuarios WHERE id = :id";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch();
    }
}
