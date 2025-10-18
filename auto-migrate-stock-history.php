<?php
/**
 * Migración automática de la tabla historial_stock
 * Se ejecuta automáticamente en producción
 */

// Verificar si ya se ejecutó la migración (evitar ejecutar múltiples veces)
$migrationFile = __DIR__ . '/.stock-history-migrated';
if (file_exists($migrationFile)) {
    return; // Ya se ejecutó la migración
}

try {
    // Obtener conexión a la base de datos
    $db = BaseDatos::obtenerInstancia();
    $pdo = $db->obtenerConexion();
    
    // Verificar si la tabla ya existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'historial_stock'");
    if ($stmt->rowCount() > 0) {
        // La tabla ya existe, marcar como migrado
        file_put_contents($migrationFile, date('Y-m-d H:i:s') . " - Tabla ya existía\n");
        return;
    }
    
    // Crear la tabla historial_stock
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
    
    // Verificar que se creó correctamente
    $stmt = $pdo->query("SHOW TABLES LIKE 'historial_stock'");
    if ($stmt->rowCount() > 0) {
        // Marcar como migrado exitosamente
        file_put_contents($migrationFile, date('Y-m-d H:i:s') . " - Migración exitosa\n");
        
        // Log para debugging (solo en producción)
        error_log("✅ Tabla historial_stock creada automáticamente");
    } else {
        throw new Exception("No se pudo verificar la creación de la tabla");
    }
    
} catch (Exception $e) {
    // Log del error pero no interrumpir la aplicación
    error_log("❌ Error en migración automática de historial_stock: " . $e->getMessage());
    
    // Crear archivo de error para debugging
    file_put_contents($migrationFile . '.error', 
        date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n"
    );
}
?>
