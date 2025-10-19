<?php
/**
 * Modelo Pedido
 */
class Pedido extends Modelo {
    protected $tabla = 'pedidos';
    
    /**
     * Crear nuevo pedido
     */
    public function crearPedido($datos) {
        // Generar número de pedido único
        $datos['numero_pedido'] = $this->generarNumeroPedido();
        return $this->crear($datos);
    }
    
    /**
     * Generar número de pedido único
     */
    private function generarNumeroPedido() {
        $prefijo = 'PED-' . date('Ymd') . '-';
        $numero = 1;
        
        do {
            $numeroPedido = $prefijo . str_pad($numero, 4, '0', STR_PAD_LEFT);
            $sql = "SELECT COUNT(*) as total FROM {$this->tabla} WHERE numero_pedido = :numero";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':numero', $numeroPedido);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $numero++;
        } while ($resultado['total'] > 0);
        
        return $numeroPedido;
    }
    
    /**
     * Obtener pedidos de un usuario
     */
    public function obtenerPorUsuario($usuarioId, $limite = null) {
        $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = :usuario_id ORDER BY fecha_pedido DESC";
        
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
     * Obtener pedido con detalles
     */
    public function obtenerConDetalles($pedidoId) {
        $sql = "SELECT p.*, 
                u.nombre as cliente_nombre, u.apellido as cliente_apellido, 
                u.email as cliente_email, u.telefono as cliente_telefono,
                e.nombre as empleado_nombre, e.apellido as empleado_apellido
                FROM {$this->tabla} p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                LEFT JOIN usuarios e ON p.empleado_id = e.id
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $pedidoId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Obtener todos los pedidos con información del cliente
     */
    public function obtenerTodosConCliente($filtros = []) {
        $sql = "SELECT p.*, 
                u.nombre as cliente_nombre, u.apellido as cliente_apellido,
                e.nombre as empleado_nombre, e.apellido as empleado_apellido
                FROM {$this->tabla} p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                LEFT JOIN usuarios e ON p.empleado_id = e.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filtros['estado'])) {
            $sql .= " AND p.estado = :estado";
            $params[':estado'] = $filtros['estado'];
        }
        
        if (!empty($filtros['tipo_pedido'])) {
            $sql .= " AND p.tipo_pedido = :tipo_pedido";
            $params[':tipo_pedido'] = $filtros['tipo_pedido'];
        }
        
        if (!empty($filtros['empleado_id'])) {
            $sql .= " AND p.empleado_id = :empleado_id";
            $params[':empleado_id'] = $filtros['empleado_id'];
        }
        
        if (!empty($filtros['fecha_desde'])) {
            $sql .= " AND DATE(p.fecha_pedido) >= :fecha_desde";
            $params[':fecha_desde'] = $filtros['fecha_desde'];
        }
        
        if (!empty($filtros['fecha_hasta'])) {
            $sql .= " AND DATE(p.fecha_pedido) <= :fecha_hasta";
            $params[':fecha_hasta'] = $filtros['fecha_hasta'];
        }
        
        $sql .= " ORDER BY p.fecha_pedido DESC";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $param => &$valor) {
            $stmt->bindParam($param, $valor);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener pedidos asignados a un empleado
     */
    public function obtenerPorEmpleado($empleadoId, $estado = null) {
        $sql = "SELECT p.*, u.nombre as cliente_nombre, u.apellido as cliente_apellido
                FROM {$this->tabla} p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.empleado_id = :empleado_id";
        
        if ($estado) {
            $sql .= " AND p.estado = :estado";
        }
        
        $sql .= " ORDER BY p.fecha_pedido DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':empleado_id', $empleadoId);
        
        if ($estado) {
            $stmt->bindParam(':estado', $estado);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Actualizar estado del pedido
     */
    public function actualizarEstado($pedidoId, $estadoNuevo) {
        $campos = ['estado' => $estadoNuevo];
        
        // Actualizar fechas según el estado
        if ($estadoNuevo === 'enviado') {
            $campos['fecha_envio'] = date('Y-m-d H:i:s');
        } elseif ($estadoNuevo === 'entregado') {
            $campos['fecha_entrega'] = date('Y-m-d H:i:s');
        }
        
        return $this->actualizar($pedidoId, $campos);
    }
    
    /**
     * Asignar empleado a pedido
     */
    public function asignarEmpleado($pedidoId, $empleadoId) {
        $sql = "UPDATE {$this->tabla} SET empleado_id = :empleado_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':empleado_id', $empleadoId);
        $stmt->bindParam(':id', $pedidoId);
        return $stmt->execute();
    }
    
    /**
     * Obtener estadísticas de pedidos
     */
    public function obtenerEstadisticas($fechaDesde = null, $fechaHasta = null) {
        $sql = "SELECT 
                    COUNT(*) as total_pedidos,
                    SUM(total) as total_ventas,
                    AVG(total) as ticket_promedio,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN estado = 'enviado' THEN 1 ELSE 0 END) as enviados,
                    SUM(CASE WHEN estado = 'entregado' THEN 1 ELSE 0 END) as entregados,
                    SUM(CASE WHEN estado = 'cancelado' THEN 1 ELSE 0 END) as cancelados,
                    SUM(CASE WHEN tipo_pedido = 'online' THEN 1 ELSE 0 END) as online,
                    SUM(CASE WHEN tipo_pedido = 'presencial' THEN 1 ELSE 0 END) as presencial
                FROM {$this->tabla}
                WHERE 1=1";
        
        $params = [];
        
        if ($fechaDesde) {
            $sql .= " AND DATE(fecha_pedido) >= :fecha_desde";
            $params[':fecha_desde'] = $fechaDesde;
        }
        
        if ($fechaHasta) {
            $sql .= " AND DATE(fecha_pedido) <= :fecha_hasta";
            $params[':fecha_hasta'] = $fechaHasta;
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $param => &$valor) {
            $stmt->bindParam($param, $valor);
        }
        
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Obtener ventas por mes
     */
    public function obtenerVentasPorMes($anio = null) {
        if (!$anio) {
            $anio = date('Y');
        }
        
        $sql = "SELECT 
                    MONTH(fecha_pedido) as mes,
                    COUNT(*) as total_pedidos,
                    SUM(total) as total_ventas
                FROM {$this->tabla}
                WHERE YEAR(fecha_pedido) = :anio AND estado != 'cancelado'
                GROUP BY MONTH(fecha_pedido)
                ORDER BY mes ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':anio', $anio);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener todos los pedidos (método básico)
     */
    public function obtenerTodos($filtros = []) {
        $sql = "SELECT p.*, 
                u.nombre as usuario_nombre, u.apellido as usuario_apellido,
                e.nombre as empleado_nombre, e.apellido as empleado_apellido
                FROM {$this->tabla} p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                LEFT JOIN usuarios e ON p.empleado_id = e.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filtros['estado'])) {
            $sql .= " AND p.estado = :estado";
            $params[':estado'] = $filtros['estado'];
        }
        
        if (!empty($filtros['buscar'])) {
            $sql .= " AND (u.nombre LIKE :buscar OR u.apellido LIKE :buscar OR u.email LIKE :buscar)";
            $params[':buscar'] = '%' . $filtros['buscar'] . '%';
        }
        
        $sql .= " ORDER BY p.fecha_pedido DESC";
        
        // Paginación
        if (!empty($filtros['pagina']) && $filtros['pagina'] > 1) {
            $offset = ($filtros['pagina'] - 1) * 20;
            $sql .= " LIMIT 20 OFFSET :offset";
            $params[':offset'] = $offset;
        } else {
            $sql .= " LIMIT 20";
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $param => &$valor) {
            $stmt->bindParam($param, $valor);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtener pedidos recientes
     */
    public function obtenerRecientes($limite = 10) {
        $sql = "SELECT p.*, u.nombre as cliente_nombre, u.apellido as cliente_apellido
                FROM {$this->tabla} p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                ORDER BY p.fecha_pedido DESC
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
