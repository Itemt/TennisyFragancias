-- =============================================
-- Base de Datos: Tennis y Zapatos E-commerce
-- Barrancabermeja, Santander, Colombia
-- =============================================

CREATE DATABASE IF NOT EXISTS tennisyzapatos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tennisyzapatos_db;

-- =============================================
-- Tabla: usuarios
-- =============================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    ciudad VARCHAR(100) DEFAULT 'Barrancabermeja',
    departamento VARCHAR(100) DEFAULT 'Santander',
    codigo_postal VARCHAR(10),
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'empleado', 'cliente') DEFAULT 'cliente',
    estado ENUM('activo', 'inactivo', 'suspendido') DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultima_conexion TIMESTAMP NULL,
    token_recuperacion VARCHAR(100) NULL,
    token_expiracion TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_rol (rol),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: categorias
-- =============================================
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: productos
-- =============================================
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    precio_oferta DECIMAL(10, 2) NULL,
    categoria_id INT NOT NULL,
    stock INT DEFAULT 0,
    stock_minimo INT DEFAULT 5,
    imagen_principal VARCHAR(255),
    marca VARCHAR(100),
    talla VARCHAR(50),
    color VARCHAR(50),
    genero ENUM('hombre', 'mujer', 'unisex', 'niño', 'niña') DEFAULT 'unisex',
    codigo_sku VARCHAR(50) UNIQUE,
    estado ENUM('activo', 'inactivo', 'agotado') DEFAULT 'activo',
    destacado BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE,
    INDEX idx_categoria (categoria_id),
    INDEX idx_estado (estado),
    INDEX idx_destacado (destacado),
    INDEX idx_precio (precio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: imagenes_producto
-- =============================================
CREATE TABLE imagenes_producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    ruta_imagen VARCHAR(255) NOT NULL,
    orden INT DEFAULT 0,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    INDEX idx_producto (producto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: carrito
-- =============================================
CREATE TABLE carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT DEFAULT 1,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_usuario_producto (usuario_id, producto_id),
    INDEX idx_usuario (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: pedidos
-- =============================================
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_pedido VARCHAR(50) UNIQUE NOT NULL,
    usuario_id INT NOT NULL,
    empleado_id INT NULL COMMENT 'ID del empleado que gestiona el pedido (para ventas presenciales)',
    tipo_pedido ENUM('online', 'presencial') DEFAULT 'online',
    subtotal DECIMAL(10, 2) NOT NULL,
    impuestos DECIMAL(10, 2) DEFAULT 0.00,
    total DECIMAL(10, 2) NOT NULL,
    metodo_pago ENUM('efectivo', 'tarjeta', 'mercadopago', 'transferencia') NOT NULL,
    estado ENUM('pendiente', 'enviado', 'entregado', 'cancelado') DEFAULT 'pendiente',
    direccion_envio TEXT NOT NULL,
    ciudad_envio VARCHAR(100) NOT NULL,
    telefono_contacto VARCHAR(20) NOT NULL,
    notas_pedido TEXT,
    mercadopago_payment_id VARCHAR(100) NULL,
    mercadopago_status VARCHAR(50) NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fecha_envio TIMESTAMP NULL,
    fecha_entrega TIMESTAMP NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (empleado_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_usuario (usuario_id),
    INDEX idx_empleado (empleado_id),
    INDEX idx_estado (estado),
    INDEX idx_numero_pedido (numero_pedido),
    INDEX idx_fecha_pedido (fecha_pedido)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: detalle_pedido
-- =============================================
CREATE TABLE detalle_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    nombre_producto VARCHAR(200) NOT NULL COMMENT 'Guardamos nombre por si se elimina el producto',
    precio_unitario DECIMAL(10, 2) NOT NULL,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    INDEX idx_pedido (pedido_id),
    INDEX idx_producto (producto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: facturas
-- =============================================
CREATE TABLE facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_factura VARCHAR(50) UNIQUE NOT NULL,
    pedido_id INT NOT NULL,
    usuario_id INT NOT NULL,
    empleado_id INT NULL COMMENT 'Empleado que generó la factura',
    subtotal DECIMAL(10, 2) NOT NULL,
    impuestos DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (empleado_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_numero_factura (numero_factura),
    INDEX idx_pedido (pedido_id),
    INDEX idx_usuario (usuario_id),
    INDEX idx_fecha_emision (fecha_emision)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: historial_pedido
-- =============================================
CREATE TABLE historial_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    estado_anterior VARCHAR(50),
    estado_nuevo VARCHAR(50) NOT NULL,
    usuario_cambio_id INT NULL COMMENT 'Usuario que realizó el cambio',
    comentario TEXT,
    fecha_cambio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_cambio_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_pedido (pedido_id),
    INDEX idx_fecha_cambio (fecha_cambio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: notificaciones
-- =============================================
CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo ENUM('pedido', 'producto', 'sistema', 'promocion') NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    mensaje TEXT NOT NULL,
    enlace VARCHAR(255),
    leida BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (usuario_id),
    INDEX idx_leida (leida),
    INDEX idx_fecha_creacion (fecha_creacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: movimientos_inventario
-- =============================================
CREATE TABLE movimientos_inventario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    tipo_movimiento ENUM('entrada', 'salida', 'ajuste') NOT NULL,
    cantidad INT NOT NULL,
    stock_anterior INT NOT NULL,
    stock_nuevo INT NOT NULL,
    motivo VARCHAR(255),
    usuario_id INT NOT NULL COMMENT 'Usuario que realizó el movimiento',
    referencia VARCHAR(100) COMMENT 'Referencia a pedido, venta, etc.',
    fecha_movimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_producto (producto_id),
    INDEX idx_tipo_movimiento (tipo_movimiento),
    INDEX idx_fecha_movimiento (fecha_movimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Tabla: configuracion_sistema
-- =============================================
CREATE TABLE configuracion_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descripcion TEXT,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Datos iniciales
-- =============================================

-- Insertar usuario administrador por defecto
-- Contraseña: admin123 (debe cambiarse en producción)
INSERT INTO usuarios (nombre, apellido, email, telefono, password_hash, rol, estado) VALUES
('Administrador', 'Sistema', 'admin@tennisyzapatos.com', '3001234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', 'activo');

-- Insertar categorías iniciales
INSERT INTO categorias (nombre, descripcion, estado) VALUES
('Tenis Deportivos', 'Calzado deportivo para hombre, mujer y niños', 'activo'),
('Tenis Casuales', 'Calzado casual para el día a día', 'activo'),
('Zapatos Formales', 'Calzado formal para hombre y mujer', 'activo'),
('Zapatos Deportivos', 'Calzado deportivo especializado', 'activo'),
('Accesorios', 'Medias, cordones y accesorios para calzado', 'activo');

-- Insertar configuraciones del sistema
INSERT INTO configuracion_sistema (clave, valor, descripcion) VALUES
('iva_porcentaje', '19', 'Porcentaje de IVA aplicado a las ventas'),
('costo_envio_local', '10000', 'Costo de envío local en Barrancabermeja'),
('costo_envio_nacional', '20000', 'Costo de envío nacional'),
('envio_gratis_desde', '150000', 'Monto mínimo para envío gratis'),
('moneda', 'COP', 'Código de moneda (Peso Colombiano)'),
('email_notificaciones', 'info@tennisyzapatos.com', 'Email para notificaciones del sistema'),
('telefono_contacto', '3001234567', 'Teléfono de contacto principal'),
('direccion_tienda', 'Barrancabermeja, Santander, Colombia', 'Dirección de la tienda física');

-- =============================================
-- Triggers
-- =============================================

-- Trigger para actualizar stock después de un pedido
DELIMITER //
CREATE TRIGGER after_detalle_pedido_insert
AFTER INSERT ON detalle_pedido
FOR EACH ROW
BEGIN
    DECLARE stock_actual INT;
    
    -- Obtener stock actual
    SELECT stock INTO stock_actual FROM productos WHERE id = NEW.producto_id;
    
    -- Actualizar stock
    UPDATE productos SET stock = stock - NEW.cantidad WHERE id = NEW.producto_id;
    
    -- Registrar movimiento de inventario
    INSERT INTO movimientos_inventario (producto_id, tipo_movimiento, cantidad, stock_anterior, stock_nuevo, motivo, usuario_id, referencia)
    VALUES (NEW.producto_id, 'salida', NEW.cantidad, stock_actual, stock_actual - NEW.cantidad, 'Venta realizada', 1, CONCAT('PEDIDO-', NEW.pedido_id));
    
    -- Actualizar estado del producto si se agota
    UPDATE productos SET estado = 'agotado' WHERE id = NEW.producto_id AND stock <= 0;
END//

-- Trigger para registrar cambios de estado de pedidos
CREATE TRIGGER after_pedido_update
AFTER UPDATE ON pedidos
FOR EACH ROW
BEGIN
    IF OLD.estado != NEW.estado THEN
        INSERT INTO historial_pedido (pedido_id, estado_anterior, estado_nuevo, comentario)
        VALUES (NEW.id, OLD.estado, NEW.estado, CONCAT('Estado cambiado de ', OLD.estado, ' a ', NEW.estado));
        
        -- Crear notificación para el cliente
        INSERT INTO notificaciones (usuario_id, tipo, titulo, mensaje, enlace)
        VALUES (NEW.usuario_id, 'pedido', 'Estado de pedido actualizado', 
                CONCAT('Tu pedido #', NEW.numero_pedido, ' ha cambiado a estado: ', NEW.estado),
                CONCAT('pedidos/ver/', NEW.id));
    END IF;
END//

DELIMITER ;

-- =============================================
-- Vistas útiles
-- =============================================

-- Vista de productos con información de categoría
CREATE VIEW vista_productos_completa AS
SELECT 
    p.id,
    p.nombre,
    p.descripcion,
    p.precio,
    p.precio_oferta,
    p.stock,
    p.imagen_principal,
    p.marca,
    p.talla,
    p.color,
    p.genero,
    p.codigo_sku,
    p.estado,
    p.destacado,
    c.nombre AS categoria_nombre,
    c.id AS categoria_id,
    p.fecha_creacion
FROM productos p
INNER JOIN categorias c ON p.categoria_id = c.id;

-- Vista de pedidos con información del cliente
CREATE VIEW vista_pedidos_completa AS
SELECT 
    p.id,
    p.numero_pedido,
    p.tipo_pedido,
    p.total,
    p.estado,
    p.metodo_pago,
    p.fecha_pedido,
    p.fecha_entrega,
    u.nombre AS cliente_nombre,
    u.apellido AS cliente_apellido,
    u.email AS cliente_email,
    u.telefono AS cliente_telefono,
    e.nombre AS empleado_nombre,
    e.apellido AS empleado_apellido
FROM pedidos p
INNER JOIN usuarios u ON p.usuario_id = u.id
LEFT JOIN usuarios e ON p.empleado_id = e.id;

-- =============================================
-- Fin del script
-- =============================================

