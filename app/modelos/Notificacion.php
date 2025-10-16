<?php
/**
 * Modelo Notificacion
 */
class Notificacion extends Modelo {
    protected $tabla = 'notificaciones';
    
    /**
     * Crear nueva notificación
     */
    public function crearNotificacion($usuarioId, $tipo, $titulo, $mensaje, $enlace = null) {
        $datos = [
            'usuario_id' => $usuarioId,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'enlace' => $enlace
        ];
        
        return $this->crear($datos);
    }
    
    /**
     * Obtener notificaciones de un usuario
     */
    public function obtenerPorUsuario($usuarioId, $limite = null) {
        $sql = "SELECT * FROM {$this->tabla} 
                WHERE usuario_id = :usuario_id 
                ORDER BY fecha_creacion DESC";
        
        if ($limite) {
            $sql .= " LIMIT :limite";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        
        if ($limite) {
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener notificaciones no leídas
     */
    public function obtenerNoLeidas($usuarioId) {
        $sql = "SELECT * FROM {$this->tabla} 
                WHERE usuario_id = :usuario_id AND leida = 0
                ORDER BY fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Contar notificaciones no leídas
     */
    public function contarNoLeidas($usuarioId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->tabla} 
                WHERE usuario_id = :usuario_id AND leida = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }
    
    /**
     * Marcar como leída
     */
    public function marcarComoLeida($notificacionId) {
        $sql = "UPDATE {$this->tabla} SET leida = 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $notificacionId);
        return $stmt->execute();
    }
    
    /**
     * Marcar todas como leídas
     */
    public function marcarTodasLeidas($usuarioId) {
        $sql = "UPDATE {$this->tabla} SET leida = 1 WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Eliminar notificaciones antiguas
     */
    public function eliminarAntiguas($dias = 30) {
        $sql = "DELETE FROM {$this->tabla} 
                WHERE leida = 1 AND fecha_creacion < DATE_SUB(NOW(), INTERVAL :dias DAY)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':dias', $dias);
        return $stmt->execute();
    }
}
?>

