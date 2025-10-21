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
        $sql = "SELECT c.*, p.nombre, p.imagen_principal, p.stock, p.estado, cat.nombre as categoria_nombre,
                       t.nombre as talla_nombre
                FROM {$this->tabla} c
                INNER JOIN productos p ON c.producto_id = p.id
                INNER JOIN categorias cat ON p.categoria_id = cat.id
                LEFT JOIN tallas t ON c.talla_id = t.id
                WHERE c.usuario_id = :usuario_id
                ORDER BY c.fecha_agregado DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Agregar producto al carrito
     */
    public function agregarProducto($usuarioId, $productoId, $cantidad, $precioUnitario, $tallaId = null) {
        // Verificar si el producto ya está en el carrito con la misma talla
        $sql = "SELECT * FROM {$this->tabla} WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
        if ($tallaId) {
            $sql .= " AND talla_id = :talla_id";
        } else {
            $sql .= " AND talla_id IS NULL";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':producto_id', $productoId);
        if ($tallaId) {
            $stmt->bindParam(':talla_id', $tallaId);
        }
        $stmt->execute();
        $item = $stmt->fetch();
        
        if ($item) {
            // Actualizar cantidad
            $sql = "UPDATE {$this->tabla} SET cantidad = cantidad + :cantidad WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':id', $item['id']);
            return $stmt->execute();
        } else {
            // Insertar nuevo item
            $datos = [
                'usuario_id' => $usuarioId,
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio' => $precioUnitario,
                'talla_id' => $tallaId
            ];
            return $this->crear($datos);
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
