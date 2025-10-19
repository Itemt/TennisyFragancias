-- =====================================================
-- Script para llenar base de datos de producción
-- Tennis y Fragancias - Datos completos
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Desactivar restricciones temporalmente
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- LIMPIAR DATOS EXISTENTES (excepto usuarios admin/empleado)
-- =====================================================

DELETE FROM historial_stock WHERE usuario_id > 2;
DELETE FROM detalle_pedidos WHERE pedido_id IN (SELECT id FROM pedidos WHERE usuario_id > 2);
DELETE FROM facturas WHERE usuario_id > 2;
DELETE FROM carrito WHERE usuario_id > 2;
DELETE FROM pedidos WHERE usuario_id > 2;
DELETE FROM direcciones WHERE usuario_id > 2;
DELETE FROM usuarios WHERE id > 2;

-- =====================================================
-- INSERTAR CLIENTES (15 clientes)
-- =====================================================

INSERT INTO `usuarios` (`nombre`, `apellido`, `email`, `password`, `telefono`, `rol`, `estado`) VALUES
('María', 'González Rodríguez', 'maria.gonzalez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 310 123 4567', 'cliente', 'activo'),
('Carlos', 'Martínez López', 'carlos.martinez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 311 234 5678', 'cliente', 'activo'),
('Ana', 'Fernández Silva', 'ana.fernandez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 312 345 6789', 'cliente', 'activo'),
('Luis', 'Ramírez Torres', 'luis.ramirez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 313 456 7890', 'cliente', 'activo'),
('Sofia', 'Herrera Jiménez', 'sofia.herrera@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 314 567 8901', 'cliente', 'activo'),
('Diego', 'Vargas Morales', 'diego.vargas@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 315 678 9012', 'cliente', 'activo'),
('Valentina', 'Castro Ruiz', 'valentina.castro@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 316 789 0123', 'cliente', 'activo'),
('Andrés', 'Mendoza Peña', 'andres.mendoza@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 317 890 1234', 'cliente', 'activo'),
('Camila', 'Rojas Gutiérrez', 'camila.rojas@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 318 901 2345', 'cliente', 'activo'),
('Sebastián', 'Moreno Vega', 'sebastian.moreno@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 319 012 3456', 'cliente', 'activo'),
('Isabella', 'Díaz Castillo', 'isabella.diaz@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 320 123 4567', 'cliente', 'activo'),
('Mateo', 'Sánchez Aguilar', 'mateo.sanchez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 321 234 5678', 'cliente', 'activo'),
('Natalia', 'Cruz Herrera', 'natalia.cruz@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 322 345 6789', 'cliente', 'activo'),
('Alejandro', 'Flores Medina', 'alejandro.flores@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 323 456 7890', 'cliente', 'activo'),
('Gabriela', 'Ortega Ramos', 'gabriela.ortega@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+57 324 567 8901', 'cliente', 'activo');

-- =====================================================
-- INSERTAR DIRECCIONES DE CLIENTES
-- =====================================================

INSERT INTO `direcciones` (`usuario_id`, `direccion`, `ciudad`, `departamento`, `codigo_postal`, `pais`, `es_principal`) VALUES
(3, 'Carrera 15 #28-45 Apto 301', 'Barrancabermeja', 'Santander', '687031', 'Colombia', 1),
(4, 'Calle 80 #12-34 Casa 2', 'Bogotá', 'Cundinamarca', '110111', 'Colombia', 1),
(5, 'Avenida 68 #25-67 Apto 502', 'Medellín', 'Antioquia', '050001', 'Colombia', 1),
(6, 'Carrera 7 #32-10 Casa 1', 'Cali', 'Valle del Cauca', '760001', 'Colombia', 1),
(7, 'Calle 50 #15-89 Apto 201', 'Cartagena', 'Bolívar', '130001', 'Colombia', 1),
(8, 'Carrera 30 #45-12 Casa 3', 'Bucaramanga', 'Santander', '680001', 'Colombia', 1),
(9, 'Avenida 19 #23-45 Apto 401', 'Pereira', 'Risaralda', '660001', 'Colombia', 1),
(10, 'Calle 100 #11-23 Casa 2', 'Manizales', 'Caldas', '170001', 'Colombia', 1),
(11, 'Carrera 25 #67-89 Apto 301', 'Ibagué', 'Tolima', '730001', 'Colombia', 1),
(12, 'Calle 40 #34-56 Casa 1', 'Santa Marta', 'Magdalena', '470001', 'Colombia', 1),
(13, 'Avenida 5 #78-90 Apto 601', 'Pasto', 'Nariño', '520001', 'Colombia', 1),
(14, 'Carrera 10 #45-67 Casa 4', 'Armenia', 'Quindío', '630001', 'Colombia', 1),
(15, 'Calle 60 #12-34 Apto 201', 'Villavicencio', 'Meta', '500001', 'Colombia', 1),
(16, 'Carrera 20 #89-12 Casa 2', 'Neiva', 'Huila', '410001', 'Colombia', 1),
(17, 'Avenida 15 #56-78 Apto 501', 'Montería', 'Córdoba', '230001', 'Colombia', 1);

