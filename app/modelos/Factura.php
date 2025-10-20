<?php
/**
 * Modelo Factura
 */
class Factura extends Modelo {
    protected $tabla = 'facturas';
    
    /**
     * Crear factura desde un pedido
     */
    public function crearDesdePedido($pedido, $empleadoId = null) {
        $numeroFactura = $this->generarNumeroFactura();
        
        $datos = [
            'numero_factura' => $numeroFactura,
            'pedido_id' => $pedido['id'],
            'usuario_id' => $pedido['usuario_id'],
            'empleado_id' => $empleadoId,
            'subtotal' => $pedido['subtotal'],
            'impuestos' => $pedido['impuestos'],
            'total' => $pedido['total'],
            'metodo_pago' => $pedido['metodo_pago']
        ];
        
        if ($this->crear($datos)) {
            return $numeroFactura;
        }
        return false;
    }
    
    /**
     * Generar número de factura único
     */
    private function generarNumeroFactura() {
        $prefijo = 'FAC-' . date('Ymd') . '-';
        $numero = 1;
        
        do {
            $numeroFactura = $prefijo . str_pad($numero, 4, '0', STR_PAD_LEFT);
            $sql = "SELECT COUNT(*) as total FROM {$this->tabla} WHERE numero_factura = :numero";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':numero', $numeroFactura);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $numero++;
        } while ($resultado['total'] > 0);
        
        return $numeroFactura;
    }
    
    /**
     * Obtener factura por número
     */
    public function obtenerPorNumero($numeroFactura) {
        try {
            // Verificar estructura de la tabla
            $stmt = $this->db->query("DESCRIBE {$this->tabla}");
            $columnas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nombresColumnas = array_column($columnas, 'Field');
            
            if (in_array('usuario_id', $nombresColumnas)) {
                // Consulta completa con usuario_id
                $sql = "SELECT f.*, 
                        u.nombre as cliente_nombre, u.apellido as cliente_apellido,
                        u.email as cliente_email, u.telefono as cliente_telefono,
                        p.id as pedido_id
                        FROM {$this->tabla} f
                        INNER JOIN usuarios u ON f.usuario_id = u.id
                        INNER JOIN pedidos p ON f.pedido_id = p.id
                        WHERE f.numero_factura = :numero";
            } else {
                // Consulta simplificada sin usuario_id
                $sql = "SELECT f.*, 
                        p.id as pedido_id
                        FROM {$this->tabla} f
                        INNER JOIN pedidos p ON f.pedido_id = p.id
                        WHERE f.numero_factura = :numero";
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':numero', $numeroFactura);
            $stmt->execute();
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            error_log("ERROR en obtenerPorNumero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener factura por pedido
     */
    public function obtenerPorPedido($pedidoId) {
        $sql = "SELECT * FROM {$this->tabla} WHERE pedido_id = :pedido_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pedido_id', $pedidoId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Obtener facturas de un usuario
     */
    public function obtenerPorUsuario($usuarioId) {
        $sql = "SELECT f.*, p.numero_pedido
                FROM {$this->tabla} f
                INNER JOIN pedidos p ON f.pedido_id = p.id
                WHERE f.usuario_id = :usuario_id
                ORDER BY f.fecha_emision DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener todas las facturas
     */
    public function obtenerTodas($limite = null) {
        $sql = "SELECT f.*, 
                u.nombre as cliente_nombre, u.apellido as cliente_apellido,
                p.id as pedido_id
                FROM {$this->tabla} f
                INNER JOIN usuarios u ON f.usuario_id = u.id
                INNER JOIN pedidos p ON f.pedido_id = p.id
                ORDER BY f.fecha_emision DESC";
        
        if ($limite) {
            $sql .= " LIMIT :limite";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if ($limite) {
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener facturas por empleado
     */
    public function obtenerPorEmpleado($empleadoId) {
        // Verificar si la columna empleado_id existe
        try {
            $stmt = $this->db->query("DESCRIBE {$this->tabla}");
            $columnas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nombresColumnas = array_column($columnas, 'Field');
            
            if (in_array('empleado_id', $nombresColumnas)) {
                // Si existe empleado_id, usar la consulta completa
                $sql = "SELECT f.*, 
                        u.nombre as cliente_nombre, u.apellido as cliente_apellido,
                        u.email as cliente_email, u.telefono as cliente_telefono,
                        p.id as pedido_id
                        FROM {$this->tabla} f
                        INNER JOIN usuarios u ON f.usuario_id = u.id
                        INNER JOIN pedidos p ON f.pedido_id = p.id
                        WHERE f.empleado_id = :empleado_id
                        ORDER BY f.fecha_emision DESC";
            } else {
                // Si no existe empleado_id, obtener todas las facturas
                $sql = "SELECT f.*, 
                        u.nombre as cliente_nombre, u.apellido as cliente_apellido,
                        u.email as cliente_email, u.telefono as cliente_telefono,
                        p.id as pedido_id
                        FROM {$this->tabla} f
                        INNER JOIN usuarios u ON f.usuario_id = u.id
                        INNER JOIN pedidos p ON f.pedido_id = p.id
                        ORDER BY f.fecha_emision DESC";
            }
            
            $stmt = $this->db->prepare($sql);
            if (in_array('empleado_id', $nombresColumnas)) {
                $stmt->bindParam(':empleado_id', $empleadoId);
            }
            $stmt->execute();
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("ERROR en obtenerPorEmpleado: " . $e->getMessage());
            return [];
        }
    }
}
?>

