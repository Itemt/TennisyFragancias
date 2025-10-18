<?php
/**
 * Modelo Categoria
 */
class Categoria extends Modelo {
    protected $tabla = 'categorias';
    
    /**
     * Obtener categorías activas
     */
    public function obtenerActivas() {
        $sql = "SELECT * FROM {$this->tabla} WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener categoría con contador de productos
     */
    public function obtenerConContador() {
        // Unificar categorías duplicadas por nombre (mismo nombre, distintos IDs)
        $sql = "SELECT 
                    MIN(c.id) AS id,
                    c.nombre,
                    MAX(c.descripcion) AS descripcion,
                    MAX(c.imagen) AS imagen,
                    'activo' AS estado,
                    COUNT(p.id) AS total_productos
                FROM {$this->tabla} c
                LEFT JOIN productos p 
                    ON p.categoria_id = c.id 
                    AND p.estado = 'activo'
                WHERE c.estado = 'activo'
                GROUP BY c.nombre
                ORDER BY c.nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Verificar si la categoría tiene productos
     */
    public function tieneProductos($categoriaId) {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE categoria_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $categoriaId);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'] > 0;
    }
    
    /**
     * Obtener categoría por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Actualizar categoría
     */
    public function actualizar($id, $datos) {
        $sql = "UPDATE {$this->tabla} SET nombre = :nombre, descripcion = :descripcion, imagen = :imagen WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        return $stmt->execute();
    }
    
    /**
     * Eliminar categoría
     */
    public function eliminar($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    /**
     * Obtener categorías con contador de productos
     */
    public function obtenerConContadorProductos() {
        $sql = "SELECT 
                    c.id,
                    c.nombre,
                    c.descripcion,
                    c.imagen,
                    c.estado,
                    COUNT(p.id) as cantidad_productos
                FROM {$this->tabla} c
                LEFT JOIN productos p ON p.categoria_id = c.id
                GROUP BY c.id, c.nombre, c.descripcion, c.imagen, c.estado
                ORDER BY c.nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