-- =====================================================
-- INSERTAR MÁS PRODUCTOS (50 productos)
-- =====================================================

INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `precio_oferta`, `categoria_id`, `marca_id`, `talla_id`, `color_id`, `genero_id`, `stock`, `stock_minimo`, `codigo_sku`, `destacado`, `estado`) VALUES
-- Nike
('Air Force 1', 'Zapatillas clásicas Nike Air Force 1 en cuero blanco', 280000.00, 250000.00, 1, 1, 13, 2, 1, 20, 5, 'TF-NK-001-40-0001', 1, 'activo'),
('Air Max 90', 'Zapatillas Nike Air Max 90 con tecnología de amortiguación', 320000.00, NULL, 1, 1, 14, 1, 1, 15, 5, 'TF-NK-002-41-0001', 1, 'activo'),
('Dunk Low', 'Zapatillas Nike Dunk Low estilo retro', 250000.00, 220000.00, 2, 1, 12, 3, 3, 18, 5, 'TF-NK-003-39-0001', 0, 'activo'),
('React Element 55', 'Zapatillas Nike React con tecnología React', 300000.00, NULL, 1, 1, 15, 2, 1, 12, 5, 'TF-NK-004-42-0001', 0, 'activo'),
('Blazer Mid', 'Zapatillas Nike Blazer Mid clásicas', 200000.00, 180000.00, 2, 1, 11, 1, 3, 25, 5, 'TF-NK-005-38-0001', 0, 'activo'),

-- Adidas
('Ultraboost 22', 'Zapatillas Adidas Ultraboost 22 con Boost', 450000.00, 400000.00, 1, 2, 13, 1, 1, 10, 5, 'TF-AD-001-40-0001', 1, 'activo'),
('Gazelle', 'Zapatillas Adidas Gazelle clásicas', 180000.00, NULL, 2, 2, 12, 4, 3, 22, 5, 'TF-AD-002-39-0001', 0, 'activo'),
('NMD R1', 'Zapatillas Adidas NMD R1 con Boost', 350000.00, 320000.00, 1, 2, 14, 2, 1, 16, 5, 'TF-AD-003-41-0001', 1, 'activo'),
('Samba', 'Zapatillas Adidas Samba icónicas', 160000.00, 140000.00, 2, 2, 10, 1, 3, 30, 5, 'TF-AD-004-37-0001', 0, 'activo'),
('Yeezy Boost 350', 'Zapatillas Adidas Yeezy Boost 350', 800000.00, NULL, 1, 2, 15, 1, 1, 5, 5, 'TF-AD-005-42-0001', 1, 'activo'),

-- Puma
('RS-X Reinvention', 'Zapatillas Puma RS-X con tecnología RS', 220000.00, 200000.00, 1, 3, 13, 3, 1, 18, 5, 'TF-PM-001-40-0001', 0, 'activo'),
('Suede Classic', 'Zapatillas Puma Suede Classic', 150000.00, NULL, 2, 3, 12, 2, 3, 25, 5, 'TF-PM-002-39-0001', 0, 'activo'),
('Thunder Spectra', 'Zapatillas Puma Thunder Spectra', 280000.00, 250000.00, 1, 3, 14, 1, 1, 14, 5, 'TF-PM-003-41-0001', 0, 'activo'),
('Cali Sport', 'Zapatillas Puma Cali Sport', 190000.00, 170000.00, 2, 3, 11, 4, 2, 20, 5, 'TF-PM-004-38-0001', 0, 'activo'),
('Future Rider', 'Zapatillas Puma Future Rider', 200000.00, NULL, 1, 3, 15, 2, 1, 16, 5, 'TF-PM-005-42-0001', 0, 'activo'),

-- Converse
('Chuck Taylor All Star High', 'Zapatillas Converse Chuck Taylor All Star High', 120000.00, 100000.00, 2, 5, 12, 1, 3, 35, 5, 'TF-CV-001-39-0001', 1, 'activo'),
('Chuck Taylor All Star Low', 'Zapatillas Converse Chuck Taylor All Star Low', 110000.00, 95000.00, 2, 5, 11, 2, 3, 40, 5, 'TF-CV-002-38-0001', 1, 'activo'),
('One Star', 'Zapatillas Converse One Star', 140000.00, NULL, 2, 5, 13, 3, 3, 28, 5, 'TF-CV-003-40-0001', 0, 'activo'),
('Jack Purcell', 'Zapatillas Converse Jack Purcell', 130000.00, 115000.00, 2, 5, 14, 1, 3, 22, 5, 'TF-CV-004-41-0001', 0, 'activo'),
('Chuck 70', 'Zapatillas Converse Chuck 70', 160000.00, 140000.00, 2, 5, 15, 2, 3, 18, 5, 'TF-CV-005-42-0001', 0, 'activo'),

