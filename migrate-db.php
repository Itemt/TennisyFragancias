<?php
/**
 * Script de migración para actualizar la base de datos
 * Ejecutar en el servidor de producción
 */

// Cargar configuración
require_once 'app/config/configuracion.php';

echo "🔄 Iniciando migración de base de datos...\n";

try {
    // Crear conexión directa a la base de datos
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USUARIO, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
    ]);
    
    echo "✅ Conexión a la base de datos establecida\n";
    
    // Crear tablas normalizadas
    $tablas = [
        // Tabla direcciones
        "CREATE TABLE IF NOT EXISTS direcciones (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            tipo ENUM('principal', 'envio', 'facturacion') DEFAULT 'principal',
            direccion TEXT NOT NULL,
            ciudad VARCHAR(100) NOT NULL,
            departamento VARCHAR(100) NOT NULL,
            codigo_postal VARCHAR(10),
            es_principal TINYINT(1) DEFAULT 0,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            INDEX idx_usuario (usuario_id),
            INDEX idx_tipo (tipo),
            INDEX idx_principal (es_principal)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        // Tabla marcas
        "CREATE TABLE IF NOT EXISTS marcas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL UNIQUE,
            descripcion TEXT,
            logo VARCHAR(255),
            estado ENUM('activo', 'inactivo') DEFAULT 'activo',
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_nombre (nombre),
            INDEX idx_estado (estado)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        // Tabla tallas
        "CREATE TABLE IF NOT EXISTS tallas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(20) NOT NULL UNIQUE,
            orden INT DEFAULT 0,
            estado ENUM('activo', 'inactivo') DEFAULT 'activo',
            INDEX idx_nombre (nombre),
            INDEX idx_orden (orden)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        // Tabla colores
        "CREATE TABLE IF NOT EXISTS colores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL UNIQUE,
            codigo_hex VARCHAR(7),
            estado ENUM('activo', 'inactivo') DEFAULT 'activo',
            INDEX idx_nombre (nombre)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        // Tabla generos
        "CREATE TABLE IF NOT EXISTS generos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(20) NOT NULL UNIQUE,
            descripcion VARCHAR(100),
            estado ENUM('activo', 'inactivo') DEFAULT 'activo',
            INDEX idx_nombre (nombre)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        // Tabla metodos_pago
        "CREATE TABLE IF NOT EXISTS metodos_pago (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL UNIQUE,
            descripcion TEXT,
            activo TINYINT(1) DEFAULT 1,
            requiere_configuracion TINYINT(1) DEFAULT 0,
            INDEX idx_nombre (nombre),
            INDEX idx_activo (activo)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        
        // Tabla estados_pedido
        "CREATE TABLE IF NOT EXISTS estados_pedido (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL UNIQUE,
            descripcion VARCHAR(200),
            orden INT DEFAULT 0,
            es_final TINYINT(1) DEFAULT 0,
            color VARCHAR(7) DEFAULT '#6c757d',
            INDEX idx_nombre (nombre),
            INDEX idx_orden (orden)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];
    
    // Crear tablas
    foreach ($tablas as $sql) {
        $pdo->exec($sql);
        echo "✅ Tabla creada/verificada\n";
    }
    
    // Insertar datos básicos
    echo "📝 Insertando datos básicos...\n";
    
    // Insertar marcas
    $pdo->exec("INSERT IGNORE INTO marcas (nombre, descripcion, estado) VALUES 
        ('Nike', 'Nike Inc. - Just Do It', 'activo'),
        ('Adidas', 'Adidas AG - Impossible is Nothing', 'activo'),
        ('Puma', 'Puma SE - Forever Faster', 'activo'),
        ('Reebok', 'Reebok International Ltd.', 'activo'),
        ('Converse', 'Converse Inc. - All Star', 'activo'),
        ('New Balance', 'New Balance Athletics Inc.', 'activo'),
        ('Vans', 'Vans Inc. - Off The Wall', 'activo'),
        ('Jordan', 'Air Jordan by Nike', 'activo'),
        ('Under Armour', 'Under Armour Inc.', 'activo'),
        ('Fila', 'Fila Holdings Corp.', 'activo')");
    echo "✅ Marcas insertadas\n";
    
    // Insertar tallas
    $pdo->exec("INSERT IGNORE INTO tallas (nombre, orden, estado) VALUES 
        ('XS', 1, 'activo'),
        ('S', 2, 'activo'),
        ('M', 3, 'activo'),
        ('L', 4, 'activo'),
        ('XL', 5, 'activo'),
        ('XXL', 6, 'activo'),
        ('28', 7, 'activo'),
        ('29', 8, 'activo'),
        ('30', 9, 'activo'),
        ('31', 10, 'activo'),
        ('32', 11, 'activo'),
        ('33', 12, 'activo'),
        ('34', 13, 'activo'),
        ('35', 14, 'activo'),
        ('36', 15, 'activo'),
        ('37', 16, 'activo'),
        ('38', 17, 'activo'),
        ('39', 18, 'activo'),
        ('40', 19, 'activo'),
        ('41', 20, 'activo'),
        ('42', 21, 'activo'),
        ('43', 22, 'activo'),
        ('44', 23, 'activo'),
        ('45', 24, 'activo')");
    echo "✅ Tallas insertadas\n";
    
    // Insertar colores
    $pdo->exec("INSERT IGNORE INTO colores (nombre, codigo_hex, estado) VALUES 
        ('Negro', '#000000', 'activo'),
        ('Blanco', '#FFFFFF', 'activo'),
        ('Rojo', '#FF0000', 'activo'),
        ('Azul', '#0000FF', 'activo'),
        ('Verde', '#008000', 'activo'),
        ('Amarillo', '#FFFF00', 'activo'),
        ('Naranja', '#FFA500', 'activo'),
        ('Rosa', '#FFC0CB', 'activo'),
        ('Morado', '#800080', 'activo'),
        ('Gris', '#808080', 'activo'),
        ('Marrón', '#A52A2A', 'activo'),
        ('Azul Marino', '#000080', 'activo'),
        ('Turquesa', '#40E0D0', 'activo'),
        ('Dorado', '#FFD700', 'activo'),
        ('Plateado', '#C0C0C0', 'activo')");
    echo "✅ Colores insertados\n";
    
    // Insertar géneros
    $pdo->exec("INSERT IGNORE INTO generos (nombre, descripcion, estado) VALUES 
        ('Hombre', 'Productos para hombres', 'activo'),
        ('Mujer', 'Productos para mujeres', 'activo'),
        ('Niño', 'Productos para niños', 'activo'),
        ('Niña', 'Productos para niñas', 'activo'),
        ('Unisex', 'Productos unisex', 'activo')");
    echo "✅ Géneros insertados\n";
    
    // Insertar métodos de pago
    $pdo->exec("INSERT IGNORE INTO metodos_pago (nombre, descripcion, activo, requiere_configuracion) VALUES 
        ('Efectivo', 'Pago en efectivo', 1, 0),
        ('Tarjeta de Crédito', 'Pago con tarjeta de crédito', 1, 1),
        ('Tarjeta Débito', 'Pago con tarjeta débito', 1, 1),
        ('Transferencia Bancaria', 'Transferencia bancaria', 1, 0),
        ('MercadoPago', 'Pago a través de MercadoPago', 1, 1),
        ('Nequi', 'Pago con Nequi', 1, 1),
        ('Daviplata', 'Pago con Daviplata', 1, 1)");
    echo "✅ Métodos de pago insertados\n";
    
    // Insertar estados de pedido
    $pdo->exec("INSERT IGNORE INTO estados_pedido (nombre, descripcion, orden, es_final, color) VALUES 
        ('Pendiente', 'Pedido pendiente de confirmación', 1, 0, '#ffc107'),
        ('Confirmado', 'Pedido confirmado y en preparación', 2, 0, '#17a2b8'),
        ('Enviado', 'Pedido enviado al cliente', 3, 0, '#007bff'),
        ('Entregado', 'Pedido entregado exitosamente', 4, 1, '#28a745'),
        ('Cancelado', 'Pedido cancelado', 5, 1, '#dc3545'),
        ('Reembolsado', 'Pedido reembolsado', 6, 1, '#6c757d')");
    echo "✅ Estados de pedido insertados\n";
    
    // Actualizar tabla productos para usar las nuevas referencias
    echo "🔄 Actualizando tabla productos...\n";
    
    // Agregar columnas si no existen
    $columnas = [
        'marca_id INT',
        'talla_id INT', 
        'color_id INT',
        'genero_id INT'
    ];
    
    foreach ($columnas as $columna) {
        try {
            $pdo->exec("ALTER TABLE productos ADD COLUMN $columna");
            echo "✅ Columna agregada: $columna\n";
        } catch (PDOException $e) {
            // Columna ya existe, continuar
        }
    }
    
    // Agregar foreign keys si no existen
    $foreign_keys = [
        'FOREIGN KEY (marca_id) REFERENCES marcas(id) ON DELETE SET NULL',
        'FOREIGN KEY (talla_id) REFERENCES tallas(id) ON DELETE SET NULL',
        'FOREIGN KEY (color_id) REFERENCES colores(id) ON DELETE SET NULL',
        'FOREIGN KEY (genero_id) REFERENCES generos(id) ON DELETE SET NULL'
    ];
    
    foreach ($foreign_keys as $fk) {
        try {
            $pdo->exec("ALTER TABLE productos ADD $fk");
            echo "✅ Foreign key agregada\n";
        } catch (PDOException $e) {
            // Foreign key ya existe, continuar
        }
    }
    
    // Migrar datos existentes (opcional)
    echo "🔄 Migrando datos existentes...\n";
    
    // Migrar marcas existentes
    $stmt = $pdo->query("SELECT DISTINCT marca FROM productos WHERE marca IS NOT NULL AND marca != ''");
    $marcas_existentes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($marcas_existentes as $marca) {
        // Buscar o crear marca
        $stmt = $pdo->prepare("SELECT id FROM marcas WHERE nombre = ?");
        $stmt->execute([$marca]);
        $marca_id = $stmt->fetchColumn();
        
        if (!$marca_id) {
            $stmt = $pdo->prepare("INSERT INTO marcas (nombre, estado) VALUES (?, 'activo')");
            $stmt->execute([$marca]);
            $marca_id = $pdo->lastInsertId();
        }
        
        // Actualizar productos con la nueva marca_id
        $stmt = $pdo->prepare("UPDATE productos SET marca_id = ? WHERE marca = ?");
        $stmt->execute([$marca_id, $marca]);
    }
    echo "✅ Marcas migradas\n";
    
    echo "\n🎉 ¡Migración completada exitosamente!\n";
    echo "✅ Base de datos normalizada y actualizada\n";
    echo "✅ Datos básicos insertados\n";
    echo "✅ Tablas relacionadas creadas\n";
    
} catch (Exception $e) {
    echo "❌ Error durante la migración: " . $e->getMessage() . "\n";
    exit(1);
}
?>
