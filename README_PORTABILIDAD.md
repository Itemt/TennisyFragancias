# 🚀 Guía de Portabilidad - Tennis y Fragancias

## 📋 Instalación desde Clone

### Requisitos Previos
- XAMPP 8.0+ (Apache + MySQL + PHP)
- Git

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone [URL_DEL_REPO]
   cd tennisyfragancias
   ```

2. **Configurar XAMPP**
   - Iniciar Apache y MySQL desde el Panel de Control de XAMPP
   - Verificar que esté funcionando en `http://localhost`

3. **Instalación automática**
   - Abrir navegador: `http://localhost/tennisyfragancias/instalar.php`
   - Seguir los pasos del instalador
   - **¡Listo!** El sistema estará funcionando

### Configuración Opcional

Si necesitas personalizar la configuración:

1. **Copiar archivo de configuración**
   ```bash
   cp app/config/env.example app/config/.env
   ```

2. **Editar configuración** (opcional)
   - Editar `app/config/.env` con tus datos específicos
   - Si no editas nada, funcionará con valores por defecto

## 🗄️ Base de Datos

### Instalación Automática (Recomendada)
El instalador crea automáticamente:
- ✅ Estructura de base de datos
- ✅ Tablas necesarias
- ✅ Usuarios por defecto
- ✅ Datos de prueba (opcional)

### Usuarios por Defecto
- **Admin**: `admin@tennisyfragancias.com` / `admin123`
- **Empleado**: `empleado@tennisyfragancias.com` / `empleado123`
- **Cliente**: `cliente@example.com` / `cliente123`

## 📁 Estructura del Proyecto

```
tennisyfragancias/
├── app/                    # Código de la aplicación
│   ├── config/            # Configuración
│   ├── controladores/     # Lógica de negocio
│   ├── modelos/           # Acceso a datos
│   └── vistas/           # Interfaz de usuario
├── public/               # Archivos públicos
│   ├── css/             # Estilos
│   ├── js/              # JavaScript
│   └── imagenes/        # Imágenes del sitio
├── database/            # Scripts de base de datos
├── instalar.php         # Instalador automático
└── index.php           # Punto de entrada
```

## 🔧 Configuración Avanzada

### Variables de Entorno
El sistema usa configuración portable que se adapta automáticamente:

- **URL_BASE**: Se detecta automáticamente
- **DB_HOST**: localhost por defecto
- **DB_NOMBRE**: tennisyfragancias_db por defecto
- **DB_USUARIO**: root por defecto
- **DB_PASSWORD**: vacío por defecto

### Personalización
Para cambiar la configuración:

1. Crear `app/config/.env`
2. Definir solo las variables que quieres cambiar
3. El resto usará valores por defecto

Ejemplo de `.env`:
```env
DB_NOMBRE=mi_base_datos
EMPRESA_NOMBRE=Mi Empresa
URL_BASE=http://mi-dominio.com/
```

## 🚀 Despliegue en Producción

### Preparación
1. **Configurar servidor web** (Apache/Nginx)
2. **Configurar base de datos** (MySQL/MariaDB)
3. **Configurar PHP** (7.4+)

### Pasos
1. **Subir archivos** al servidor
2. **Configurar base de datos**:
   - Crear base de datos
   - Ejecutar `instalar.php`
3. **Configurar variables**:
   - Crear `app/config/.env` con datos de producción
4. **Configurar permisos**:
   ```bash
   chmod 755 public/imagenes/
   chmod 755 database/backups/
   ```

### Variables de Producción
```env
DB_HOST=tu-servidor-db
DB_NOMBRE=tu_base_datos
DB_USUARIO=tu_usuario
DB_PASSWORD=tu_password_seguro
URL_BASE=https://tu-dominio.com/
APP_ENV=production
DEBUG_MODE=false
```

## 🔒 Seguridad

### Cambios Obligatorios en Producción
1. **Cambiar contraseñas** de usuarios por defecto
2. **Configurar APP_SECRET_KEY** única
3. **Configurar DB_PASSWORD** seguro
4. **Desactivar DEBUG_MODE**

### Recomendaciones
- Usar HTTPS en producción
- Configurar respaldos automáticos
- Mantener actualizado el sistema
- Revisar logs regularmente

## 📞 Soporte

### Problemas Comunes

**Error 404 en todas las páginas**
- Verificar que mod_rewrite esté habilitado
- Verificar archivo `.htaccess`

**Error de base de datos**
- Verificar que MySQL esté ejecutándose
- Verificar credenciales en `.env`

**Imágenes no se cargan**
- Verificar permisos de carpeta `public/imagenes/`
- Verificar configuración de URL_PUBLICA

**Estilos no se aplican**
- Verificar que Apache esté sirviendo archivos estáticos
- Verificar configuración de URL_PUBLICA

### Logs y Debug
- Logs de Apache: `C:\xampp\apache\logs\error.log`
- Logs de PHP: `C:\xampp\php\logs\`
- Activar debug: `DEBUG_MODE=true` en `.env`

---

**Versión**: 1.0.0  
**Última actualización**: Octubre 2024