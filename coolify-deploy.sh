#!/bin/bash
# Script de despliegue para Coolify
# Se ejecuta automáticamente en cada build

set -e

echo "🚀 Iniciando despliegue en Coolify..."

# 1. Instalar dependencias de Composer
echo "📦 Instalando dependencias de Composer..."
composer install --no-dev --optimize-autoloader

# 2. Configurar permisos
echo "🔐 Configurando permisos..."
chmod -R 755 public/
chmod -R 755 app/
chmod -R 755 database/

# 3. Ejecutar migración de base de datos
echo "🔄 Ejecutando migración de base de datos..."
php migrate-production.php

# 4. Limpiar caché si existe
echo "🧹 Limpiando caché..."
if [ -d "app/cache" ]; then
    rm -rf app/cache/*
fi

# 5. Verificar que el sitio funciona
echo "✅ Verificando que el sitio funciona..."
if [ -f "index.php" ]; then
    echo "✅ index.php encontrado"
else
    echo "❌ index.php no encontrado"
    exit 1
fi

echo "🎉 ¡Despliegue completado exitosamente!"
