<?php
/**
 * Clase base Modelo
 */
class Modelo {
    protected $db;
    protected $tabla;
    
    public function __construct() {
        $this->db = BaseDatos::obtenerInstancia()->obtenerConexion();
    }
    
    /**
     * Obtener todos los registros
     */
    public function obtenerTodos() {
        $sql = "SELECT * FROM {$this->tabla}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener registro por ID
     */
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Crear nuevo registro
     */
    public function crear($datos) {
        $campos = array_keys($datos);
        $valores = ':' . implode(', :', $campos);
        $campos = implode(', ', $campos);
        
        $sql = "INSERT INTO {$this->tabla} ({$campos}) VALUES ({$valores})";
        $stmt = $this->db->prepare($sql);
        
        foreach ($datos as $campo => &$valor) {
            $stmt->bindParam(':' . $campo, $valor);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Actualizar registro
     */
    public function actualizar($id, $datos) {
        $campos = '';
        foreach ($datos as $campo => $valor) {
            $campos .= "{$campo} = :{$campo}, ";
        }
        $campos = rtrim($campos, ', ');
        
        $sql = "UPDATE {$this->tabla} SET {$campos} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        foreach ($datos as $campo => &$valor) {
            $stmt->bindParam(':' . $campo, $valor);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar registro
     */
    public function eliminar($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    /**
     * Contar registros
     */
    public function contar($condiciones = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->tabla}";
        
        if (!empty($condiciones)) {
            $sql .= " WHERE ";
            $where = [];
            foreach ($condiciones as $campo => $valor) {
                $where[] = "{$campo} = :{$campo}";
            }
            $sql .= implode(' AND ', $where);
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($condiciones as $campo => &$valor) {
            $stmt->bindParam(':' . $campo, $valor);
        }
        
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }
    
    /**
     * Obtener último ID insertado
     */
    public function obtenerUltimoId() {
        return $this->db->lastInsertId();
    }
}
