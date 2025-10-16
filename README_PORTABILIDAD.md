# 🚀 Guía de Portabilidad - Tennis y Fragancias

## 📋 Resumen de Mejoras

Este proyecto ha sido mejorado para ser completamente **portable** y fácil de mover entre diferentes entornos. Las mejoras incluyen:

### ✨ Nuevas Características

1. **🔧 Configuración Portable**
   - Sistema de configuración basado en archivos `.env`
   - Configuración automática para diferentes entornos
   - Valores por defecto que funcionan "out of the box"

2. **⚙️ Instalador Automático**
   - Script de instalación web (`instalar.php`)
   - Verificación automática de requisitos
   - Configuración de base de datos en pasos guiados
   - Instalación automática de la estructura de datos

3. **🗄️ Sistema de Respaldo**
   - Interfaz web para respaldos (`database/backup.php`)
   - Respaldos automáticos con fecha y hora
   - Restauración fácil entre entornos
   - Historial de respaldos disponibles

## 🎯 Instalación Rápida (3 Pasos)

### Para Estudiantes Universitarios

1. **Copiar archivos**
   ```bash
   # Copiar la carpeta del proyecto a htdocs
   cp -r tennisyfragancias/ C:\xampp\htdocs\
   ```

2. **Iniciar XAMPP**
   - Abrir Panel de Control de XAMPP
   - Activar Apache y MySQL

3. **Instalación automática**
   - Ir a: `http://localhost/tennisyfragancias/instalar.php`
   - Seguir los 3 pasos del instalador
   - ¡Listo!

## 🔄 Mover el Proyecto Entre Entornos

### De Desarrollo a Producción

1. **Crear respaldo en desarrollo**
   ```bash
   # Ir a: http://localhost/tennisyfragancias/database/backup.php
   # Crear respaldo automático
   ```

2. **Copiar archivos**
   ```bash
   # Copiar toda la carpeta del proyecto
   # Incluye: código, configuración, respaldos
   ```

3. **Configurar en producción**
   ```bash
   # Editar app/config/.env con datos de producción
   # O usar el instalador automático
   ```

4. **Restaurar datos**
   ```bash
   # Ir a: http://tu-servidor.com/tennisyfragancias/database/backup.php
   # Restaurar el respaldo creado en desarrollo
   ```

### Entre Diferentes Computadoras

1. **Crear paquete portable**
   ```bash
   # Crear respaldo de la base de datos
   # Comprimir toda la carpeta del proyecto
   ```

2. **En la nueva computadora**
   ```bash
   # Instalar XAMPP
   # Descomprimir el proyecto
   # Ejecutar instalar.php
   # Restaurar respaldo si es necesario
   ```

## 📁 Estructura de Archivos Importantes

```
tennisyfragancias/
├── instalar.php                 # 🚀 Instalador automático
├── app/config/
│   ├── ConfiguracionPortable.php  # 🔧 Sistema de configuración
│   ├── env.example              # 📝 Plantilla de configuración
│   └── .env                     # ⚙️ Configuración actual (se crea automáticamente)
├── database/
│   ├── tennisyfragancias_db.sql # 🗄️ Estructura de base de datos
│   ├── backup.php               # 💾 Sistema de respaldo
│   └── backups/                # 📦 Respaldos automáticos
└── ... (resto del proyecto)
```

## ⚙️ Configuración Manual (Opcional)

### Archivo de Configuración (.env)

```env
# Base de Datos
DB_HOST=localhost
DB_NOMBRE=tennisyfragancias_db
DB_USUARIO=root
DB_PASSWORD=
DB_PUERTO=3306

# Aplicación
URL_BASE=http://localhost/tennisyfragancias/
EMPRESA_NOMBRE=Tennis y Fragancias
EMPRESA_CIUDAD=Barrancabermeja
EMPRESA_DEPARTAMENTO=Santander
EMPRESA_PAIS=Colombia

# MercadoPago (opcional)
MERCADOPAGO_PUBLIC_KEY=TU_PUBLIC_KEY_AQUI
MERCADOPAGO_ACCESS_TOKEN=TU_ACCESS_TOKEN_AQUI

# Email (opcional)
EMAIL_HOST=smtp.gmail.com
EMAIL_PORT=587
EMAIL_USUARIO=tu_email@gmail.com
EMAIL_PASSWORD=tu_password
```

## 🔧 Casos de Uso Comunes

### 1. Proyecto Universitario
```bash
# Instalación inicial
1. Copiar proyecto a htdocs
2. Ejecutar instalar.php
3. ¡Listo para usar!
```

### 2. Demostración en Clase
```bash
# Crear respaldo con datos de ejemplo
1. Agregar productos de prueba
2. Crear respaldo automático
3. Comprimir proyecto completo
4. Llevar a clase y restaurar
```

### 3. Entrega de Proyecto
```bash
# Preparar entrega
1. Crear respaldo final
2. Limpiar datos de prueba (opcional)
3. Comprimir proyecto
4. Incluir instrucciones de instalación
```

### 4. Desarrollo Colaborativo
```bash
# Compartir con compañeros
1. Crear respaldo con datos de desarrollo
2. Subir a Google Drive/Dropbox
3. Compañero descarga y ejecuta instalar.php
4. Restaura respaldo si necesita datos
```

## 🛠️ Herramientas Incluidas

### Instalador Web (`instalar.php`)
- ✅ Verificación automática de requisitos
- ⚙️ Configuración guiada de base de datos
- 🗄️ Instalación automática de estructura
- 🎯 Interfaz amigable paso a paso

### Sistema de Respaldo (`database/backup.php`)
- 💾 Crear respaldos con un clic
- 📋 Lista de respaldos disponibles
- 🔄 Restaurar respaldos fácilmente
- 📊 Información de fecha y tamaño

### Configuración Portable
- 🔧 Un solo archivo de configuración
- 🌍 Funciona en cualquier entorno
- 📝 Fácil de editar y mantener
- 🔒 Valores seguros por defecto

## 🚨 Solución de Problemas

### Error: "No se puede conectar a la base de datos"
```bash
# Solución:
1. Verificar que MySQL esté ejecutándose
2. Revisar credenciales en app/config/.env
3. Usar el instalador automático
```

### Error: "Archivo .env no encontrado"
```bash
# Solución:
1. Copiar env.example a .env
2. O ejecutar el instalador automático
```

### Error: "Permisos insuficientes"
```bash
# Solución:
1. Verificar permisos de escritura en app/config/
2. Verificar permisos en public/imagenes/
```

## 📞 Soporte

### Para Estudiantes
- 📖 Revisar `INSTALACION.md` para instrucciones detalladas
- 🔧 Usar el instalador automático (`instalar.php`)
- 💾 Usar el sistema de respaldo para mover datos

### Para Profesores
- 🎯 El proyecto es completamente portable
- 📦 Se puede entregar como un solo archivo comprimido
- 🚀 Instalación en 3 pasos simples
- 🔄 Fácil de evaluar en diferentes entornos

## 🎉 Beneficios de la Portabilidad

1. **⚡ Instalación Rápida**: 3 pasos para tener el sistema funcionando
2. **🔄 Fácil Movimiento**: Entre computadoras, servidores, entornos
3. **💾 Respaldos Automáticos**: No perder datos al mover el proyecto
4. **🎯 Configuración Simple**: Un archivo para toda la configuración
5. **🛠️ Herramientas Incluidas**: Todo lo necesario está en el proyecto
6. **📚 Documentación Completa**: Guías paso a paso para cualquier situación

---

**¡El proyecto Tennis y Fragancias ahora es completamente portable y fácil de usar! 🚀**
