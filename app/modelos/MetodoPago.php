<?php
/**
 * Modelo MetodoPago
 */
class MetodoPago extends Modelo {
    protected $tabla = 'metodos_pago';
    
    /**
     * Obtener métodos de pago activos
     */
    public function obtenerActivos() {
        $sql = "SELECT * FROM {$this->tabla} WHERE activo = 1 ORDER BY nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener método de pago por nombre
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
