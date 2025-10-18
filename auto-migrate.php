<?php
/**
 * Migración automática que se ejecuta al cargar la aplicación
 * Solo se ejecuta una vez por día para evitar sobrecarga
 */

// Verificar si ya se ejecutó hoy
$migration_file = __DIR__ . '/.migration_done';
$today = date('Y-m-d');

if (file_exists($migration_file) && file_get_contents($migration_file) === $today) {
    // Ya se ejecutó hoy, no hacer nada
    return;
}

// Verificar que estamos en producción
if (!isset($_SERVER['HTTP_HOST']) || strpos($_SERVER['HTTP_HOST'], 'itemt.tech') === false) {
    return;
}

// Ejecutar migración
try {
    require_once 'migrate-production.php';
    
    // Marcar que se ejecutó hoy
    file_put_contents($migration_file, $today);
    
} catch (Exception $e) {
    // Log del error pero no interrumpir la aplicación
    error_log("Error en migración automática: " . $e->getMessage());
}
?>
