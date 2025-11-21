<?php
/**
 * MODELO AGRESION
 * Gestiona operaciones de agresiones
 */
class Agresion {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Registra una nueva agresión
     */
    public function crear($datos) {
        $sql = "INSERT INTO Agresion (id_victima, agresor, tipo_agresion, fecha_hora, observaciones) 
                VALUES (:id_victima, :agresor, :tipo_agresion, :fecha_hora, :observaciones)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_victima' => $datos['id_victima'],
            ':agresor' => $datos['agresor'] ?: null,
            ':tipo_agresion' => $datos['tipo_agresion'],
            ':fecha_hora' => $datos['fecha_hora'],
            ':observaciones' => $datos['observaciones'] ?: null
        ]);
    }
    
    /**
     * Busca agresiones por texto en todos los campos
     * Busca coincidencias exactas en nombre, apellidos, teléfono, etc.
     */
    public function buscar($texto) {
        $sql = "SELECT a.*, v.nombre, v.apellidos 
                FROM Agresion a 
                JOIN Victima v ON a.id_victima = v.id 
                WHERE v.nombre = :texto_exacto
                OR v.apellidos = :texto_exacto
                OR CONCAT(v.nombre, ' ', v.apellidos) = :texto_exacto
                OR CONCAT(v.apellidos, ' ', v.nombre) = :texto_exacto
                OR v.telefono = :texto_exacto
                OR a.agresor = :texto_exacto
                ORDER BY a.fecha_hora DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':texto_exacto' => $texto]);
        return $stmt->fetchAll();
    }
}