-- Vans
('Old Skool Classic', 'Zapatillas Vans Old Skool Classic', 150000.00, 130000.00, 2, 6, 12, 1, 3, 30, 5, 'TF-VN-001-39-0001', 1, 'activo'),
('Authentic', 'Zapatillas Vans Authentic', 120000.00, NULL, 2, 6, 11, 2, 3, 35, 5, 'TF-VN-002-38-0001', 1, 'activo'),
('Sk8-Hi', 'Zapatillas Vans Sk8-Hi', 160000.00, 140000.00, 2, 6, 13, 3, 3, 25, 5, 'TF-VN-003-40-0001', 0, 'activo'),
('Era', 'Zapatillas Vans Era', 130000.00, 115000.00, 2, 6, 14, 1, 3, 28, 5, 'TF-VN-004-41-0001', 0, 'activo'),
('Slip-On', 'Zapatillas Vans Slip-On', 140000.00, NULL, 2, 6, 15, 2, 3, 32, 5, 'TF-VN-005-42-0001', 0, 'activo'),

-- New Balance
('574 Core', 'Zapatillas New Balance 574 Core', 200000.00, 180000.00, 1, 7, 13, 1, 1, 20, 5, 'TF-NB-001-40-0001', 1, 'activo'),
('990v5', 'Zapatillas New Balance 990v5', 450000.00, NULL, 1, 7, 14, 2, 1, 8, 5, 'TF-NB-002-41-0001', 1, 'activo'),
('327', 'Zapatillas New Balance 327', 180000.00, 160000.00, 2, 7, 12, 3, 3, 25, 5, 'TF-NB-003-39-0001', 0, 'activo'),
('1080v12', 'Zapatillas New Balance 1080v12', 380000.00, 350000.00, 1, 7, 15, 1, 1, 12, 5, 'TF-NB-004-42-0001', 0, 'activo'),
('530', 'Zapatillas New Balance 530', 160000.00, NULL, 2, 7, 11, 2, 3, 30, 5, 'TF-NB-005-38-0001', 0, 'activo'),

-- Reebok
('Classic Leather', 'Zapatillas Reebok Classic Leather', 170000.00, 150000.00, 2, 4, 13, 1, 3, 25, 5, 'TF-RB-001-40-0001', 0, 'activo'),
('Club C 85', 'Zapatillas Reebok Club C 85', 160000.00, NULL, 2, 4, 12, 2, 3, 28, 5, 'TF-RB-002-39-0001', 0, 'activo'),
('Nano X1', 'Zapatillas Reebok Nano X1', 300000.00, 280000.00, 1, 4, 14, 3, 1, 15, 5, 'TF-RB-003-41-0001', 0, 'activo'),
('Zig Kinetica', 'Zapatillas Reebok Zig Kinetica', 250000.00, 220000.00, 1, 4, 15, 1, 1, 18, 5, 'TF-RB-004-42-0001', 0, 'activo'),
('Floatride Energy', 'Zapatillas Reebok Floatride Energy', 200000.00, 180000.00, 1, 4, 11, 2, 1, 20, 5, 'TF-RB-005-38-0001', 0, 'activo'),

-- Under Armour
('Charged Assert 9', 'Zapatillas Under Armour Charged Assert 9', 180000.00, NULL, 1, 8, 13, 1, 1, 22, 5, 'TF-UA-001-40-0001', 0, 'activo'),
('HOVR Phantom 2', 'Zapatillas Under Armour HOVR Phantom 2', 280000.00, 250000.00, 1, 8, 14, 2, 1, 16, 5, 'TF-UA-002-41-0001', 0, 'activo'),
('Charged Bandit 6', 'Zapatillas Under Armour Charged Bandit 6', 200000.00, 180000.00, 1, 8, 15, 3, 1, 18, 5, 'TF-UA-003-42-0001', 0, 'activo'),
('HOVR Sonic 4', 'Zapatillas Under Armour HOVR Sonic 4', 240000.00, NULL, 1, 8, 12, 1, 1, 20, 5, 'TF-UA-004-39-0001', 0, 'activo'),
('Charged Pursuit 2', 'Zapatillas Under Armour Charged Pursuit 2', 160000.00, 140000.00, 1, 8, 11, 2, 1, 25, 5, 'TF-UA-005-38-0001', 0, 'activo');

-- =====================================================
-- INSERTAR HISTORIAL DE STOCK
-- =====================================================

INSERT INTO `historial_stock` (`producto_id`, `usuario_id`, `tipo`, `cantidad`, `stock_anterior`, `stock_nuevo`, `motivo`) VALUES
-- Stock inicial para productos existentes
(1, 1, 'entrada', 15, 0, 15, 'Stock inicial'),
(2, 1, 'entrada', 20, 0, 20, 'Stock inicial'),
(3, 1, 'entrada', 25, 0, 25, 'Stock inicial'),
(4, 1, 'entrada', 18, 0, 18, 'Stock inicial'),
(5, 1, 'entrada', 12, 0, 12, 'Stock inicial'),

