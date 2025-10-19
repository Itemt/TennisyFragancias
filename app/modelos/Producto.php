<?php
/**
 * Modelo Producto
 */
class Producto extends Modelo {
    protected $tabla = 'productos';
    
    /**
     * Obtener productos con información normalizada
     */
    public function obtenerTodos() {
        $sql = "SELECT p.*, 
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM {$this->tabla} p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                ORDER BY p.fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener producto con información normalizada
     */
    public function obtenerPorId($id) {
        $sql = "SELECT p.*, 
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM {$this->tabla} p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Obtener todas las variantes de un producto por nombre
     */
    public function obtenerVariantesPorNombre($nombre) {
        $sql = "SELECT p.*, 
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM {$this->tabla} p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.nombre = :nombre AND p.estado = 'activo'
                ORDER BY t.orden ASC, t.nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener todas las variantes de un producto por su ID
     */
    public function obtenerVariantesPorId($productoId) {
        $sql = "SELECT p.*, 
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM {$this->tabla} p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.id = :producto_id AND p.estado = 'activo'
                ORDER BY t.orden ASC, t.nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener producto con todas sus variantes
     */
    public function obtenerConVariantes($id) {
        // Primero obtener el producto base
        $producto = $this->obtenerPorId($id);
        
        if (!$producto) {
            return null;
        }
        
        // Obtener todas las variantes del mismo nombre
        $variantes = $this->obtenerVariantesPorNombre($producto['nombre']);
        
        // Calcular stock total
        $stockTotal = 0;
        foreach ($variantes as $variante) {
            $stockTotal += $variante['stock'];
        }
        
        // Agregar información de variantes al producto base
        $producto['variantes'] = $variantes;
        $producto['stock_total'] = $stockTotal;
        $producto['tallas_disponibles'] = [];
        
        // Extraer tallas disponibles
        foreach ($variantes as $variante) {
            if ($variante['talla_id'] && $variante['stock'] > 0) {
                $producto['tallas_disponibles'][] = [
                    'talla_id' => $variante['talla_id'],
                    'nombre' => $variante['talla_nombre'],
                    'stock' => $variante['stock'],
                    'producto_id' => $variante['id']
                ];
            }
        }
        
        return $producto;
    }
    
    /**
     * Obtener productos agrupados por nombre para gestión de stock
     */
    public function obtenerProductosAgrupados() {
        // Obtener productos únicos por nombre usando subconsulta
        $sql = "SELECT 
                    p_agrupado.id,
                    p_agrupado.nombre,
                    p_agrupado.codigo_sku,
                    p_agrupado.imagen_principal,
                    p_agrupado.precio,
                    p_agrupado.categoria_nombre,
                    p_agrupado.marca_nombre,
                    p_agrupado.total_variantes,
                    p_agrupado.stock_total
                FROM (
                    SELECT 
                        MIN(p.id) as id,
                        p.nombre,
                        MIN(p.codigo_sku) as codigo_sku,
                        MIN(p.imagen_principal) as imagen_principal,
                        MIN(p.precio) as precio,
                        MIN(c.nombre) as categoria_nombre,
                        MIN(m.nombre) as marca_nombre,
                        COUNT(DISTINCT p.id) as total_variantes,
                        SUM(p.stock) as stock_total
                    FROM {$this->tabla} p 
                    INNER JOIN categorias c ON p.categoria_id = c.id 
                    LEFT JOIN marcas m ON p.marca_id = m.id
                    WHERE p.estado = 'activo'
                    GROUP BY p.nombre
                ) as p_agrupado
                ORDER BY p_agrupado.nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll();
        
        // Debug: Log para verificar los resultados
        error_log('Productos agrupados encontrados: ' . count($resultados));
        if (count($resultados) > 0) {
            error_log('Primer producto: ' . json_encode($resultados[0]));
        }
        
        return $resultados;
    }
    
    /**
     * Obtener productos activos para el catálogo (agrupados por nombre)
     */
    public function obtenerCatalogo($limite = null, $offset = 0) {
        $sql = "SELECT 
                    p_agrupado.id,
                    p_agrupado.nombre,
                    p_agrupado.codigo_sku,
                    p_agrupado.imagen_principal,
                    p_agrupado.precio,
                    p_agrupado.precio_oferta,
                    p_agrupado.categoria_nombre,
                    p_agrupado.marca_nombre,
                    p_agrupado.total_variantes,
                    p_agrupado.stock_total,
                    p_agrupado.destacado,
                    p_agrupado.fecha_creacion
                FROM (
                    SELECT 
                        MIN(p.id) as id,
                        p.nombre,
                        MIN(p.codigo_sku) as codigo_sku,
                        MIN(p.imagen_principal) as imagen_principal,
                        MIN(p.precio) as precio,
                        MIN(p.precio_oferta) as precio_oferta,
                        MIN(c.nombre) as categoria_nombre,
                        MIN(m.nombre) as marca_nombre,
                        COUNT(DISTINCT p.id) as total_variantes,
                        SUM(p.stock) as stock_total,
                        MAX(p.destacado) as destacado,
                        MIN(p.fecha_creacion) as fecha_creacion
                    FROM {$this->tabla} p 
                    INNER JOIN categorias c ON p.categoria_id = c.id 
                    LEFT JOIN marcas m ON p.marca_id = m.id
                    WHERE p.estado = 'activo'
                    GROUP BY p.nombre
                    HAVING SUM(p.stock) > 0 AND SUM(CASE WHEN p.talla_id IS NOT NULL THEN 1 ELSE 0 END) > 0
                ) as p_agrupado
                ORDER BY p_agrupado.destacado DESC, p_agrupado.fecha_creacion DESC";
        
        if ($limite) {
            $sql .= " LIMIT :limite OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if ($limite) {
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Buscar productos (agrupados por nombre)
     */
    public function buscar($termino, $limite = null) {
        $termino = "%{$termino}%";
        $sql = "SELECT 
                    p_agrupado.id,
                    p_agrupado.nombre,
                    p_agrupado.codigo_sku,
                    p_agrupado.imagen_principal,
                    p_agrupado.precio,
                    p_agrupado.precio_oferta,
                    p_agrupado.categoria_nombre,
                    p_agrupado.marca_nombre,
                    p_agrupado.total_variantes,
                    p_agrupado.stock_total
                FROM (
                    SELECT 
                        MIN(p.id) as id,
                        p.nombre,
                        MIN(p.codigo_sku) as codigo_sku,
                        MIN(p.imagen_principal) as imagen_principal,
                        MIN(p.precio) as precio,
                        MIN(p.precio_oferta) as precio_oferta,
                        MIN(c.nombre) as categoria_nombre,
                        MIN(m.nombre) as marca_nombre,
                        COUNT(DISTINCT p.id) as total_variantes,
                        SUM(p.stock) as stock_total
                    FROM {$this->tabla} p 
                    INNER JOIN categorias c ON p.categoria_id = c.id 
                    LEFT JOIN marcas m ON p.marca_id = m.id
                    WHERE p.estado = 'activo' 
                    AND (p.nombre LIKE :termino OR p.descripcion LIKE :termino OR m.nombre LIKE :termino)
                    GROUP BY p.nombre
                    HAVING SUM(p.stock) > 0 AND SUM(CASE WHEN p.talla_id IS NOT NULL THEN 1 ELSE 0 END) > 0
                ) as p_agrupado
                ORDER BY p_agrupado.nombre ASC";
        
        if ($limite) {
            $sql .= " LIMIT :limite";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':termino', $termino);
        
        if ($limite) {
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Filtrar productos
     */
    public function filtrar($filtros = []) {
        $sql = "SELECT 
                    p_agrupado.id,
                    p_agrupado.nombre,
                    p_agrupado.codigo_sku,
                    p_agrupado.imagen_principal,
                    p_agrupado.precio,
                    p_agrupado.precio_oferta,
                    p_agrupado.categoria_nombre,
                    p_agrupado.marca_nombre,
                    p_agrupado.total_variantes,
                    p_agrupado.stock_total,
                    p_agrupado.fecha_creacion
                FROM (
                    SELECT 
                        MIN(p.id) as id,
                        p.nombre,
                        MIN(p.codigo_sku) as codigo_sku,
                        MIN(p.imagen_principal) as imagen_principal,
                        MIN(p.precio) as precio,
                        MIN(p.precio_oferta) as precio_oferta,
                        MIN(c.nombre) as categoria_nombre,
                        MIN(m.nombre) as marca_nombre,
                        COUNT(DISTINCT p.id) as total_variantes,
                        SUM(p.stock) as stock_total,
                        MIN(p.fecha_creacion) as fecha_creacion
                    FROM {$this->tabla} p 
                    INNER JOIN categorias c ON p.categoria_id = c.id 
                    LEFT JOIN marcas m ON p.marca_id = m.id
                    LEFT JOIN tallas t ON p.talla_id = t.id
                    LEFT JOIN colores co ON p.color_id = co.id
                    LEFT JOIN generos g ON p.genero_id = g.id
                    WHERE p.estado = 'activo'";
        
        $params = [];
        
        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtros['categoria_id'];
        }
        
        if (!empty($filtros['genero_id'])) {
            $sql .= " AND p.genero_id = :genero_id";
            $params[':genero_id'] = $filtros['genero_id'];
        }
        
        if (!empty($filtros['marca_id'])) {
            $sql .= " AND p.marca_id = :marca_id";
            $params[':marca_id'] = $filtros['marca_id'];
        }
        
        if (!empty($filtros['color_id'])) {
            $sql .= " AND p.color_id = :color_id";
            $params[':color_id'] = $filtros['color_id'];
        }
        
        if (!empty($filtros['talla_id'])) {
            $sql .= " AND p.talla_id = :talla_id";
            $params[':talla_id'] = $filtros['talla_id'];
        }
        
        if (!empty($filtros['precio_min'])) {
            $sql .= " AND p.precio >= :precio_min";
            $params[':precio_min'] = $filtros['precio_min'];
        }
        
        if (!empty($filtros['precio_max'])) {
            $sql .= " AND p.precio <= :precio_max";
            $params[':precio_max'] = $filtros['precio_max'];
        }
        
        $sql .= " GROUP BY p.nombre";
        $sql .= " HAVING SUM(p.stock) > 0 AND SUM(CASE WHEN p.talla_id IS NOT NULL THEN 1 ELSE 0 END) > 0";
        
        $sql .= ") as p_agrupado";
        
        // Ordenamiento
        $orden = $filtros['orden'] ?? 'reciente';
        switch ($orden) {
            case 'precio_asc':
                $sql .= " ORDER BY p_agrupado.precio ASC";
                break;
            case 'precio_desc':
                $sql .= " ORDER BY p_agrupado.precio DESC";
                break;
            case 'nombre':
                $sql .= " ORDER BY p_agrupado.nombre ASC";
                break;
            default:
                $sql .= " ORDER BY p_agrupado.fecha_creacion DESC";
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $param => &$valor) {
            $stmt->bindParam($param, $valor);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener productos destacados (agrupados por nombre)
     */
    public function obtenerDestacados($limite = 8) {
        $sql = "SELECT 
                    p_agrupado.id,
                    p_agrupado.nombre,
                    p_agrupado.codigo_sku,
                    p_agrupado.imagen_principal,
                    p_agrupado.precio,
                    p_agrupado.precio_oferta,
                    p_agrupado.categoria_nombre,
                    p_agrupado.marca_nombre,
                    p_agrupado.total_variantes,
                    p_agrupado.stock_total
                FROM (
                    SELECT 
                        MIN(p.id) as id,
                        p.nombre,
                        MIN(p.codigo_sku) as codigo_sku,
                        MIN(p.imagen_principal) as imagen_principal,
                        MIN(p.precio) as precio,
                        MIN(p.precio_oferta) as precio_oferta,
                        MIN(c.nombre) as categoria_nombre,
                        MIN(m.nombre) as marca_nombre,
                        COUNT(DISTINCT p.id) as total_variantes,
                        SUM(p.stock) as stock_total
                    FROM {$this->tabla} p 
                    INNER JOIN categorias c ON p.categoria_id = c.id 
                    LEFT JOIN marcas m ON p.marca_id = m.id
                    WHERE p.estado = 'activo' AND p.destacado = 1
                    GROUP BY p.nombre
                    HAVING SUM(p.stock) > 0 AND SUM(CASE WHEN p.talla_id IS NOT NULL THEN 1 ELSE 0 END) > 0
                ) as p_agrupado
                ORDER BY RAND()
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener productos por categoría (agrupados por nombre)
     */
    public function obtenerPorCategoria($categoriaId, $limite = null) {
        $sql = "SELECT 
                    MIN(p.id) as id,
                    p.nombre,
                    MIN(p.codigo_sku) as codigo_sku,
                    MIN(p.imagen_principal) as imagen_principal,
                    MIN(p.precio) as precio,
                    MIN(p.precio_oferta) as precio_oferta,
                    MIN(c.nombre) as categoria_nombre,
                    MIN(m.nombre) as marca_nombre,
                    COUNT(DISTINCT p.id) as total_variantes,
                    SUM(p.stock) as stock_total,
                    MIN(p.fecha_creacion) as fecha_creacion
                FROM {$this->tabla} p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                LEFT JOIN marcas m ON p.marca_id = m.id
                WHERE p.categoria_id = :categoria_id AND p.estado = 'activo'
                GROUP BY p.nombre
                HAVING SUM(p.stock) > 0 AND SUM(CASE WHEN p.talla_id IS NOT NULL THEN 1 ELSE 0 END) > 0
                ORDER BY MIN(p.fecha_creacion) DESC";
        
        if ($limite) {
            $sql .= " LIMIT :limite";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoriaId);
        
        if ($limite) {
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Actualizar stock
     */
    public function actualizarStock($productoId, $cantidad, $motivo = 'Actualización manual', $usuarioId = null) {
        // Obtener stock actual
        $stockActual = $this->obtenerStock($productoId);
        if ($stockActual === false) {
            return false;
        }
        
        $stockNuevo = $stockActual + $cantidad;
        
        // Actualizar stock
        $sql = "UPDATE {$this->tabla} SET stock = stock + :cantidad WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id', $productoId);
        
        if ($stmt->execute()) {
            // Registrar en historial
            $this->registrarMovimientoStock($productoId, $cantidad, $motivo, $stockActual, $stockNuevo, $usuarioId);
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener stock actual de un producto
     */
    private function obtenerStock($productoId) {
        $sql = "SELECT stock FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $productoId);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado ? $resultado['stock'] : false;
    }
    
    /**
     * Registrar movimiento en historial
     */
    private function registrarMovimientoStock($productoId, $cantidad, $motivo, $stockAnterior, $stockNuevo, $usuarioId) {
        $tipo = $cantidad > 0 ? 'entrada' : 'salida';
        $cantidadAbsoluta = abs($cantidad);
        
        $sql = "INSERT INTO historial_stock (producto_id, usuario_id, tipo, cantidad, stock_anterior, stock_nuevo, motivo) 
                VALUES (:producto_id, :usuario_id, :tipo, :cantidad, :stock_anterior, :stock_nuevo, :motivo)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':cantidad', $cantidadAbsoluta);
        $stmt->bindParam(':stock_anterior', $stockAnterior);
        $stmt->bindParam(':stock_nuevo', $stockNuevo);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->execute();
    }
    
    /**
     * Verificar disponibilidad de stock
     */
    public function verificarStock($productoId, $cantidad) {
        $sql = "SELECT stock FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $productoId);
        $stmt->execute();
        $producto = $stmt->fetch();
        
        return $producto && $producto['stock'] >= $cantidad;
    }
    
    /**
     * Obtener variante específica por talla
     */
    public function obtenerVariantePorTalla($productoId, $tallaId) {
        // Primero obtener el nombre del producto principal
        $sql = "SELECT nombre FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $productoId);
        $stmt->execute();
        $producto = $stmt->fetch();
        
        if (!$producto) {
            return false;
        }
        
        // Buscar la variante específica con el mismo nombre y la talla especificada
        $sql = "SELECT * FROM {$this->tabla} WHERE nombre = :nombre AND talla_id = :talla_id AND estado = 'activo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $producto['nombre']);
        $stmt->bindParam(':talla_id', $tallaId);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Obtener productos con stock bajo
     */
    public function obtenerStockBajo() {
        $sql = "SELECT p.*, 
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM {$this->tabla} p 
                INNER JOIN categorias c ON p.categoria_id = c.id 
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.stock <= p.stock_minimo AND p.estado != 'inactivo'
                ORDER BY p.stock ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener marcas disponibles (ahora desde tabla normalizada)
     */
    public function obtenerMarcas() {
        $sql = "SELECT DISTINCT m.nombre 
                FROM {$this->tabla} p 
                INNER JOIN marcas m ON p.marca_id = m.id 
                WHERE p.estado = 'activo' AND m.estado = 'activo'
                ORDER BY m.nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Obtener estadísticas de productos
     */
    public function obtenerEstadisticas() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) as activos,
                    SUM(CASE WHEN estado = 'agotado' THEN 1 ELSE 0 END) as agotados,
                    SUM(stock) as stock_total,
                    AVG(precio) as precio_promedio
                FROM {$this->tabla}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Generar código SKU único
     */
    public function generarCodigoSKU($categoriaId, $tallaId = null) {
        $prefijo = 'TF-' . str_pad($categoriaId, 3, '0', STR_PAD_LEFT);
        
        if ($tallaId) {
            $prefijo .= '-' . str_pad($tallaId, 2, '0', STR_PAD_LEFT);
        }
        
        $prefijo .= '-';
        $numero = 1;
        
        do {
            $sku = $prefijo . str_pad($numero, 4, '0', STR_PAD_LEFT);
            $sql = "SELECT COUNT(*) as total FROM {$this->tabla} WHERE codigo_sku = :sku";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $numero++;
        } while ($resultado['total'] > 0);
        
        return $sku;
    }
    
    /**
     * Eliminar producto y todas sus referencias
     */
    public function eliminar($id) {
        try {
            // Iniciar transacción
            $this->db->beginTransaction();
            
            // 1. Obtener el nombre del producto para eliminar todas sus variantes
            $sql = "SELECT nombre FROM {$this->tabla} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $producto = $stmt->fetch();
            
            if (!$producto) {
                $this->db->rollBack();
                return false;
            }
            
            $nombreProducto = $producto['nombre'];
            
            // 2. Obtener todos los IDs de productos con el mismo nombre (todas las variantes)
            $sql = "SELECT id FROM {$this->tabla} WHERE nombre = :nombre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombreProducto);
            $stmt->execute();
            $productosIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (empty($productosIds)) {
                $this->db->rollBack();
                return false;
            }
            
            // 3. Crear placeholders para la consulta IN
            $placeholders = str_repeat('?,', count($productosIds) - 1) . '?';
            
            // 4. Eliminar del carrito todas las variantes
            $sql = "DELETE FROM carrito WHERE producto_id IN ($placeholders)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($productosIds);
            
            // 5. Eliminar del historial de stock todas las variantes
            $sql = "DELETE FROM historial_stock WHERE producto_id IN ($placeholders)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($productosIds);
            
            // 6. Eliminar de detalle_pedidos todas las variantes
            $sql = "DELETE FROM detalle_pedidos WHERE producto_id IN ($placeholders)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($productosIds);
            
            // 7. Finalmente eliminar todas las variantes del producto
            $sql = "DELETE FROM {$this->tabla} WHERE nombre = ?";
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute([$nombreProducto]);
            
            // Confirmar transacción
            $this->db->commit();
            
            return $resultado;
            
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->db->rollBack();
            error_log('Error al eliminar producto: ' . $e->getMessage());
            return false;
        }
    }
}
