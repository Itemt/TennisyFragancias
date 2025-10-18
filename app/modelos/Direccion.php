<?php
/**
 * Modelo Direccion
 */
class Direccion extends Modelo {
    protected $tabla = 'direcciones';
    
    /**
     * Obtener direcciones de un usuario
     */
    public function obtenerPorUsuario($usuarioId) {
        $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = :usuario_id ORDER BY es_principal DESC, fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener dirección principal de un usuario
     */
    public function obtenerPrincipal($usuarioId) {
        $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = :usuario_id AND es_principal = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Establecer dirección como principal
     */
    public function establecerPrincipal($direccionId, $usuarioId) {
        // Primero quitar principal de todas las direcciones del usuario
        $sql = "UPDATE {$this->tabla} SET es_principal = 0 WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        
        // Luego establecer la nueva dirección como principal
        $sql = "UPDATE {$this->tabla} SET es_principal = 1 WHERE id = :direccion_id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':direccion_id', $direccionId);
        $stmt->bindParam(':usuario_id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Agregar nueva dirección
     */
    public function agregarDireccion($usuarioId, $tipo, $direccion, $ciudad, $departamento, $codigoPostal = null, $esPrincipal = false) {
        $datos = [
            'usuario_id' => $usuarioId,
            'tipo' => $tipo,
            'direccion' => $direccion,
            'ciudad' => $ciudad,
            'departamento' => $departamento,
            'codigo_postal' => $codigoPostal,
            'es_principal' => $esPrincipal ? 1 : 0
        ];
        
        return $this->crear($datos);
    }
}
?>
