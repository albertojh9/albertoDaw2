<?php
/**
 * Modelo Agresion
 * Gestiona las operaciones relacionadas con las agresiones
 */
class Agresion {
    
    private $db;
    private $table = 'Agresion';
    
    /**
     * Constructor - inicializa la conexión a BD
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Registra una nueva agresión
     * @param array $datos Datos de la agresión
     * @return int|false ID de la agresión creada o false si falla
     */
    public function crear($datos) {
        $sql = "INSERT INTO {$this->table} (id_victima, agresor, tipo_agresion, fecha_hora, observaciones) 
                VALUES (:id_victima, :agresor, :tipo_agresion, :fecha_hora, :observaciones)";
        
        $stmt = $this->db->prepare($sql);
        
        try {
            $stmt->execute([
                ':id_victima' => $datos['id_victima'],
                ':agresor' => $datos['agresor'] ?: null,
                ':tipo_agresion' => $datos['tipo_agresion'],
                ':fecha_hora' => $datos['fecha_hora'],
                ':observaciones' => $datos['observaciones'] ?: null
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Busca agresiones por texto en todos los campos
     * @param string $texto Texto a buscar
     * @return array Resultados encontrados
     */
    public function buscar($texto) {
        $sql = "SELECT a.*, 
                       v.nombre as victima_nombre, 
                       v.apellidos as victima_apellidos,
                       v.telefono as victima_telefono
                FROM {$this->table} a 
                JOIN Victima v ON a.id_victima = v.id 
                WHERE v.nombre LIKE :texto 
                OR v.apellidos LIKE :texto 
                OR v.telefono LIKE :texto 
                OR v.observaciones LIKE :texto 
                OR a.agresor LIKE :texto 
                OR a.observaciones LIKE :texto
                ORDER BY a.fecha_hora DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':texto' => '%' . $texto . '%']);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene todas las agresiones
     * @return array
     */
    public function obtenerTodas() {
        $sql = "SELECT a.*, v.nombre as victima_nombre, v.apellidos as victima_apellidos 
                FROM {$this->table} a 
                JOIN Victima v ON a.id_victima = v.id 
                ORDER BY a.fecha_hora DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Valida los datos de la agresión
     * @param array $datos
     * @return array Errores encontrados
     */
    public function validar($datos) {
        $errores = [];
        
        // Víctima obligatoria
        if (empty($datos['id_victima'])) {
            $errores['id_victima'] = 'Debe seleccionar una víctima';
        }
        
        // Tipo de agresión obligatorio
        if (empty($datos['tipo_agresion'])) {
            $errores['tipo_agresion'] = 'Debe seleccionar un tipo de agresión';
        } elseif (!in_array($datos['tipo_agresion'], TIPOS_AGRESION)) {
            $errores['tipo_agresion'] = 'Tipo de agresión no válido';
        }
        
        // Fecha y hora obligatorias
        if (empty($datos['fecha_hora'])) {
            $errores['fecha_hora'] = 'Debe proporcionar la fecha y hora';
        }
        
        return $errores;
    }
}
