<?php
/**
 * Modelo Usuario
 */
class Usuario extends Modelo {
    protected $tabla = 'usuarios';
    
    /**
     * Registrar nuevo usuario
     */
    public function registrar($datos) {
        // Hash de la contraseña
        $datos['password_hash'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        unset($datos['password']);
        
        return $this->crear($datos);
    }
    
    /**
     * Autenticar usuario
     */
    public function autenticar($email, $password) {
        $sql = "SELECT * FROM {$this->tabla} WHERE email = :email AND estado = 'activo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch();
        
        if ($usuario) {
            // Verificar contraseña con password_hash (método preferido)
            if (!empty($usuario['password_hash']) && password_verify($password, $usuario['password_hash'])) {
                $this->actualizarUltimaConexion($usuario['id']);
                return $usuario;
            }
            // Verificar contraseña con password (método legacy)
            elseif (!empty($usuario['password']) && $usuario['password'] === $password) {
                $this->actualizarUltimaConexion($usuario['id']);
                return $usuario;
            }
        }
        
        return false;
    }
    
    /**
     * Obtener usuario por email
     */
    public function obtenerPorEmail($email) {
        $sql = "SELECT * FROM {$this->tabla} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Verificar si el email ya existe
     */
    public function emailExiste($email, $excluirId = null) {
        $sql = "SELECT COUNT(*) as total FROM {$this->tabla} WHERE email = :email";
        
        if ($excluirId) {
            $sql .= " AND id != :id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        
        if ($excluirId) {
            $stmt->bindParam(':id', $excluirId);
        }
        
        $stmt->execute();
        $resultado = $stmt->fetch();
        
        return $resultado['total'] > 0;
    }
    
    /**
     * Actualizar última conexión
     */
    private function actualizarUltimaConexion($usuarioId) {
        $sql = "UPDATE {$this->tabla} SET ultima_conexion = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Cambiar contraseña
     */
    public function cambiarPassword($usuarioId, $passwordNuevo) {
        $passwordHash = password_hash($passwordNuevo, PASSWORD_DEFAULT);
        $sql = "UPDATE {$this->tabla} SET password_hash = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Generar token de recuperación
     */
    public function generarTokenRecuperacion($email) {
        $token = bin2hex(random_bytes(32));
        $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $sql = "UPDATE {$this->tabla} SET token_recuperacion = :token, token_expiracion = :expiracion WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiracion', $expiracion);
        $stmt->bindParam(':email', $email);
        
        if ($stmt->execute()) {
            return $token;
        }
        return false;
    }
    
    /**
     * Verificar token de recuperación
     */
    public function verificarTokenRecuperacion($token) {
        $sql = "SELECT * FROM {$this->tabla} WHERE token_recuperacion = :token AND token_expiracion > NOW()";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Obtener usuarios por rol
     */
    public function obtenerPorRol($rol) {
        $sql = "SELECT * FROM {$this->tabla} WHERE rol = :rol ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtener empleados activos
     */
    public function obtenerEmpleadosActivos() {
        $sql = "SELECT id, nombre, apellido, email FROM {$this->tabla} 
                WHERE rol IN ('empleado', 'administrador') AND estado = 'activo' 
                ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Actualizar perfil
     */
    public function actualizarPerfil($usuarioId, $datos) {
        // No permitir actualizar rol, password_hash, estado desde aquí
        unset($datos['rol'], $datos['password_hash'], $datos['estado']);
        
        return $this->actualizar($usuarioId, $datos);
    }
    
    /**
     * Cambiar estado de usuario
     */
    public function cambiarEstado($usuarioId, $estado) {
        $sql = "UPDATE {$this->tabla} SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Obtener estadísticas de usuarios
     */
    public function obtenerEstadisticas() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN rol = 'cliente' THEN 1 ELSE 0 END) as clientes,
                    SUM(CASE WHEN rol = 'empleado' THEN 1 ELSE 0 END) as empleados,
                    SUM(CASE WHEN rol = 'administrador' THEN 1 ELSE 0 END) as administradores,
                    SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) as activos
                FROM {$this->tabla}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Obtener todos los usuarios con filtros
     */
    public function obtenerTodos($filtros = []) {
        $sql = "SELECT * FROM {$this->tabla} WHERE 1=1";
        $params = [];
        
        if (!empty($filtros['rol'])) {
            $sql .= " AND rol = :rol";
            $params['rol'] = $filtros['rol'];
        }
        
        if (!empty($filtros['estado'])) {
            $sql .= " AND estado = :estado";
            $params['estado'] = $filtros['estado'];
        }
        
        if (!empty($filtros['buscar'])) {
            $sql .= " AND (nombre LIKE :buscar OR apellido LIKE :buscar OR email LIKE :buscar)";
            $params['buscar'] = '%' . $filtros['buscar'] . '%';
        }
        
        $sql .= " ORDER BY fecha_registro DESC";
        
        // Paginación
        if (isset($filtros['pagina']) && $filtros['pagina'] > 0) {
            $offset = ($filtros['pagina'] - 1) * 20;
            $sql .= " LIMIT 20 OFFSET :offset";
            $params['offset'] = $offset;
        }
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $param => $valor) {
            $stmt->bindValue(':' . $param, $valor);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Contar usuarios con filtros
     */
    public function contarUsuarios($filtros = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->tabla} WHERE 1=1";
        $params = [];
        
        if (!empty($filtros['rol'])) {
            $sql .= " AND rol = :rol";
            $params['rol'] = $filtros['rol'];
        }
        
        if (!empty($filtros['estado'])) {
            $sql .= " AND estado = :estado";
            $params['estado'] = $filtros['estado'];
        }
        
        if (!empty($filtros['buscar'])) {
            $sql .= " AND (nombre LIKE :buscar OR apellido LIKE :buscar OR email LIKE :buscar)";
            $params['buscar'] = '%' . $filtros['buscar'] . '%';
        }
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $param => $valor) {
            $stmt->bindValue(':' . $param, $valor);
        }
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }
    
    /**
     * Actualizar contraseña de usuario
     */
    public function actualizarPassword($usuarioId, $passwordHash) {
        $sql = "UPDATE {$this->tabla} SET password_hash = :password_hash WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password_hash', $passwordHash);
        $stmt->bindParam(':id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Actualizar estado de usuario
     */
    public function actualizarEstado($usuarioId, $estado) {
        $sql = "UPDATE {$this->tabla} SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $usuarioId);
        return $stmt->execute();
    }
    
    /**
     * Eliminar usuario completamente
     */
    public function eliminar($usuarioId) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $usuarioId);
        return $stmt->execute();
    }
}
