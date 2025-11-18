<?php
/**
 * Modelo de Víctima
 * Gestiona las operaciones CRUD relacionadas con víctimas
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'BaseDatos.php';

class Victima {
    
    /**
     * Registra una nueva víctima
     * @param array $datos Datos de la víctima
     * @return int|false ID de la víctima insertada o false si falla
     */
    public static function registrar($datos) {
        $conexion = BaseDatos::getConexion();
        
        $sql = "INSERT INTO victimas (nombre, apellidos, tipo_documento, numero_documento, telefono, observaciones, usuario_id) 
                VALUES (:nombre, :apellidos, :tipo_documento, :numero_documento, :telefono, :observaciones, :usuario_id)";
        
        $stmt = $conexion->prepare($sql);
        $resultado = $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':apellidos' => $datos['apellidos'],
            ':tipo_documento' => $datos['tipo_documento'],
            ':numero_documento' => $datos['numero_documento'],
            ':telefono' => $datos['telefono'],
            ':observaciones' => $datos['observaciones'],
            ':usuario_id' => $datos['usuario_id']
        ]);
        
        if ($resultado) {
            return $conexion->lastInsertId();
        }
        return false;
    }
    
    /**
     * Obtiene todas las víctimas
     * @return array Lista de víctimas
     */
    public static function obtenerTodas() {
        $conexion = BaseDatos::getConexion();
        
        $sql = "SELECT id, nombre, apellidos, tipo_documento, numero_documento, telefono, observaciones, fecha_registro 
                FROM victimas 
                ORDER BY fecha_registro DESC";
        
        $stmt = $conexion->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene una víctima por su ID
     * @param int $id ID de la víctima
     * @return array|false Datos de la víctima o false si no existe
     */
    public static function obtenerPorId($id) {
        $conexion = BaseDatos::getConexion();
        
        $sql = "SELECT id, nombre, apellidos, tipo_documento, numero_documento, telefono, observaciones, fecha_registro 
                FROM victimas 
                WHERE id = :id";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch();
    }
    
    /**
     * Busca víctimas por texto en campos
     * @param string $texto Texto a buscar
     * @return array Lista de víctimas encontradas
     */
    public static function buscar($texto) {
        $conexion = BaseDatos::getConexion();
        
        $busqueda = '%' . $texto . '%';
        
        $sql = "SELECT id, nombre, apellidos, tipo_documento, numero_documento, telefono, observaciones 
                FROM victimas 
                WHERE nombre LIKE :texto1 
                OR apellidos LIKE :texto2 
                OR telefono LIKE :texto3 
                OR observaciones LIKE :texto4 
                OR numero_documento LIKE :texto5";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':texto1' => $busqueda,
            ':texto2' => $busqueda,
            ':texto3' => $busqueda,
            ':texto4' => $busqueda,
            ':texto5' => $busqueda
        ]);
        
        return $stmt->fetchAll();
    }
}
