<?php
/**
 * Modelo HistorialStock
 */
class HistorialStock extends Modelo {
    protected $tabla = 'historial_stock';
    
    /**
     * Registrar movimiento de stock
     */
    public function registrarMovimiento($productoId, $tipo, $cantidad, $motivo, $stockAnterior, $stockNuevo, $usuarioId = null) {
        $sql = "INSERT INTO {$this->tabla} (producto_id, usuario_id, tipo, cantidad, stock_anterior, stock_nuevo, motivo) 
                VALUES (:producto_id, :usuario_id, :tipo, :cantidad, :stock_anterior, :stock_nuevo, :motivo)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':stock_anterior', $stockAnterior);
        $stmt->bindParam(':stock_nuevo', $stockNuevo);
        $stmt->bindParam(':motivo', $motivo);
        return $stmt->execute();
    }
    
    /**
     * Obtener historial de un producto
     */
    public function obtenerPorProducto($productoId, $limite = 50) {
        $sql = "SELECT h.*, u.nombre as usuario_nombre, u.apellido as usuario_apellido
                FROM {$this->tabla} h
                LEFT JOIN usuarios u ON h.usuario_id = u.id
                WHERE h.producto_id = :producto_id
                ORDER BY h.fecha_movimiento DESC
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener historial general con filtros
     */
    public function obtenerHistorial($limite = 100, $filtros = []) {
        $sql = "SELECT h.*, p.nombre as producto_nombre, p.codigo_sku,
                u.nombre as usuario_nombre, u.apellido as usuario_apellido
                FROM {$this->tabla} h
                INNER JOIN productos p ON h.producto_id = p.id
                LEFT JOIN usuarios u ON h.usuario_id = u.id
                WHERE 1=1";
        
        $params = [];
        
        // Filtro por tipo de movimiento
        if (!empty($filtros['tipo'])) {
            $sql .= " AND h.tipo = :tipo";
            $params[':tipo'] = $filtros['tipo'];
        }
        
        // Filtro por fecha desde
        if (!empty($filtros['fecha_desde'])) {
            $sql .= " AND DATE(h.fecha_movimiento) >= :fecha_desde";
            $params[':fecha_desde'] = $filtros['fecha_desde'];
        }
        
        // Filtro por fecha hasta
        if (!empty($filtros['fecha_hasta'])) {
            $sql .= " AND DATE(h.fecha_movimiento) <= :fecha_hasta";
            $params[':fecha_hasta'] = $filtros['fecha_hasta'];
        }
        
        // Filtro por búsqueda de producto
        if (!empty($filtros['buscar'])) {
            $sql .= " AND (p.nombre LIKE :buscar OR p.codigo_sku LIKE :buscar)";
            $params[':buscar'] = '%' . $filtros['buscar'] . '%';
        }
        
        $sql .= " ORDER BY h.fecha_movimiento DESC LIMIT :limite";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener estadísticas de movimientos
     */
    public function obtenerEstadisticas($fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT 
                    COUNT(*) as total_movimientos,
                    SUM(CASE WHEN tipo = 'entrada' THEN cantidad ELSE 0 END) as total_entradas,
                    SUM(CASE WHEN tipo = 'salida' THEN cantidad ELSE 0 END) as total_salidas,
                    COUNT(DISTINCT producto_id) as productos_afectados
                FROM {$this->tabla}";
        
        $params = [];
        if ($fechaInicio) {
            $sql .= " WHERE fecha_movimiento >= :fecha_inicio";
            $params[':fecha_inicio'] = $fechaInicio;
        }
        if ($fechaFin) {
            $sql .= ($fechaInicio ? " AND" : " WHERE") . " fecha_movimiento <= :fecha_fin";
            $params[':fecha_fin'] = $fechaFin;
        }
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetch();
    }
}
