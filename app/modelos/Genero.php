<?php
/**
 * Modelo Genero
 */
class Genero extends Modelo {
    protected $tabla = 'generos';
    
    /**
     * Obtener géneros activos
     */
    public function obtenerActivos() {
        $sql = "SELECT * FROM {$this->tabla} WHERE estado = 'activo' ORDER BY nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener género por nombre
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
