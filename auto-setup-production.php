<?php
/**
 * Configuración automática completa para producción
 * Se ejecuta automáticamente en el primer acceso
 */

// Verificar si ya se ejecutó la configuración (evitar ejecutar múltiples veces)
$setupFile = __DIR__ . '/.production-setup-completed';
if (file_exists($setupFile)) {
    return; // Ya se ejecutó la configuración
}

try {
    // Cargar configuración
    require_once __DIR__ . '/app/config/base_datos.php';
    
    // Obtener conexión a la base de datos
    $db = BaseDatos::obtenerInstancia();
    $pdo = $db->obtenerConexion();
    
    $log = [];
    $log[] = "🔄 Iniciando configuración automática de producción...";
    
    // ========== 1. CREAR TABLA HISTORIAL_STOCK ==========
    $log[] = "📊 Verificando tabla historial_stock...";
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'historial_stock'");
    if ($stmt->rowCount() == 0) {
        $log[] = "🔄 Creando tabla historial_stock...";
        
        $sql = "CREATE TABLE historial_stock (
            id INT AUTO_INCREMENT PRIMARY KEY,
            producto_id INT NOT NULL,
            usuario_id INT,
            tipo ENUM('entrada', 'salida', 'ajuste') NOT NULL,
            cantidad INT NOT NULL,
            stock_anterior INT NOT NULL,
            stock_nuevo INT NOT NULL,
            motivo VARCHAR(255),
            fecha_movimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
            INDEX idx_producto (producto_id),
            INDEX idx_fecha (fecha_movimiento),
            INDEX idx_tipo (tipo)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        $log[] = "✅ Tabla historial_stock creada exitosamente";
    } else {
        $log[] = "ℹ️  Tabla historial_stock ya existe";
    }
    
    // ========== 2. CREAR USUARIOS ADMINISTRATIVOS ==========
    $log[] = "👥 Verificando usuarios administrativos...";
    
    // Verificar si existen usuarios admin y empleado
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios WHERE rol IN ('administrador', 'empleado')");
    $stmt->execute();
    $usuariosAdmin = $stmt->fetch()['total'];
    
    if ($usuariosAdmin == 0) {
        $log[] = "🔄 Creando usuarios administrativos...";
        
        // Crear usuario administrador
        $adminPassword = password_hash('Admin123!', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, rol, activo, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(['Administrador', 'Sistema', 'admin@tennisyfragancias.com', $adminPassword, 'administrador', 1, 'activo']);
        $log[] = "✅ Usuario administrador creado: admin@tennisyfragancias.com / Admin123!";
        
        // Crear usuario empleado
        $empleadoPassword = password_hash('Empleado123!', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, rol, activo, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(['Empleado', 'Ventas', 'empleado@tennisyfragancias.com', $empleadoPassword, 'empleado', 1, 'activo']);
        $log[] = "✅ Usuario empleado creado: empleado@tennisyfragancias.com / Empleado123!";
        
    } else {
        $log[] = "ℹ️  Usuarios administrativos ya existen";
    }
    
    // ========== 3. VERIFICAR DATOS BÁSICOS ==========
    $log[] = "📋 Verificando datos básicos...";
    
    // Verificar categorías
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM categorias");
    $categorias = $stmt->fetch()['total'];
    if ($categorias == 0) {
        $log[] = "🔄 Creando categorías básicas...";
        
        $categoriasBasicas = [
            ['Tennis', 'Calzado deportivo para todas las actividades'],
            ['Zapatos Formales', 'Calzado elegante para ocasiones especiales'],
            ['Sandalias', 'Calzado cómodo para el verano'],
            ['Botas', 'Calzado resistente para el invierno']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO categorias (nombre, descripcion, estado) VALUES (?, ?, 'activo')");
        foreach ($categoriasBasicas as $cat) {
            $stmt->execute($cat);
        }
        $log[] = "✅ Categorías básicas creadas";
    } else {
        $log[] = "ℹ️  Categorías ya existen";
    }
    
    // ========== 4. MARCAR CONFIGURACIÓN COMO COMPLETADA ==========
    $log[] = "🎉 Configuración automática completada exitosamente";
    
    // Guardar log de configuración
    file_put_contents($setupFile, implode("\n", $log) . "\n");
    
    // Log para debugging
    error_log("✅ Configuración automática de producción completada");
    
} catch (Exception $e) {
    // Log del error pero no interrumpir la aplicación
    $errorMsg = "❌ Error en configuración automática: " . $e->getMessage();
    error_log($errorMsg);
    
    // Crear archivo de error para debugging
    file_put_contents($setupFile . '.error', 
        date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n"
    );
}
?>
