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
        error_log("DEBUG MODELO CREAR: Iniciando método crear()");
        error_log("DEBUG MODELO CREAR: Tabla: " . $this->tabla);
        error_log("DEBUG MODELO CREAR: Datos recibidos: " . json_encode($datos));
        
        $campos = array_keys($datos);
        $valores = ':' . implode(', :', $campos);
        $campos = implode(', ', $campos);
        
        $sql = "INSERT INTO {$this->tabla} ({$campos}) VALUES ({$valores})";
        error_log("DEBUG MODELO CREAR: SQL generado: " . $sql);
        
        try {
            $stmt = $this->db->prepare($sql);
            error_log("DEBUG MODELO CREAR: Statement preparado exitosamente");
            
            foreach ($datos as $campo => &$valor) {
                $stmt->bindParam(':' . $campo, $valor);
                error_log("DEBUG MODELO CREAR: Bind param {$campo} = " . $valor);
            }
            
            $resultado = $stmt->execute();
            error_log("DEBUG MODELO CREAR: Resultado execute: " . ($resultado ? 'true' : 'false'));
            
            if (!$resultado) {
                $errorInfo = $stmt->errorInfo();
                error_log("DEBUG MODELO CREAR: Error en execute: " . json_encode($errorInfo));
            }
            
            return $resultado;
        } catch (Exception $e) {
            error_log("DEBUG MODELO CREAR: Excepción capturada: " . $e->getMessage());
            return false;
        }
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
