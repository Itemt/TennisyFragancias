<?php
/**
 * Modelo DetallePedido
 */
class DetallePedido extends Modelo {
    protected $tabla = 'detalle_pedidos';
    
    /**
     * Obtener detalles de un pedido
     */
    public function obtenerPorPedido($pedidoId) {
        $sql = "SELECT dp.*, p.imagen_principal, p.codigo_sku
                FROM {$this->tabla} dp
                LEFT JOIN productos p ON dp.producto_id = p.id
                WHERE dp.pedido_id = :pedido_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pedido_id', $pedidoId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Agregar detalle de pedido
     */
    public function agregarDetalle($pedidoId, $productoId, $precioUnitario, $cantidad) {
        $subtotal = $precioUnitario * $cantidad;
        
        $datos = [
            'pedido_id' => $pedidoId,
            'producto_id' => $productoId,
            'precio_unitario' => $precioUnitario,
            'cantidad' => $cantidad,
            'subtotal' => $subtotal
        ];
        
        return $this->crear($datos);
    }
    
    /**
     * Obtener productos más vendidos
     */
    public function obtenerMasVendidos($limite = 10, $fechaDesde = null, $fechaHasta = null) {
        $sql = "SELECT 
                    dp.producto_id,
                    p.nombre as nombre_producto,
                    SUM(dp.cantidad) as total_vendido,
                    SUM(dp.subtotal) as total_ingresos,
                    p.imagen_principal,
                    p.codigo_sku
                FROM {$this->tabla} dp
                INNER JOIN pedidos pe ON dp.pedido_id = pe.id
                LEFT JOIN productos p ON dp.producto_id = p.id
                WHERE pe.estado != 'cancelado'";
        
        $params = [];
        
        if ($fechaDesde) {
            $sql .= " AND DATE(pe.fecha_pedido) >= :fecha_desde";
            $params[':fecha_desde'] = $fechaDesde;
        }
        
        if ($fechaHasta) {
            $sql .= " AND DATE(pe.fecha_pedido) <= :fecha_hasta";
            $params[':fecha_hasta'] = $fechaHasta;
        }
        
        $sql .= " GROUP BY dp.producto_id, p.nombre
                  ORDER BY total_vendido DESC
                  LIMIT :limite";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $param => &$valor) {
            $stmt->bindParam($param, $valor);
        }
        
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
