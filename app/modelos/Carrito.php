<?php
/**
 * Modelo Carrito
 */
class Carrito extends Modelo {
    protected $tabla = 'carrito';
    
    /**
     * Obtener items del carrito de un usuario
     */
    public function obtenerItemsUsuario($usuarioId) {
        // Primero verificar si la columna talla_id existe
        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM {$this->tabla} LIKE 'talla_id'");
            $tallaIdExists = $stmt->fetch();
            
            if ($tallaIdExists) {
                // Si la columna existe, usar la consulta completa
                $sql = "SELECT c.*, p.nombre, p.imagen_principal, p.stock, p.estado, cat.nombre as categoria_nombre,
                               t.nombre as talla_nombre
                        FROM {$this->tabla} c
                        INNER JOIN productos p ON c.producto_id = p.id
                        INNER JOIN categorias cat ON p.categoria_id = cat.id
                        LEFT JOIN tallas t ON c.talla_id = t.id
                        WHERE c.usuario_id = :usuario_id
                        ORDER BY c.fecha_agregado DESC";
            } else {
                // Si la columna no existe, usar consulta sin talla
                $sql = "SELECT c.*, p.nombre, p.imagen_principal, p.stock, p.estado, cat.nombre as categoria_nombre,
                               NULL as talla_nombre
                        FROM {$this->tabla} c
                        INNER JOIN productos p ON c.producto_id = p.id
                        INNER JOIN categorias cat ON p.categoria_id = cat.id
                        WHERE c.usuario_id = :usuario_id
                        ORDER BY c.fecha_agregado DESC";
            }
        } catch (Exception $e) {
            // En caso de error, usar consulta sin talla
            $sql = "SELECT c.*, p.nombre, p.imagen_principal, p.stock, p.estado, cat.nombre as categoria_nombre,
                           NULL as talla_nombre
                    FROM {$this->tabla} c
                    INNER JOIN productos p ON c.producto_id = p.id
                    INNER JOIN categorias cat ON p.categoria_id = cat.id
                    WHERE c.usuario_id = :usuario_id
                    ORDER BY c.fecha_agregado DESC";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Agregar producto al carrito
     */
    public function agregarProducto($usuarioId, $productoId, $cantidad, $precioUnitario, $tallaId = null) {
        // Verificar si la columna talla_id existe
        try {
            $stmt = $this->db->query("SHOW COLUMNS FROM {$this->tabla} LIKE 'talla_id'");
            $tallaIdExists = $stmt->fetch();
        } catch (Exception $e) {
            $tallaIdExists = false;
        }
        
        // Verificar si el producto ya está en el carrito
        if ($tallaIdExists && $tallaId) {
            // Si la columna existe y hay talla, verificar por talla
            $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = :usuario_id AND producto_id = :producto_id AND talla_id = :talla_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->bindParam(':producto_id', $productoId);
            $stmt->bindParam(':talla_id', $tallaId);
        } else if ($tallaIdExists) {
            // Si la columna existe pero no hay talla
            $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = :usuario_id AND producto_id = :producto_id AND talla_id IS NULL";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->bindParam(':producto_id', $productoId);
        } else {
            // Si la columna no existe, solo verificar por producto
            $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->bindParam(':producto_id', $productoId);
        }
        
        $stmt->execute();
        $item = $stmt->fetch();
        
        if ($item) {
            // Actualizar cantidad
            error_log("DEBUG CARRITO MODELO: Actualizando cantidad existente. Item ID: " . $item['id']);
            $sql = "UPDATE {$this->tabla} SET cantidad = cantidad + :cantidad WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':id', $item['id']);
            $resultado = $stmt->execute();
            error_log("DEBUG CARRITO MODELO: Resultado actualización: " . ($resultado ? 'true' : 'false'));
            return $resultado;
        } else {
            // Insertar nuevo item
            error_log("DEBUG CARRITO MODELO: Insertando nuevo item");
            $datos = [
                'usuario_id' => $usuarioId,
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio' => $precioUnitario
            ];
            
            // Solo agregar talla_id si la columna existe
            if ($tallaIdExists) {
                $datos['talla_id'] = $tallaId;
                error_log("DEBUG CARRITO MODELO: Agregando talla_id: " . $tallaId);
            } else {
                error_log("DEBUG CARRITO MODELO: No se agrega talla_id (columna no existe)");
            }
            
            error_log("DEBUG CARRITO MODELO: Datos a insertar: " . json_encode($datos));
            $resultado = $this->crear($datos);
            error_log("DEBUG CARRITO MODELO: Resultado crear: " . ($resultado ? 'true' : 'false'));
            return $resultado;
        }
    }
    
    /**
     * Actualizar cantidad de un producto en el carrito
     */
    public function actualizarCantidad($carritoId, $cantidad) {
        $sql = "UPDATE {$this->tabla} SET cantidad = :cantidad WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id', $carritoId);
        return $stmt->execute();
    }
    
    /**
     * Eliminar producto del carrito
     */
    public function eliminarProducto($carritoId, $usuarioId) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $carritoId);
        $stmt->bindParam(':usuario_id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Vaciar carrito de un usuario
     */
    public function vaciarCarrito($usuarioId) {
        $sql = "DELETE FROM {$this->tabla} WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Contar items en el carrito
     */
    public function contarItems($usuarioId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->tabla} WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }
    
    /**
     * Calcular total del carrito
     */
    public function calcularTotal($usuarioId) {
        $sql = "SELECT SUM(cantidad * precio_unitario) as total FROM {$this->tabla} WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'] ?? 0;
    }
    
    /**
     * Verificar disponibilidad de stock para todos los items
     */
    public function verificarDisponibilidad($usuarioId) {
        $sql = "SELECT c.producto_id, c.cantidad, p.stock, p.nombre
                FROM {$this->tabla} c
                INNER JOIN productos p ON c.producto_id = p.id
                WHERE c.usuario_id = :usuario_id AND (p.stock < c.cantidad OR p.estado != 'activo')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
