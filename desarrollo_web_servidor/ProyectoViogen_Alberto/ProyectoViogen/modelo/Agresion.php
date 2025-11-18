<?php
/**
 * Modelo de Agresión
 * Gestiona las operaciones CRUD relacionadas con agresiones
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'BaseDatos.php';

class Agresion {
    
    /**
     * Registra una nueva agresión
     * @param array $datos Datos de la agresión
     * @return int|false ID de la agresión insertada o false si falla
     */
    public static function registrar($datos) {
        $conexion = BaseDatos::getConexion();
        
        $sql = "INSERT INTO agresiones (victima_id, agresor, tipo_agresion, fecha_hora, observaciones, usuario_id) 
                VALUES (:victima_id, :agresor, :tipo_agresion, :fecha_hora, :observaciones, :usuario_id)";
        
        $stmt = $conexion->prepare($sql);
        $resultado = $stmt->execute([
            ':victima_id' => $datos['victima_id'],
            ':agresor' => $datos['agresor'],
            ':tipo_agresion' => $datos['tipo_agresion'],
            ':fecha_hora' => $datos['fecha_hora'],
            ':observaciones' => $datos['observaciones'],
            ':usuario_id' => $datos['usuario_id']
        ]);
        
        if ($resultado) {
            return $conexion->lastInsertId();
        }
        return false;
    }
    
    /**
     * Busca agresiones por texto en todos los campos textuales
     * Incluye nombre, apellidos, teléfono, observaciones de víctima y agresión
     * @param string $texto Texto a buscar
     * @return array Lista de agresiones encontradas con datos de víctima
     */
    public static function buscar($texto) {
        $conexion = BaseDatos::getConexion();
        
        $busqueda = '%' . $texto . '%';
        
        $sql = "SELECT 
                    a.id,
                    CONCAT(COALESCE(v.nombre, ''), ' ', COALESCE(v.apellidos, '')) AS nombre_completo,
                    a.tipo_agresion,
                    a.fecha_hora,
                    a.agresor,
                    a.observaciones AS observaciones_agresion,
                    v.telefono,
                    v.observaciones AS observaciones_victima
                FROM agresiones a
                INNER JOIN victimas v ON a.victima_id = v.id
                WHERE v.nombre LIKE :texto1
                OR v.apellidos LIKE :texto2
                OR v.telefono LIKE :texto3
                OR v.observaciones LIKE :texto4
                OR a.agresor LIKE :texto5
                OR a.observaciones LIKE :texto6
                ORDER BY a.fecha_hora DESC";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':texto1' => $busqueda,
            ':texto2' => $busqueda,
            ':texto3' => $busqueda,
            ':texto4' => $busqueda,
            ':texto5' => $busqueda,
            ':texto6' => $busqueda
        ]);
        
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene todas las agresiones con datos de víctima
     * @return array Lista de agresiones
     */
    public static function obtenerTodas() {
        $conexion = BaseDatos::getConexion();
        
        $sql = "SELECT 
                    a.id,
                    CONCAT(COALESCE(v.nombre, ''), ' ', COALESCE(v.apellidos, '')) AS nombre_completo,
                    a.tipo_agresion,
                    a.fecha_hora,
                    a.agresor,
                    a.observaciones
                FROM agresiones a
                INNER JOIN victimas v ON a.victima_id = v.id
                ORDER BY a.fecha_hora DESC";
        
        $stmt = $conexion->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene una agresión por su ID
     * @param int $id ID de la agresión
     * @return array|false Datos de la agresión o false si no existe
     */
    public static function obtenerPorId($id) {
        $conexion = BaseDatos::getConexion();
        
        $sql = "SELECT 
                    a.*,
                    v.nombre AS victima_nombre,
                    v.apellidos AS victima_apellidos
                FROM agresiones a
                INNER JOIN victimas v ON a.victima_id = v.id
                WHERE a.id = :id";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch();
    }
}
