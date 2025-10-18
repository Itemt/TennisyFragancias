-- Script SQL para crear usuarios directamente en la base de datos
-- Ejecutar en Coolify Terminal

-- Crear usuario administrador
INSERT INTO usuarios (nombre, apellido, email, password, password_hash, telefono, direccion, ciudad, departamento, rol, estado, activo, fecha_registro) 
VALUES (
    'Administrador',
    'Sistema', 
    'admin@tennisyfragancias.com',
    'Admin123!',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '3001234567',
    'Calle 123 #45-67',
    'Barrancabermeja',
    'Santander',
    'administrador',
    'activo',
    1,
    NOW()
);

-- Crear usuario empleado
INSERT INTO usuarios (nombre, apellido, email, password, password_hash, telefono, direccion, ciudad, departamento, rol, estado, activo, fecha_registro) 
VALUES (
    'Empleado',
    'Ventas',
    'empleado@tennisyfragancias.com', 
    'Empleado123!',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '3007654321',
    'Calle 456 #78-90',
    'Barrancabermeja',
    'Santander',
    'empleado',
    'activo',
    1,
    NOW()
);

-- Verificar usuarios creados
SELECT id, nombre, apellido, email, rol, estado FROM usuarios WHERE email IN ('admin@tennisyfragancias.com', 'empleado@tennisyfragancias.com');
