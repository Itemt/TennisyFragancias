<?php
/**
 * Script para probar el login y verificar usuarios
 */

// Cargar configuración
require_once 'app/config/configuracion.php';

echo "<h2>🔍 Verificando usuarios y login...</h2>";

try {
    // Crear conexión directa a la base de datos
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USUARIO, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<p>✅ Conexión a la base de datos establecida</p>";
    
    // Verificar usuarios existentes
    echo "<h3>👥 Usuarios en la base de datos:</h3>";
    $stmt = $pdo->prepare("SELECT id, nombre, apellido, email, rol, estado, password, password_hash FROM usuarios WHERE email IN (?, ?)");
    $stmt->execute(['admin@tennisyfragancias.com', 'empleado@tennisyfragancias.com']);
    $usuarios = $stmt->fetchAll();
    
    if (empty($usuarios)) {
        echo "<p>❌ No se encontraron usuarios</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Password</th><th>Password Hash</th></tr>";
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario['id'] . "</td>";
            echo "<td>" . $usuario['nombre'] . " " . $usuario['apellido'] . "</td>";
            echo "<td>" . $usuario['email'] . "</td>";
            echo "<td>" . $usuario['rol'] . "</td>";
            echo "<td>" . $usuario['estado'] . "</td>";
            echo "<td>" . (empty($usuario['password']) ? '❌ Vacío' : '✅ ' . substr($usuario['password'], 0, 10) . '...') . "</td>";
            echo "<td>" . (empty($usuario['password_hash']) ? '❌ Vacío' : '✅ Hash presente') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Probar autenticación
    echo "<h3>🔐 Probando autenticación...</h3>";
    
    // Cargar las clases necesarias
    require_once 'app/config/base_datos.php';
    require_once 'app/core/Modelo.php';
    require_once 'app/modelos/Usuario.php';
    
    $usuarioModelo = new Usuario();
    
    // Probar admin
    echo "<h4>👑 Probando Admin:</h4>";
    $admin = $usuarioModelo->autenticar('admin@tennisyfragancias.com', 'Admin123!');
    if ($admin) {
        echo "<p>✅ Login admin exitoso</p>";
        echo "<p>ID: " . $admin['id'] . "</p>";
        echo "<p>Nombre: " . $admin['nombre'] . " " . $admin['apellido'] . "</p>";
        echo "<p>Rol: " . $admin['rol'] . "</p>";
    } else {
        echo "<p>❌ Login admin falló</p>";
    }
    
    // Probar empleado
    echo "<h4>👷 Probando Empleado:</h4>";
    $empleado = $usuarioModelo->autenticar('empleado@tennisyfragancias.com', 'Empleado123!');
    if ($empleado) {
        echo "<p>✅ Login empleado exitoso</p>";
        echo "<p>ID: " . $empleado['id'] . "</p>";
        echo "<p>Nombre: " . $empleado['nombre'] . " " . $empleado['apellido'] . "</p>";
        echo "<p>Rol: " . $empleado['rol'] . "</p>";
    } else {
        echo "<p>❌ Login empleado falló</p>";
    }
    
} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
