-- Schema completo para Tennis y Fragancias
-- Ejecutar este script en la base de datos MySQL

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS tennisyfragancias_db;
USE tennisyfragancias_db;

-- Tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    rol ENUM('administrador', 'empleado', 'cliente') DEFAULT 'cliente',
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    activa BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    categoria_id INT,
    imagen VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabla pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'confirmado', 'enviado', 'entregado', 'cancelado') DEFAULT 'pendiente',
    tipo_pedido ENUM('online', 'presencial') DEFAULT 'online',
    empleado_id INT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (empleado_id) REFERENCES usuarios(id)
);

-- Tabla detalle_pedidos
CREATE TABLE IF NOT EXISTS detalle_pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla carrito
CREATE TABLE IF NOT EXISTS carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla notificaciones
CREATE TABLE IF NOT EXISTS notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    mensaje TEXT NOT NULL,
    leida BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla facturas
CREATE TABLE IF NOT EXISTS facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    numero_factura VARCHAR(50) UNIQUE NOT NULL,
    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

-- Insertar datos de prueba
INSERT INTO usuarios (nombre, email, password, rol, telefono, direccion) VALUES
('Administrador', 'admin@tennisyfragancias.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', '+57 300 123 4567', 'Barrancabermeja, Santander'),
('Empleado', 'empleado@tennisyfragancias.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'empleado', '+57 300 123 4568', 'Barrancabermeja, Santander'),
('Cliente Ejemplo', 'cliente@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente', '+57 300 123 4569', 'Barrancabermeja, Santander');

INSERT INTO categorias (nombre, descripcion) VALUES
('Tennis', 'Calzado deportivo para todas las actividades'),
('Zapatos Formales', 'Calzado elegante para ocasiones especiales'),
('Sandalias', 'Calzado cómodo para el verano'),
('Botas', 'Calzado resistente para el invierno');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) VALUES
('Tennis Nike Air Max', 'Tennis deportivos de alta calidad', 250000, 50, 1),
('Zapatos Oxford Negros', 'Zapatos formales elegantes', 180000, 30, 2),
('Sandalias Adidas', 'Sandalias cómodas para el día', 120000, 40, 3),
('Botas Timberland', 'Botas resistentes para el invierno', 300000, 25, 4),
('Tennis Converse', 'Tennis clásicos y versátiles', 150000, 60, 1),
('Zapatos Derby Marrones', 'Zapatos casuales elegantes', 200000, 35, 2);
