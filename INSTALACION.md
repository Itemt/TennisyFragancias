# 🚀 Guía de Instalación - Tennis y Fragancias

## 🎯 Instalación Automática (Recomendada)

### Método 1: Instalador Web Automático

1. **Copiar archivos del proyecto**
   - Copiar la carpeta `tennisyfragancias` a `C:\xampp\htdocs\`
   - La ruta final debe ser: `C:\xampp\htdocs\tennisyfragancias\`

2. **Iniciar XAMPP**
   - Abrir el Panel de Control de XAMPP
   - Activar los módulos **Apache** y **MySQL**

3. **Ejecutar el instalador automático**
   - Abrir el navegador e ir a: `http://localhost/tennisyfragancias/instalar.php`
   - Seguir los pasos del instalador:
     - ✅ Verificación de requisitos
     - ⚙️ Configuración de base de datos
     - 🗄️ Instalación automática de la base de datos

4. **¡Listo!** El sistema estará configurado automáticamente.

### Método 2: Instalación Manual (Avanzada)

## Paso 1: Requisitos del Sistema

### Software Necesario
- ✅ XAMPP 8.0 o superior (incluye Apache, PHP y MySQL)
  - Descargar desde: https://www.apachefriends.org/
- ✅ PHP 7.4 o superior
- ✅ MySQL 5.7 o superior
- ✅ Navegador web moderno (Chrome, Firefox, Edge)

### Extensiones PHP Requeridas
Verificar que estas extensiones estén habilitadas en `php.ini`:
- `extension=pdo_mysql`
- `extension=curl`
- `extension=mbstring`
- `extension=openssl`
- `extension=fileinfo`

## Paso 2: Instalación de XAMPP

1. Descargar XAMPP desde https://www.apachefriends.org/
2. Ejecutar el instalador y seguir las instrucciones
3. Instalar en `C:\xampp\` (ruta recomendada)
4. Iniciar el Panel de Control de XAMPP
5. Activar los módulos **Apache** y **MySQL**

## Paso 3: Configuración del Proyecto

### 3.1 Copiar Archivos
1. Copiar la carpeta `tennisyfragancias` a `C:\xampp\htdocs\`
2. La ruta final debe ser: `C:\xampp\htdocs\tennisyfragancias\`

### 3.2 Configuración Portable (Nuevo)

El proyecto ahora incluye un sistema de configuración portable que facilita la movilidad:

1. **Crear archivo de configuración**
   ```bash
   # Copiar el archivo de ejemplo
   cp app/config/env.example app/config/.env
   ```

2. **Editar configuración** (opcional)
   - Editar `app/config/.env` con tus datos específicos
   - Si no editas el archivo, se usarán valores por defecto

### 3.3 Crear Base de Datos (Manual)
1. Abrir el navegador e ir a: http://localhost/phpmyadmin
2. Hacer clic en "Nueva" para crear una base de datos
3. Nombre de la base de datos: `tennisyfragancias_db`
4. Cotejamiento: `utf8mb4_unicode_ci`
5. Hacer clic en "Crear"

### 3.4 Importar Datos (Manual)
1. En phpMyAdmin, seleccionar la base de datos `tennisyfragancias_db`
2. Ir a la pestaña "Importar"
3. Hacer clic en "Seleccionar archivo"
4. Buscar el archivo: `tennisyfragancias/database/tennisyfragancias_db.sql`
5. Hacer clic en "Continuar"
6. Esperar a que termine la importación (verás un mensaje de éxito)

### 3.6 Crear Carpetas de Imágenes

Asegúrate de que existan estas carpetas con permisos de escritura:
```
public/imagenes/productos/
public/imagenes/categorias/
```

Si no existen, créalas manualmente.

### 3.7 Habilitar mod_rewrite en Apache

1. Abrir el archivo: `C:\xampp\apache\conf\httpd.conf`
2. Buscar la línea: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Quitar el `#` al inicio para descomentar
4. Guardar el archivo
5. Reiniciar Apache desde el Panel de Control de XAMPP

## Paso 4: Acceder al Sistema

1. Abrir el navegador
2. Ir a: http://localhost/tennisyfragancias/
3. Deberías ver la página de inicio

## Paso 5: Iniciar Sesión como Administrador

**Credenciales por defecto:**
- **Email:** admin@tennisyfragancias.com
- **Contraseña:** admin123

⚠️ **IMPORTANTE:** Cambia esta contraseña inmediatamente después del primer inicio de sesión.

## Paso 6: Configuración de MercadoPago (Opcional)

Si deseas habilitar pagos en línea:

1. Crear cuenta en https://www.mercadopago.com.co/
2. Obtener tus credenciales de prueba/producción
3. Editar: `app/config/configuracion.php`

```php
define('MERCADOPAGO_PUBLIC_KEY', 'TU_PUBLIC_KEY_AQUI');
define('MERCADOPAGO_ACCESS_TOKEN', 'TU_ACCESS_TOKEN_AQUI');
```

