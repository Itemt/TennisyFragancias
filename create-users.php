<?php
/**
 * Script para crear usuarios de empleado y administrador
 * Tennis y Fragancias - E-commerce
 * 
 * Este script crea usuarios por defecto para:
 * - Administrador
 * - Empleado
 * 
 * Se ejecuta automáticamente en producción
 */

// Verificar si ya se ejecutó hoy
$users_file = __DIR__ . '/.users_created';
$today = date('Y-m-d');

if (file_exists($users_file) && file_get_contents($users_file) === $today) {
    // Ya se ejecutó hoy, no hacer nada
    return;
}

// Verificar que estamos en producción
if (!isset($_SERVER['HTTP_HOST']) || strpos($_SERVER['HTTP_HOST'], 'itemt.tech') === false) {
    return;
}

// Cargar configuración
require_once 'app/config/configuracion.php';

echo "👥 Creando usuarios por defecto...\n";
echo "==================================\n\n";

try {
    // Crear conexión directa a la base de datos
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USUARIO, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "✅ Conexión a la base de datos establecida\n\n";
    
    // ========================================
    // 1. CREAR USUARIO ADMINISTRADOR
    // ========================================
    echo "🔄 Creando usuario administrador...\n";
    
    $adminEmail = 'admin@tennisyfragancias.com';
    $adminPassword = 'Admin123!';
    $adminPasswordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
    
    // Verificar si el administrador ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$adminEmail]);
    
    if ($stmt->fetch()) {
        echo "  ℹ️ Usuario administrador ya existe\n";
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
        
        echo "  ✅ Usuario administrador creado\n";
        echo "  📧 Email: $adminEmail\n";
        echo "  🔑 Password: $adminPassword\n";
    }
    
    // ========================================
    // 2. CREAR USUARIO EMPLEADO
    // ========================================
    echo "\n🔄 Creando usuario empleado...\n";
    
    $empleadoEmail = 'empleado@tennisyfragancias.com';
    $empleadoPassword = 'Empleado123!';
    $empleadoPasswordHash = password_hash($empleadoPassword, PASSWORD_DEFAULT);
    
    // Verificar si el empleado ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$empleadoEmail]);
    
    if ($stmt->fetch()) {
        echo "  ℹ️ Usuario empleado ya existe\n";
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
        
        echo "  ✅ Usuario empleado creado\n";
        echo "  📧 Email: $empleadoEmail\n";
        echo "  🔑 Password: $empleadoPassword\n";
    }
    
    // ========================================
    // 3. CREAR USUARIO CLIENTE DE PRUEBA
    // ========================================
    echo "\n🔄 Creando usuario cliente de prueba...\n";
    
    $clienteEmail = 'cliente@tennisyfragancias.com';
    $clientePassword = 'Cliente123!';
    $clientePasswordHash = password_hash($clientePassword, PASSWORD_DEFAULT);
    
    // Verificar si el cliente ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$clienteEmail]);
    
    if ($stmt->fetch()) {
        echo "  ℹ️ Usuario cliente ya existe\n";
    } else {
        // Crear cliente
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, password_hash, telefono, direccion, ciudad, departamento, rol, estado, activo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            'Cliente',
            'Prueba',
            $clienteEmail,
            $clientePassword, // Para compatibilidad
            $clientePasswordHash,
            '3009876543',
            'Calle 789 #12-34',
            'Barrancabermeja',
            'Santander',
            'cliente',
            'activo',
            1
        ]);
        
        echo "  ✅ Usuario cliente creado\n";
        echo "  📧 Email: $clienteEmail\n";
        echo "  🔑 Password: $clientePassword\n";
    }
    
    // Marcar que los usuarios se crearon hoy
    file_put_contents($users_file, $today);
    
    echo "\n🎉 ¡Usuarios creados exitosamente!\n";
    echo "==================================\n";
    echo "✅ Administrador: admin@tennisyfragancias.com\n";
    echo "✅ Empleado: empleado@tennisyfragancias.com\n";
    echo "✅ Cliente: cliente@tennisyfragancias.com\n";
    echo "\n🔐 Credenciales de acceso:\n";
    echo "👑 Admin: Admin123!\n";
    echo "👷 Empleado: Empleado123!\n";
    echo "🛒 Cliente: Cliente123!\n";
    echo "\n🚀 Los usuarios están listos para usar!\n";
    
} catch (Exception $e) {
    echo "\n❌ Error durante la creación de usuarios: " . $e->getMessage() . "\n";
    echo "🔧 Verifica la configuración de la base de datos\n";
    exit(1);
}
?>
