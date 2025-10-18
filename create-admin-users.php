<?php
/**
 * Script para crear usuarios de administrador y empleado
 * Se ejecuta automáticamente en producción
 */

// Verificar que estamos en producción
if (!isset($_SERVER['HTTP_HOST']) || strpos($_SERVER['HTTP_HOST'], 'itemt.tech') === false) {
    return;
}

// Verificar si ya se ejecutó hoy
$users_file = __DIR__ . '/.users_created';
$today = date('Y-m-d');

if (file_exists($users_file) && file_get_contents($users_file) === $today) {
    // Ya se ejecutó hoy, no hacer nada
    return;
}

// Cargar configuración
require_once 'app/config/configuracion.php';

// Log para debug
error_log("🔧 Ejecutando creación automática de usuarios...");

try {
    // Crear conexión directa a la base de datos
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USUARIO, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    error_log("✅ Conexión a la base de datos establecida");
    
    // ========================================
    // CREAR USUARIO ADMINISTRADOR
    // ========================================
    error_log("🔄 Creando usuario administrador...");
    
    $adminEmail = 'admin@tennisyfragancias.com';
    $adminPassword = 'Admin123!';
    $adminPasswordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
    
    // Verificar si el administrador ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$adminEmail]);
    
    if ($stmt->fetch()) {
        error_log("  ℹ️ Usuario administrador ya existe");
    } else {
        // Crear administrador
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, password_hash, telefono, direccion, ciudad, departamento, rol, estado, activo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            'Administrador',
            'Sistema',
            $adminEmail,
            $adminPassword, // Para compatibilidad
            $adminPasswordHash,
            '3001234567',
            'Calle 123 #45-67',
            'Barrancabermeja',
            'Santander',
            'administrador',
            'activo',
            1
        ]);
        
        error_log("  ✅ Usuario administrador creado");
        error_log("  📧 Email: $adminEmail");
        error_log("  🔑 Password: $adminPassword");
    }
    
    // ========================================
    // CREAR USUARIO EMPLEADO
    // ========================================
    error_log("🔄 Creando usuario empleado...");
    
    $empleadoEmail = 'empleado@tennisyfragancias.com';
    $empleadoPassword = 'Empleado123!';
    $empleadoPasswordHash = password_hash($empleadoPassword, PASSWORD_DEFAULT);
    
    // Verificar si el empleado ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$empleadoEmail]);
    
    if ($stmt->fetch()) {
        error_log("  ℹ️ Usuario empleado ya existe");
    } else {
        // Crear empleado
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, password_hash, telefono, direccion, ciudad, departamento, rol, estado, activo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            'Empleado',
            'Ventas',
            $empleadoEmail,
            $empleadoPassword, // Para compatibilidad
            $empleadoPasswordHash,
            '3007654321',
            'Calle 456 #78-90',
            'Barrancabermeja',
            'Santander',
            'empleado',
            'activo',
            1
        ]);
        
        error_log("  ✅ Usuario empleado creado");
        error_log("  📧 Email: $empleadoEmail");
        error_log("  🔑 Password: $empleadoPassword");
    }
    
    // Marcar que los usuarios se crearon hoy
    file_put_contents($users_file, $today);
    
    error_log("🎉 ¡Usuarios creados exitosamente!");
    error_log("✅ Administrador: admin@tennisyfragancias.com");
    error_log("✅ Empleado: empleado@tennisyfragancias.com");
    error_log("🔐 Credenciales de acceso:");
    error_log("👑 Admin: Admin123!");
    error_log("👷 Empleado: Empleado123!");
    error_log("🚀 Los usuarios están listos para usar!");
    
} catch (Exception $e) {
    error_log("❌ Error durante la creación de usuarios: " . $e->getMessage());
    error_log("🔧 Verifica la configuración de la base de datos");
    exit(1);
}
?>
