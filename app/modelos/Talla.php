<?php
/**
 * Modelo Talla
 */
class Talla extends Modelo {
    protected $tabla = 'tallas';
    
    /**
     * Obtener tallas activas ordenadas
     */
    public function obtenerActivas() {
        $sql = "SELECT * FROM {$this->tabla} WHERE estado = 'activo' ORDER BY orden, nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener talla por nombre
     */
    public function obtenerPorNombre($nombre) {
        $sql = "SELECT * FROM {$this->tabla} WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>
