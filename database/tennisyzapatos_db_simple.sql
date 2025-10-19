-- =====================================================
-- Base de datos Tennis y Fragancias - Estructura básica
-- Para instalación automática
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Desactivar restricciones temporalmente
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- TABLAS PRINCIPALES
-- =====================================================

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('cliente','empleado','administrador') NOT NULL DEFAULT 'cliente',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_rol` (`rol`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de direcciones
CREATE TABLE IF NOT EXISTS `direcciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `pais` varchar(100) NOT NULL DEFAULT 'Colombia',
  `es_principal` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_direcciones_usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de marcas
CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de tallas
CREATE TABLE IF NOT EXISTS `tallas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de colores
CREATE TABLE IF NOT EXISTS `colores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `codigo_hex` varchar(7) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de géneros
CREATE TABLE IF NOT EXISTS `generos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `genero_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `codigo_sku` varchar(50) NOT NULL UNIQUE,
  `imagen_principal` varchar(255) DEFAULT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_categoria` (`categoria_id`),
  KEY `idx_marca` (`marca_id`),
  KEY `idx_talla` (`talla_id`),
  KEY `idx_color` (`color_id`),
  KEY `idx_genero` (`genero_id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_destacado` (`destacado`),
  KEY `idx_sku` (`codigo_sku`),
  KEY `idx_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de métodos de pago
CREATE TABLE IF NOT EXISTS `metodos_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de estados de pedido
CREATE TABLE IF NOT EXISTS `estados_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pedido` varchar(50) NOT NULL UNIQUE,
  `usuario_id` int(11) NOT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) DEFAULT 0.00,
  `impuestos` decimal(10,2) DEFAULT 0.00,
  `metodo_pago_id` int(11) NOT NULL,
  `estado_pedido_id` int(11) NOT NULL,
  `tipo_pedido` enum('online','presencial') NOT NULL DEFAULT 'online',
  `fecha_pedido` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_envio` timestamp NULL DEFAULT NULL,
  `fecha_entrega` timestamp NULL DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_empleado` (`empleado_id`),
  KEY `idx_metodo_pago` (`metodo_pago_id`),
  KEY `idx_estado_pedido` (`estado_pedido_id`),
  KEY `idx_fecha_pedido` (`fecha_pedido`),
  KEY `idx_numero_pedido` (`numero_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de detalles de pedido
CREATE TABLE IF NOT EXISTS `detalle_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_producto` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de carrito
CREATE TABLE IF NOT EXISTS `carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio` decimal(10,2) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_fecha_agregado` (`fecha_agregado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(50) NOT NULL UNIQUE,
  `pedido_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_vencimiento` timestamp NULL DEFAULT NULL,
  `estado` enum('pendiente','pagada','vencida','cancelada') NOT NULL DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_empleado` (`empleado_id`),
  KEY `idx_numero_factura` (`numero_factura`),
  KEY `idx_fecha_emision` (`fecha_emision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de historial de stock
CREATE TABLE IF NOT EXISTS `historial_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo` enum('entrada','salida','ajuste') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock_anterior` int(11) NOT NULL,
  `stock_nuevo` int(11) NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `fecha_movimiento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_tipo` (`tipo`),
  KEY `idx_fecha_movimiento` (`fecha_movimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATOS INICIALES BÁSICOS
-- =====================================================

-- Insertar categorías
INSERT INTO `categorias` (`nombre`, `descripcion`, `estado`) VALUES
('Tenis Deportivos', 'Calzado deportivo para actividades físicas', 'activo'),
('Tenis Casuales', 'Calzado casual para uso diario', 'activo'),
('Zapatos Formales', 'Calzado formal para eventos especiales', 'activo'),
('Zapatos Deportivos', 'Calzado deportivo especializado', 'activo'),
('Accesorios', 'Accesorios y complementos', 'activo');

-- Insertar marcas
INSERT INTO `marcas` (`nombre`, `descripcion`, `estado`) VALUES
('Nike', 'Just Do It', 'activo'),
('Adidas', 'Impossible is Nothing', 'activo'),
('Puma', 'Forever Faster', 'activo'),
('Reebok', 'Be More Human', 'activo'),
('Converse', 'All Star', 'activo'),
('Vans', 'Off The Wall', 'activo'),
('New Balance', 'Always in Beta', 'activo'),
('Under Armour', 'I Will', 'activo');

-- Insertar tallas
INSERT INTO `tallas` (`nombre`, `descripcion`, `estado`) VALUES
('28', 'Talla 28', 'activo'),
('29', 'Talla 29', 'activo'),
('30', 'Talla 30', 'activo'),
('31', 'Talla 31', 'activo'),
('32', 'Talla 32', 'activo'),
('33', 'Talla 33', 'activo'),
('34', 'Talla 34', 'activo'),
('35', 'Talla 35', 'activo'),
('36', 'Talla 36', 'activo'),
('37', 'Talla 37', 'activo'),
('38', 'Talla 38', 'activo'),
('39', 'Talla 39', 'activo'),
('40', 'Talla 40', 'activo'),
('41', 'Talla 41', 'activo'),
('42', 'Talla 42', 'activo'),
('43', 'Talla 43', 'activo'),
('44', 'Talla 44', 'activo'),
('45', 'Talla 45', 'activo'),
('46', 'Talla 46', 'activo'),
('47', 'Talla 47', 'activo'),
('48', 'Talla 48', 'activo');

