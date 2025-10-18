<?php
/**
 * Script de migración para producción - Crear tabla historial_stock
 * Ejecutar en el servidor de producción
 */

// Configuración de base de datos para producción
$host = 'localhost';
$dbname = 'tennisyfragancias_db';
$username = 'root';
$password = '';

try {
    echo "🔄 Conectando a la base de datos de producción...\n";
    
    // Conexión directa a MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conexión establecida\n";
    echo "🔄 Creando tabla historial_stock...\n";
    
    // Crear tabla historial_stock
    $sql = "CREATE TABLE IF NOT EXISTS historial_stock (
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
    echo "✅ Tabla historial_stock creada exitosamente\n";
    
    // Verificar que la tabla existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'historial_stock'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Verificación: La tabla historial_stock existe\n";
        
        // Mostrar estructura de la tabla
        $stmt = $pdo->query("DESCRIBE historial_stock");
        echo "📋 Estructura de la tabla:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "   - {$row['Field']}: {$row['Type']}\n";
        }
    } else {
        echo "❌ Error: La tabla no se creó correctamente\n";
        exit(1);
    }
    
    echo "🎉 Migración completada exitosamente\n";
    echo "📊 La tabla historial_stock está lista para usar\n";
    echo "🔧 Ahora el historial de stock funcionará correctamente\n";
    
} catch (PDOException $e) {
    echo "❌ Error de base de datos: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error general: " . $e->getMessage() . "\n";
    exit(1);
}
?>
