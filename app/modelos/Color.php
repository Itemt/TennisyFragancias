<?php
/**
 * Modelo Color
 */
class Color extends Modelo {
    protected $tabla = 'colores';
    
    /**
     * Obtener colores activos
     */
    public function obtenerActivos() {
        $sql = "SELECT * FROM {$this->tabla} WHERE estado = 'activo' ORDER BY nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener color por nombre
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