-- Stock para nuevos productos
(6, 1, 'entrada', 20, 0, 20, 'Stock inicial'),
(7, 1, 'entrada', 15, 0, 15, 'Stock inicial'),
(8, 1, 'entrada', 18, 0, 18, 'Stock inicial'),
(9, 1, 'entrada', 12, 0, 12, 'Stock inicial'),
(10, 1, 'entrada', 5, 0, 5, 'Stock inicial'),
(11, 1, 'entrada', 18, 0, 18, 'Stock inicial'),
(12, 1, 'entrada', 25, 0, 25, 'Stock inicial'),
(13, 1, 'entrada', 14, 0, 14, 'Stock inicial'),
(14, 1, 'entrada', 20, 0, 20, 'Stock inicial'),
(15, 1, 'entrada', 16, 0, 16, 'Stock inicial'),
(16, 1, 'entrada', 35, 0, 35, 'Stock inicial'),
(17, 1, 'entrada', 40, 0, 40, 'Stock inicial'),
(18, 1, 'entrada', 28, 0, 28, 'Stock inicial'),
(19, 1, 'entrada', 22, 0, 22, 'Stock inicial'),
(20, 1, 'entrada', 18, 0, 18, 'Stock inicial'),
(21, 1, 'entrada', 30, 0, 30, 'Stock inicial'),
(22, 1, 'entrada', 35, 0, 35, 'Stock inicial'),
(23, 1, 'entrada', 25, 0, 25, 'Stock inicial'),
(24, 1, 'entrada', 28, 0, 28, 'Stock inicial'),
(25, 1, 'entrada', 32, 0, 32, 'Stock inicial'),
(26, 1, 'entrada', 20, 0, 20, 'Stock inicial'),
(27, 1, 'entrada', 8, 0, 8, 'Stock inicial'),
(28, 1, 'entrada', 25, 0, 25, 'Stock inicial'),
(29, 1, 'entrada', 12, 0, 12, 'Stock inicial'),
(30, 1, 'entrada', 30, 0, 30, 'Stock inicial'),
(31, 1, 'entrada', 25, 0, 25, 'Stock inicial'),
(32, 1, 'entrada', 28, 0, 28, 'Stock inicial'),
(33, 1, 'entrada', 15, 0, 15, 'Stock inicial'),
(34, 1, 'entrada', 18, 0, 18, 'Stock inicial'),
(35, 1, 'entrada', 20, 0, 20, 'Stock inicial'),
(36, 1, 'entrada', 22, 0, 22, 'Stock inicial'),
(37, 1, 'entrada', 16, 0, 16, 'Stock inicial'),
(38, 1, 'entrada', 18, 0, 18, 'Stock inicial'),
(39, 1, 'entrada', 20, 0, 20, 'Stock inicial'),
(40, 1, 'entrada', 25, 0, 25, 'Stock inicial');

-- =====================================================
-- INSERTAR PEDIDOS (30 pedidos)
-- =====================================================

