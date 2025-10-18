<?php
/**
 * Script para forzar la creación de usuarios
 * Ejecutar directamente en el navegador
 */

// Cargar configuración
require_once 'app/config/configuracion.php';

echo "<h2>🔧 Creando usuarios de administrador y empleado...</h2>";

try {
    // Crear conexión directa a la base de datos
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USUARIO, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<p>✅ Conexión a la base de datos establecida</p>";
    
    // ========================================
    // CREAR USUARIO ADMINISTRADOR
    // ========================================
    echo "<h3>🔄 Creando usuario administrador...</h3>";
    
    $adminEmail = 'admin@tennisyfragancias.com';
    $adminPassword = 'Admin123!';
    $adminPasswordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
    
    // Verificar si el administrador ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$adminEmail]);
    
    if ($stmt->fetch()) {
        echo "<p>ℹ️ Usuario administrador ya existe</p>";
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
        
        echo "<p>✅ Usuario administrador creado</p>";
        echo "<p>📧 Email: $adminEmail</p>";
        echo "<p>🔑 Password: $adminPassword</p>";
    }
    
    // ========================================
    // CREAR USUARIO EMPLEADO
    // ========================================
    echo "<h3>🔄 Creando usuario empleado...</h3>";
    
    $empleadoEmail = 'empleado@tennisyfragancias.com';
    $empleadoPassword = 'Empleado123!';
    $empleadoPasswordHash = password_hash($empleadoPassword, PASSWORD_DEFAULT);
    
    // Verificar si el empleado ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$empleadoEmail]);
    
    if ($stmt->fetch()) {
        echo "<p>ℹ️ Usuario empleado ya existe</p>";
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
        
        echo "<p>✅ Usuario empleado creado</p>";
        echo "<p>📧 Email: $empleadoEmail</p>";
        echo "<p>🔑 Password: $empleadoPassword</p>";
    }
    
    echo "<h2>🎉 ¡Usuarios creados exitosamente!</h2>";
    echo "<p>✅ Administrador: admin@tennisyfragancias.com</p>";
    echo "<p>✅ Empleado: empleado@tennisyfragancias.com</p>";
    echo "<h3>🔐 Credenciales de acceso:</h3>";
    echo "<p>👑 Admin: Admin123!</p>";
    echo "<p>👷 Empleado: Empleado123!</p>";
    echo "<p>🚀 Los usuarios están listos para usar!</p>";
    
} catch (Exception $e) {
    echo "<h3>❌ Error durante la creación de usuarios:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>🔧 Verifica la configuración de la base de datos</p>";
}
?>
