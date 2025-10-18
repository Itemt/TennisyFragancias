<?php
/**
 * Script que se ejecuta automáticamente después de cada despliegue
 * Configurar en Coolify para que se ejecute en cada build
 */

// Verificar que estamos en producción
if (!isset($_SERVER['HTTP_HOST']) || strpos($_SERVER['HTTP_HOST'], 'itemt.tech') === false) {
    echo "ℹ️ No es producción, saltando migración automática\n";
    exit(0);
}

echo "🚀 Ejecutando migración automática post-despliegue...\n";

// Ejecutar migración de producción
require_once 'migrate-production.php';

echo "✅ Migración automática completada\n";
?>
