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
     * Obtener productos activos para el catálogo
     */
    public function obtenerCatalogo($limite = null, $offset = 0) {
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
                WHERE p.estado = 'activo'
                ORDER BY p.destacado DESC, p.fecha_creacion DESC";
        
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
     * Buscar productos
     */
    public function buscar($termino, $limite = null) {
        $termino = "%{$termino}%";
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
                WHERE p.estado = 'activo' 
                AND (p.nombre LIKE :termino OR p.descripcion LIKE :termino OR m.nombre LIKE :termino)
                ORDER BY p.nombre ASC";
        
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
        
        // Ordenamiento
        $orden = $filtros['orden'] ?? 'reciente';
        switch ($orden) {
            case 'precio_asc':
                $sql .= " ORDER BY p.precio ASC";
                break;
            case 'precio_desc':
                $sql .= " ORDER BY p.precio DESC";
                break;
            case 'nombre':
                $sql .= " ORDER BY p.nombre ASC";
                break;
            default:
                $sql .= " ORDER BY p.fecha_creacion DESC";
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $param => &$valor) {
            $stmt->bindParam($param, $valor);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener productos destacados
     */
    public function obtenerDestacados($limite = 8) {
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
                WHERE p.estado = 'activo' AND p.destacado = 1
                ORDER BY RAND()
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener productos por categoría
     */
    public function obtenerPorCategoria($categoriaId, $limite = null) {
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
                WHERE p.categoria_id = :categoria_id AND p.estado = 'activo'
                ORDER BY p.fecha_creacion DESC";
        
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
    public function actualizarStock($productoId, $cantidad) {
        $sql = "UPDATE {$this->tabla} SET stock = stock + :cantidad WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id', $productoId);
        return $stmt->execute();
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
    public function generarCodigoSKU($categoriaId) {
        $prefijo = 'TF-' . str_pad($categoriaId, 3, '0', STR_PAD_LEFT) . '-';
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
     * Actualizar stock de producto
     */
    public function actualizarStock($productoId, $nuevoStock) {
        $sql = "UPDATE {$this->tabla} SET stock = :stock WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock', $nuevoStock);
        $stmt->bindParam(':id', $productoId);
        return $stmt->execute();
    }
}
?>