INSERT INTO `pedidos` (`numero_pedido`, `usuario_id`, `empleado_id`, `total`, `subtotal`, `descuento`, `impuestos`, `metodo_pago_id`, `estado_pedido_id`, `tipo_pedido`, `fecha_pedido`, `fecha_envio`, `fecha_entrega`, `observaciones`) VALUES
('PED-2024-001', 3, 2, 450000.00, 450000.00, 0.00, 0.00, 2, 5, 'online', '2024-01-15 10:30:00', '2024-01-16 14:00:00', '2024-01-18 16:30:00', 'Entregado en oficina'),
('PED-2024-002', 4, 2, 320000.00, 320000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-01-16 15:45:00', NULL, '2024-01-16 15:45:00', 'Venta en tienda'),
('PED-2024-003', 5, 2, 280000.00, 280000.00, 0.00, 0.00, 3, 4, 'online', '2024-01-17 09:20:00', '2024-01-18 10:00:00', NULL, 'En tránsito'),
('PED-2024-004', 6, 2, 180000.00, 180000.00, 0.00, 0.00, 2, 3, 'online', '2024-01-18 14:15:00', NULL, NULL, 'Preparando pedido'),
('PED-2024-005', 7, 2, 550000.00, 550000.00, 0.00, 0.00, 4, 5, 'online', '2024-01-19 11:30:00', '2024-01-20 09:00:00', '2024-01-22 14:20:00', 'Entregado satisfactoriamente'),
('PED-2024-006', 8, 2, 240000.00, 240000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-01-20 16:00:00', NULL, '2024-01-20 16:00:00', 'Venta directa'),
('PED-2024-007', 9, 2, 380000.00, 380000.00, 0.00, 0.00, 2, 4, 'online', '2024-01-21 08:45:00', '2024-01-22 11:30:00', NULL, 'Enviado'),
('PED-2024-008', 10, 2, 160000.00, 160000.00, 0.00, 0.00, 3, 3, 'online', '2024-01-22 13:20:00', NULL, NULL, 'Procesando'),
('PED-2024-009', 11, 2, 420000.00, 420000.00, 0.00, 0.00, 2, 5, 'online', '2024-01-23 10:15:00', '2024-01-24 15:00:00', '2024-01-26 10:30:00', 'Cliente satisfecho'),
('PED-2024-010', 12, 2, 200000.00, 200000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-01-24 14:30:00', NULL, '2024-01-24 14:30:00', 'Venta en tienda'),
('PED-2024-011', 13, 2, 350000.00, 350000.00, 0.00, 0.00, 4, 4, 'online', '2024-01-25 09:00:00', '2024-01-26 08:00:00', NULL, 'En camino'),
('PED-2024-012', 14, 2, 190000.00, 190000.00, 0.00, 0.00, 2, 3, 'online', '2024-01-26 12:45:00', NULL, NULL, 'Preparando'),
('PED-2024-013', 15, 2, 480000.00, 480000.00, 0.00, 0.00, 3, 5, 'online', '2024-01-27 15:20:00', '2024-01-28 10:00:00', '2024-01-30 16:45:00', 'Entregado'),
('PED-2024-014', 16, 2, 220000.00, 220000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-01-28 11:00:00', NULL, '2024-01-28 11:00:00', 'Venta directa'),
('PED-2024-015', 17, 2, 300000.00, 300000.00, 0.00, 0.00, 2, 4, 'online', '2024-01-29 08:30:00', '2024-01-30 12:00:00', NULL, 'Enviado'),
('PED-2024-016', 3, 2, 170000.00, 170000.00, 0.00, 0.00, 3, 3, 'online', '2024-01-30 14:15:00', NULL, NULL, 'Procesando'),
('PED-2024-017', 4, 2, 410000.00, 410000.00, 0.00, 0.00, 2, 5, 'online', '2024-01-31 10:45:00', '2024-02-01 09:00:00', '2024-02-03 14:20:00', 'Entregado'),
('PED-2024-018', 5, 2, 150000.00, 150000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-02-01 16:30:00', NULL, '2024-02-01 16:30:00', 'Venta en tienda'),
('PED-2024-019', 6, 2, 360000.00, 360000.00, 0.00, 0.00, 4, 4, 'online', '2024-02-02 09:15:00', '2024-02-03 11:30:00', NULL, 'En tránsito'),
('PED-2024-020', 7, 2, 180000.00, 180000.00, 0.00, 0.00, 2, 3, 'online', '2024-02-03 13:00:00', NULL, NULL, 'Preparando'),
('PED-2024-021', 8, 2, 520000.00, 520000.00, 0.00, 0.00, 3, 5, 'online', '2024-02-04 11:20:00', '2024-02-05 14:00:00', '2024-02-07 10:15:00', 'Entregado'),
('PED-2024-022', 9, 2, 210000.00, 210000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-02-05 15:45:00', NULL, '2024-02-05 15:45:00', 'Venta directa'),
('PED-2024-023', 10, 2, 340000.00, 340000.00, 0.00, 0.00, 2, 4, 'online', '2024-02-06 08:00:00', '2024-02-07 10:00:00', NULL, 'Enviado'),
('PED-2024-024', 11, 2, 160000.00, 160000.00, 0.00, 0.00, 3, 3, 'online', '2024-02-07 12:30:00', NULL, NULL, 'Procesando'),
('PED-2024-025', 12, 2, 460000.00, 460000.00, 0.00, 0.00, 2, 5, 'online', '2024-02-08 14:45:00', '2024-02-09 09:00:00', '2024-02-11 16:30:00', 'Entregado'),
('PED-2024-026', 13, 2, 190000.00, 190000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-02-09 17:00:00', NULL, '2024-02-09 17:00:00', 'Venta en tienda'),
('PED-2024-027', 14, 2, 320000.00, 320000.00, 0.00, 0.00, 4, 4, 'online', '2024-02-10 09:30:00', '2024-02-11 12:00:00', NULL, 'En camino'),
('PED-2024-028', 15, 2, 170000.00, 170000.00, 0.00, 0.00, 2, 3, 'online', '2024-02-11 11:15:00', NULL, NULL, 'Preparando'),
('PED-2024-029', 16, 2, 390000.00, 390000.00, 0.00, 0.00, 3, 5, 'online', '2024-02-12 13:20:00', '2024-02-13 15:00:00', '2024-02-15 11:45:00', 'Entregado'),
('PED-2024-030', 17, 2, 230000.00, 230000.00, 0.00, 0.00, 1, 5, 'presencial', '2024-02-13 16:15:00', NULL, '2024-02-13 16:15:00', 'Venta directa');

-- =====================================================
-- INSERTAR DETALLES DE PEDIDOS
-- =====================================================

INSERT INTO `detalle_pedidos` (`pedido_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
-- Pedido 1
(1, 1, 1, 329000.00, 329000.00),
(1, 2, 1, 180000.00, 180000.00),

-- Pedido 2
(2, 3, 1, 120000.00, 120000.00),
(2, 4, 1, 150000.00, 150000.00),

-- Pedido 3
(3, 5, 1, 200000.00, 200000.00),
(3, 6, 1, 280000.00, 280000.00),

-- Pedido 4
(4, 7, 1, 180000.00, 180000.00),

-- Pedido 5
(5, 8, 1, 320000.00, 320000.00),
(5, 9, 1, 180000.00, 180000.00),

-- Pedido 6
(6, 10, 1, 160000.00, 160000.00),
(6, 11, 1, 220000.00, 220000.00),

-- Pedido 7
(7, 12, 1, 150000.00, 150000.00),
(7, 13, 1, 280000.00, 280000.00),

-- Pedido 8
(8, 14, 1, 190000.00, 190000.00),

-- Pedido 9
(9, 15, 1, 200000.00, 200000.00),
(9, 16, 1, 120000.00, 120000.00),

-- Pedido 10
(10, 17, 1, 110000.00, 110000.00),
(10, 18, 1, 140000.00, 140000.00),

-- Pedido 11
(11, 19, 1, 130000.00, 130000.00),
(11, 20, 1, 160000.00, 160000.00),

-- Pedido 12
(12, 21, 1, 150000.00, 150000.00),
(12, 22, 1, 120000.00, 120000.00),

-- Pedido 13
(13, 23, 1, 160000.00, 160000.00),
(13, 24, 1, 130000.00, 130000.00),

-- Pedido 14
(14, 25, 1, 140000.00, 140000.00),
(14, 26, 1, 200000.00, 200000.00),

-- Pedido 15
(15, 27, 1, 450000.00, 450000.00),
(15, 28, 1, 180000.00, 180000.00),

-- Pedido 16
(16, 29, 1, 160000.00, 160000.00),
(16, 30, 1, 160000.00, 160000.00),

-- Pedido 17
(17, 31, 1, 170000.00, 170000.00),
(17, 32, 1, 160000.00, 160000.00),

-- Pedido 18
(18, 33, 1, 300000.00, 300000.00),
(18, 34, 1, 250000.00, 250000.00),

-- Pedido 19
(19, 35, 1, 200000.00, 200000.00),
(19, 36, 1, 180000.00, 180000.00),

-- Pedido 20
(20, 37, 1, 180000.00, 180000.00),

-- Pedido 21
(21, 38, 1, 280000.00, 280000.00),
(21, 39, 1, 200000.00, 200000.00),

-- Pedido 22
(22, 40, 1, 160000.00, 160000.00),
(22, 1, 1, 329000.00, 329000.00),

-- Pedido 23
(23, 2, 1, 180000.00, 180000.00),
(23, 3, 1, 120000.00, 120000.00),

-- Pedido 24
(24, 4, 1, 150000.00, 150000.00),
(24, 5, 1, 200000.00, 200000.00),

-- Pedido 25
(25, 6, 1, 280000.00, 280000.00),
(25, 7, 1, 180000.00, 180000.00),

-- Pedido 26
(26, 8, 1, 320000.00, 320000.00),
(26, 9, 1, 180000.00, 180000.00),

-- Pedido 27
(27, 10, 1, 160000.00, 160000.00),
(27, 11, 1, 220000.00, 220000.00),

-- Pedido 28
(28, 12, 1, 150000.00, 150000.00),
(28, 13, 1, 280000.00, 280000.00),

-- Pedido 29
(29, 14, 1, 190000.00, 190000.00),
(29, 15, 1, 200000.00, 200000.00),

-- Pedido 30
(30, 16, 1, 120000.00, 120000.00),
(30, 17, 1, 110000.00, 110000.00);

-- =====================================================
-- INSERTAR FACTURAS
-- =====================================================

INSERT INTO `facturas` (`numero_factura`, `pedido_id`, `usuario_id`, `empleado_id`, `total`, `fecha_emision`, `fecha_vencimiento`, `estado`, `observaciones`) VALUES
('FAC-2024-001', 1, 3, 2, 450000.00, '2024-01-15 10:30:00', '2024-01-22 10:30:00', 'pagada', 'Factura pagada'),
('FAC-2024-002', 2, 4, 2, 320000.00, '2024-01-16 15:45:00', '2024-01-16 15:45:00', 'pagada', 'Pago inmediato'),
('FAC-2024-003', 3, 5, 2, 280000.00, '2024-01-17 09:20:00', '2024-01-24 09:20:00', 'pendiente', 'Pendiente de pago'),
('FAC-2024-004', 4, 6, 2, 180000.00, '2024-01-18 14:15:00', '2024-01-25 14:15:00', 'pendiente', 'Procesando pago'),
('FAC-2024-005', 5, 7, 2, 550000.00, '2024-01-19 11:30:00', '2024-01-26 11:30:00', 'pagada', 'Factura pagada'),
('FAC-2024-006', 6, 8, 2, 240000.00, '2024-01-20 16:00:00', '2024-01-20 16:00:00', 'pagada', 'Pago inmediato'),
('FAC-2024-007', 7, 9, 2, 380000.00, '2024-01-21 08:45:00', '2024-01-28 08:45:00', 'pendiente', 'Pendiente de pago'),
('FAC-2024-008', 8, 10, 2, 160000.00, '2024-01-22 13:20:00', '2024-01-29 13:20:00', 'pendiente', 'Procesando pago'),
('FAC-2024-009', 9, 11, 2, 420000.00, '2024-01-23 10:15:00', '2024-01-30 10:15:00', 'pagada', 'Factura pagada'),
('FAC-2024-010', 10, 12, 2, 200000.00, '2024-01-24 14:30:00', '2024-01-24 14:30:00', 'pagada', 'Pago inmediato'),
('FAC-2024-011', 11, 13, 2, 350000.00, '2024-01-25 09:00:00', '2024-02-01 09:00:00', 'pendiente', 'Pendiente de pago'),
('FAC-2024-012', 12, 14, 2, 190000.00, '2024-01-26 12:45:00', '2024-02-02 12:45:00', 'pendiente', 'Procesando pago'),
('FAC-2024-013', 13, 15, 2, 480000.00, '2024-01-27 15:20:00', '2024-02-03 15:20:00', 'pagada', 'Factura pagada'),
('FAC-2024-014', 14, 16, 2, 220000.00, '2024-01-28 11:00:00', '2024-01-28 11:00:00', 'pagada', 'Pago inmediato'),
('FAC-2024-015', 15, 17, 2, 300000.00, '2024-01-29 08:30:00', '2024-02-05 08:30:00', 'pendiente', 'Pendiente de pago'),
('FAC-2024-016', 16, 3, 2, 170000.00, '2024-01-30 14:15:00', '2024-02-06 14:15:00', 'pendiente', 'Procesando pago'),
('FAC-2024-017', 17, 4, 2, 410000.00, '2024-01-31 10:45:00', '2024-02-07 10:45:00', 'pagada', 'Factura pagada'),
('FAC-2024-018', 18, 5, 2, 150000.00, '2024-02-01 16:30:00', '2024-02-01 16:30:00', 'pagada', 'Pago inmediato'),
('FAC-2024-019', 19, 6, 2, 360000.00, '2024-02-02 09:15:00', '2024-02-09 09:15:00', 'pendiente', 'Pendiente de pago'),
('FAC-2024-020', 20, 7, 2, 180000.00, '2024-02-03 13:00:00', '2024-02-10 13:00:00', 'pendiente', 'Procesando pago'),
('FAC-2024-021', 21, 8, 2, 520000.00, '2024-02-04 11:20:00', '2024-02-11 11:20:00', 'pagada', 'Factura pagada'),
('FAC-2024-022', 22, 9, 2, 210000.00, '2024-02-05 15:45:00', '2024-02-05 15:45:00', 'pagada', 'Pago inmediato'),
('FAC-2024-023', 23, 10, 2, 340000.00, '2024-02-06 08:00:00', '2024-02-13 08:00:00', 'pendiente', 'Pendiente de pago'),
('FAC-2024-024', 24, 11, 2, 160000.00, '2024-02-07 12:30:00', '2024-02-14 12:30:00', 'pendiente', 'Procesando pago'),
('FAC-2024-025', 25, 12, 2, 460000.00, '2024-02-08 14:45:00', '2024-02-15 14:45:00', 'pagada', 'Factura pagada'),
('FAC-2024-026', 26, 13, 2, 190000.00, '2024-02-09 17:00:00', '2024-02-09 17:00:00', 'pagada', 'Pago inmediato'),
('FAC-2024-027', 27, 14, 2, 320000.00, '2024-02-10 09:30:00', '2024-02-17 09:30:00', 'pendiente', 'Pendiente de pago'),
('FAC-2024-028', 28, 15, 2, 170000.00, '2024-02-11 11:15:00', '2024-02-18 11:15:00', 'pendiente', 'Procesando pago'),
('FAC-2024-029', 29, 16, 2, 390000.00, '2024-02-12 13:20:00', '2024-02-19 13:20:00', 'pagada', 'Factura pagada'),
('FAC-2024-030', 30, 17, 2, 230000.00, '2024-02-13 16:15:00', '2024-02-13 16:15:00', 'pagada', 'Pago inmediato');

-- =====================================================
-- INSERTAR MOVIMIENTOS DE STOCK (VENTAS)
-- =====================================================

INSERT INTO `historial_stock` (`producto_id`, `usuario_id`, `tipo`, `cantidad`, `stock_anterior`, `stock_nuevo`, `motivo`) VALUES
-- Ventas del mes de enero
(1, 2, 'salida', 1, 15, 14, 'Venta pedido PED-2024-001'),
(2, 2, 'salida', 1, 20, 19, 'Venta pedido PED-2024-001'),
(3, 2, 'salida', 1, 25, 24, 'Venta pedido PED-2024-002'),
(4, 2, 'salida', 1, 18, 17, 'Venta pedido PED-2024-002'),
(5, 2, 'salida', 1, 12, 11, 'Venta pedido PED-2024-003'),
(6, 2, 'salida', 1, 20, 19, 'Venta pedido PED-2024-003'),
(7, 2, 'salida', 1, 15, 14, 'Venta pedido PED-2024-004'),
(8, 2, 'salida', 1, 18, 17, 'Venta pedido PED-2024-005'),
(9, 2, 'salida', 1, 12, 11, 'Venta pedido PED-2024-005'),
(10, 2, 'salida', 1, 5, 4, 'Venta pedido PED-2024-006'),
(11, 2, 'salida', 1, 18, 17, 'Venta pedido PED-2024-006'),
(12, 2, 'salida', 1, 25, 24, 'Venta pedido PED-2024-007'),
(13, 2, 'salida', 1, 14, 13, 'Venta pedido PED-2024-007'),
(14, 2, 'salida', 1, 20, 19, 'Venta pedido PED-2024-008'),
(15, 2, 'salida', 1, 16, 15, 'Venta pedido PED-2024-009'),
(16, 2, 'salida', 1, 35, 34, 'Venta pedido PED-2024-009'),
(17, 2, 'salida', 1, 40, 39, 'Venta pedido PED-2024-010'),
(18, 2, 'salida', 1, 28, 27, 'Venta pedido PED-2024-010'),
(19, 2, 'salida', 1, 22, 21, 'Venta pedido PED-2024-011'),
(20, 2, 'salida', 1, 18, 17, 'Venta pedido PED-2024-011'),
(21, 2, 'salida', 1, 30, 29, 'Venta pedido PED-2024-012'),
(22, 2, 'salida', 1, 35, 34, 'Venta pedido PED-2024-012'),
(23, 2, 'salida', 1, 25, 24, 'Venta pedido PED-2024-013'),
(24, 2, 'salida', 1, 28, 27, 'Venta pedido PED-2024-013'),
(25, 2, 'salida', 1, 32, 31, 'Venta pedido PED-2024-014'),
(26, 2, 'salida', 1, 20, 19, 'Venta pedido PED-2024-014'),
(27, 2, 'salida', 1, 8, 7, 'Venta pedido PED-2024-015'),
(28, 2, 'salida', 1, 25, 24, 'Venta pedido PED-2024-015'),
(29, 2, 'salida', 1, 12, 11, 'Venta pedido PED-2024-016'),
(30, 2, 'salida', 1, 30, 29, 'Venta pedido PED-2024-016'),
(31, 2, 'salida', 1, 25, 24, 'Venta pedido PED-2024-017'),
(32, 2, 'salida', 1, 28, 27, 'Venta pedido PED-2024-017'),
(33, 2, 'salida', 1, 15, 14, 'Venta pedido PED-2024-018'),
(34, 2, 'salida', 1, 18, 17, 'Venta pedido PED-2024-018'),
(35, 2, 'salida', 1, 20, 19, 'Venta pedido PED-2024-019'),
(36, 2, 'salida', 1, 22, 21, 'Venta pedido PED-2024-019'),
(37, 2, 'salida', 1, 16, 15, 'Venta pedido PED-2024-020'),
(38, 2, 'salida', 1, 18, 17, 'Venta pedido PED-2024-021'),
(39, 2, 'salida', 1, 20, 19, 'Venta pedido PED-2024-021'),
(40, 2, 'salida', 1, 25, 24, 'Venta pedido PED-2024-022');

-- =====================================================
-- INSERTAR PRODUCTOS EN CARRITO (ALGUNOS CLIENTES)
-- =====================================================

INSERT INTO `carrito` (`usuario_id`, `producto_id`, `cantidad`, `precio`, `fecha_agregado`) VALUES
(3, 1, 1, 329000.00, '2024-02-14 10:30:00'),
(3, 2, 1, 180000.00, '2024-02-14 10:35:00'),
(4, 3, 2, 120000.00, '2024-02-14 11:15:00'),
(5, 4, 1, 150000.00, '2024-02-14 12:00:00'),
(6, 5, 1, 200000.00, '2024-02-14 13:20:00'),
(7, 6, 1, 280000.00, '2024-02-14 14:45:00'),
(8, 7, 1, 180000.00, '2024-02-14 15:30:00'),
(9, 8, 1, 320000.00, '2024-02-14 16:15:00'),
(10, 9, 1, 180000.00, '2024-02-14 17:00:00'),
(11, 10, 1, 160000.00, '2024-02-14 18:30:00');

-- Reactivar restricciones de clave foránea
SET FOREIGN_KEY_CHECKS = 1;

COMMIT;
