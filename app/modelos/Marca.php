<?php
/**
 * Modelo Marca
 */
class Marca extends Modelo {
    protected $tabla = 'marcas';
    
    /**
     * Obtener marcas activas
     */
    public function obtenerActivas() {
        $sql = "SELECT * FROM {$this->tabla} WHERE estado = 'activo' ORDER BY nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener marca por nombre
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