-- Insertar colores
INSERT INTO `colores` (`nombre`, `codigo_hex`, `estado`) VALUES
('Negro', '#000000', 'activo'),
('Blanco', '#FFFFFF', 'activo'),
('Rojo', '#FF0000', 'activo'),
('Azul', '#0000FF', 'activo'),
('Verde', '#00FF00', 'activo'),
('Amarillo', '#FFFF00', 'activo'),
('Rosa', '#FFC0CB', 'activo'),
('Gris', '#808080', 'activo'),
('Marrón', '#A52A2A', 'activo'),
('Naranja', '#FFA500', 'activo'),
('Morado', '#800080', 'activo'),
('Celeste', '#87CEEB', 'activo'),
('Dorado', '#FFD700', 'activo'),
('Plateado', '#C0C0C0', 'activo');

-- Insertar géneros
INSERT INTO `generos` (`nombre`, `descripcion`, `estado`) VALUES
('Masculino', 'Calzado para hombres', 'activo'),
('Femenino', 'Calzado para mujeres', 'activo'),
('Unisex', 'Calzado para ambos géneros', 'activo'),
('Infantil', 'Calzado para niños', 'activo');

-- Insertar métodos de pago
INSERT INTO `metodos_pago` (`nombre`, `descripcion`, `estado`) VALUES
('Efectivo', 'Pago en efectivo', 'activo'),
('Tarjeta de Crédito', 'Pago con tarjeta de crédito', 'activo'),
('Tarjeta Débito', 'Pago con tarjeta débito', 'activo'),
('Transferencia Bancaria', 'Transferencia bancaria', 'activo'),
('MercadoPago', 'Pago a través de MercadoPago', 'activo');

-- Insertar estados de pedido
INSERT INTO `estados_pedido` (`nombre`, `descripcion`, `color`, `estado`) VALUES
('Pendiente', 'Pedido pendiente de procesamiento', '#ffc107', 'activo'),
('Confirmado', 'Pedido confirmado', '#17a2b8', 'activo'),
('En Preparación', 'Pedido en preparación', '#fd7e14', 'activo'),
('Enviado', 'Pedido enviado', '#20c997', 'activo'),
('Entregado', 'Pedido entregado', '#28a745', 'activo'),
('Cancelado', 'Pedido cancelado', '#dc3545', 'activo');

-- Insertar usuarios de prueba
INSERT INTO `usuarios` (`nombre`, `apellido`, `email`, `password`, `telefono`, `rol`, `estado`) VALUES
('Administrador', 'Sistema', 'admin@tennisyfragancias.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 300 123 4567', 'administrador', 'activo'),
('Empleado', 'Ventas', 'empleado@tennisyfragancias.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 300 234 5678', 'empleado', 'activo'),
('Juan Carlos', 'Pérez López', 'cliente@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 311 456 7890', 'cliente', 'activo');

-- Insertar direcciones de prueba
INSERT INTO `direcciones` (`usuario_id`, `direccion`, `ciudad`, `departamento`, `codigo_postal`, `pais`, `es_principal`) VALUES
(3, 'Carrera 15 #28-45 Apto 301', 'Barrancabermeja', 'Santander', '687031', 'Colombia', 1);

-- Insertar productos de ejemplo
INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `precio_oferta`, `categoria_id`, `marca_id`, `talla_id`, `color_id`, `genero_id`, `stock`, `stock_minimo`, `codigo_sku`, `destacado`, `estado`) VALUES
('Air Max 270', 'Zapatillas deportivas Nike con tecnología Air Max', 329000.00, 299000.00, 1, 1, 13, 1, 1, 15, 5, 'TF-001-40-0001', 1, 'activo'),
('Stan Smith', 'Zapatillas clásicas Adidas en cuero blanco', 180000.00, NULL, 2, 2, 11, 2, 3, 20, 5, 'TF-002-38-0001', 1, 'activo'),
('Chuck Taylor', 'Zapatillas clásicas Converse All Star', 120000.00, 99000.00, 2, 5, 9, 1, 3, 25, 5, 'TF-003-36-0001', 0, 'activo'),
('Old Skool', 'Zapatillas Vans clásicas', 150000.00, NULL, 2, 6, 10, 3, 3, 18, 5, 'TF-004-37-0001', 0, 'activo'),
('574', 'Zapatillas New Balance 574', 200000.00, 179000.00, 1, 7, 12, 4, 1, 12, 5, 'TF-005-39-0001', 1, 'activo');

-- Insertar historial de stock inicial
INSERT INTO `historial_stock` (`producto_id`, `usuario_id`, `tipo`, `cantidad`, `stock_anterior`, `stock_nuevo`, `motivo`) VALUES
(1, 1, 'entrada', 15, 0, 15, 'Stock inicial'),
(2, 1, 'entrada', 20, 0, 20, 'Stock inicial'),
(3, 1, 'entrada', 25, 0, 25, 'Stock inicial'),
(4, 1, 'entrada', 18, 0, 18, 'Stock inicial'),
(5, 1, 'entrada', 12, 0, 12, 'Stock inicial');

-- Reactivar restricciones de clave foránea
SET FOREIGN_KEY_CHECKS = 1;

COMMIT;
