<?php
/**
 * Modelo EstadoPedido
 */
class EstadoPedido extends Modelo {
    protected $tabla = 'estados_pedido';
    
    /**
     * Obtener estados ordenados
     */
    public function obtenerOrdenados() {
        $sql = "SELECT * FROM {$this->tabla} ORDER BY orden, nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener estado por nombre
     */
    public function obtenerPorNombre($nombre) {
        $sql = "SELECT * FROM {$this->tabla} WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Obtener estados no finales
     */
    public function obtenerNoFinales() {
        $sql = "SELECT * FROM {$this->tabla} WHERE es_final = 0 ORDER BY orden";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