### Credenciales de Prueba
Puedes usar estas credenciales de prueba de MercadoPago:
https://www.mercadopago.com.co/developers/es/docs/credentials

## Verificación de la Instalación

### ✅ Checklist
- [ ] XAMPP instalado y funcionando
- [ ] Apache y MySQL activos
- [ ] Base de datos creada e importada
- [ ] Puedo acceder a http://localhost/tennisyfragancias/
- [ ] Puedo iniciar sesión como administrador
- [ ] No hay errores en la pantalla

### Solución de Problemas Comunes

#### Error: "Base de datos no encontrada"
- Verifica que la base de datos se llama exactamente `tennisyfragancias_db`
- Verifica las credenciales en `app/config/base_datos.php`

#### Error 404 en todas las páginas
- Verifica que mod_rewrite esté habilitado
- Verifica que el archivo `.htaccess` exista en la raíz del proyecto

#### Error: "Cannot modify header information"
- Puede haber espacios o saltos de línea antes de `<?php`
- Verifica que no haya salida antes de los headers

#### Las imágenes no se muestran
- Verifica que las carpetas `public/imagenes/productos/` y `public/imagenes/categorias/` existan
- Verifica los permisos de escritura

#### Página en blanco / Error 500
- Activa el modo de depuración en `index.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```
- Revisa los logs de Apache: `C:\xampp\apache\logs\error.log`

## Paso 7: Primeros Pasos en el Sistema

### Como Administrador:
1. Cambiar la contraseña
2. Crear categorías de productos
3. Agregar productos al catálogo
4. Crear usuarios empleados
5. Revisar configuración general

### Crear Categorías:
1. Panel Admin → Categorías → Nueva Categoría
2. Ejemplos:
   - Tenis Deportivos
   - Tenis Casuales
   - Fragancias Hombre
   - Fragancias Mujer

### Agregar Productos:
1. Panel Admin → Productos → Nuevo Producto
2. Completar toda la información
3. Subir una imagen del producto
4. Guardar

## 🔄 Sistema de Respaldo Automático

### Crear Respaldos
El proyecto incluye un sistema automático de respaldo:

1. **Acceder al sistema de respaldo**
   - Ir a: `http://localhost/tennisyfragancias/database/backup.php`
   - Interfaz web para gestionar respaldos

2. **Crear respaldo automático**
   - Hacer clic en "Crear Respaldo Ahora"
   - El sistema creará un archivo con fecha y hora
   - Los respaldos se guardan en `database/backups/`

3. **Restaurar respaldo**
   - Seleccionar un respaldo de la lista
   - Hacer clic en "Restaurar"
   - ⚠️ **Advertencia**: Esto reemplazará todos los datos actuales

### Respaldos Manuales
1. **Backup de archivos**: Copiar carpeta `tennisyfragancias`
2. **Backup de base de datos**:
   - phpMyAdmin → tennisyfragancias_db → Exportar
   - Guardar el archivo .sql generado

## 🔒 Seguridad y Portabilidad

### Configuración Portable
El proyecto ahora es completamente portable:

1. **Archivo de configuración**: `app/config/.env`
   - Contiene toda la configuración del sistema
   - Fácil de editar para diferentes entornos
   - Se puede copiar entre servidores

2. **Instalación automática**: `instalar.php`
   - Configuración automática de base de datos
   - Verificación de requisitos
   - Instalación en un solo clic

3. **Sistema de respaldo**: `database/backup.php`
   - Respaldos automáticos con interfaz web
   - Restauración fácil entre entornos
   - Historial de respaldos

### Recomendaciones de Seguridad
- ✅ Cambiar contraseña del administrador
- ✅ Usar contraseñas seguras (mínimo 12 caracteres)
- ✅ No usar el email admin@tennisyfragancias.com en producción
- ✅ En producción, desactivar display_errors en PHP
- ✅ Usar HTTPS en producción
- ✅ Mantener backups actualizados
- ✅ Configurar archivo `.env` con datos seguros

## Soporte

Si tienes problemas durante la instalación:

1. Revisa la consola del navegador (F12) para ver errores JavaScript
2. Revisa los logs de PHP en `C:\xampp\php\logs\`
3. Revisa los logs de Apache en `C:\xampp\apache\logs\`
4. Consulta el archivo README.md para más información

## Próximos Pasos

Una vez instalado exitosamente:

1. ✅ Explorar el panel de administración
2. ✅ Agregar productos de prueba
3. ✅ Probar el flujo de compra como cliente
4. ✅ Configurar empleados y sus permisos
5. ✅ Personalizar colores y diseño si lo deseas

¡Listo! Tu e-commerce Tennis y Fragancias está funcionando. 🎉

---

**Fecha:** Octubre 2025  
**Versión:** 1.0.0

