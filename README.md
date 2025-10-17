# 🥾 Tennis y Fragancias - E-commerce

Sistema de comercio electrónico completo especializado en calzado deportivo, casual, formal y accesorios. Desarrollado como proyecto universitario en Barrancabermeja, Santander, Colombia.

> **🚀 Despliegue Automático**: Configurado para CI/CD con Coolify/GitHub Actions  
> **📦 100% Portable**: Instalación automática con un solo comando  
> **🔧 Sin configuración manual**: El instalador hace todo por ti

## 🌟 Características Principales

- ✅ **Sistema de Usuarios Multi-rol**: Administradores, empleados y clientes con permisos diferenciados
- 🛒 **Carrito de Compras**: Gestión completa con persistencia de sesión
- 💳 **Pasarela de Pagos**: Integración con MercadoPago
- 📦 **Gestión de Pedidos**: Seguimiento completo con estados y notificaciones
- 🗄️ **Gestión de Inventario**: Control de stock, alertas de stock mínimo
- 🏷️ **Sistema de Categorías**: Organización por tipos de productos
- 📧 **Notificaciones**: Sistema de alertas en tiempo real
- 📊 **Dashboard Administrativo**: Reportes, estadísticas y gráficos
- 🔐 **Seguridad**: Encriptación de contraseñas, validación de datos, protección CSRF
- 📱 **Diseño Responsive**: Compatible con dispositivos móviles y tablets
- 🎨 **Interfaz Moderna**: Diseño atractivo con Bootstrap 5
 - 🖱️ **UX Mejorada**: Las cards de productos (catálogo, categorías e inicio) son completamente clickeables
 - 🖼️ **Branding**: Soporte de logo y favicon personalizados (ej. `public/imagenes/tacones-altos.png`)

---

## 🚀 Instalación Rápida

### Opción A: Clonar desde GitHub (Recomendado)

```bash
# 1. Clonar el repositorio
git clone https://github.com/Itemt/TennisyFragancias.git
cd TennisyFragancias

# 2. Mover a la carpeta de XAMPP
# Windows: Mover a C:\xampp\htdocs\tennisyfragancias
# Linux/Mac: Mover a /opt/lampp/htdocs/tennisyfragancias

# 3. Iniciar XAMPP
# - Activar Apache y MySQL

# 4. Abrir el instalador web
# Ir a: http://localhost/tennisyfragancias/instalar.php
# Seguir los 3 pasos del asistente
# ¡Listo! 🎉
```

### Opción B: Instalación Local (Descarga ZIP)

1. **Descargar** el proyecto desde GitHub (Code → Download ZIP)
2. **Extraer** en `C:\xampp\htdocs\tennisyfragancias\`
3. **Iniciar XAMPP** (Apache + MySQL)
4. **Abrir navegador**: `http://localhost/tennisyfragancias/instalar.php`
5. **Seguir el asistente** de instalación

### Requisitos del Sistema
- ✅ PHP 7.4+ (incluido en XAMPP)
- ✅ MySQL 5.7+ (incluido en XAMPP)
- ✅ Apache (incluido en XAMPP)
- ✅ Extensiones PHP: PDO, MySQL, cURL, mbstring

---

## 📋 Pasos del Instalador Automático

#### 📋 Paso 1: Verificación de Requisitos
El instalador verificará automáticamente:
- ✅ Versión de PHP (7.4+)
- ✅ Extensiones PHP necesarias (PDO, MySQL, cURL, mbstring, etc.)
- ✅ Permisos de escritura en directorios
- ✅ Archivos de configuración

#### ⚙️ Paso 2: Configuración de Base de Datos
Configurar los parámetros de conexión:
- **Host**: `localhost` (predeterminado)
- **Nombre de BD**: `tennisyzapatos_db` (o personalizado)
- **Usuario**: `root` (XAMPP por defecto)
- **Contraseña**: *(vacío en XAMPP por defecto)*
- **Puerto**: `3306`

**IMPORTANTE:** Elegir tipo de instalación:

🎯 **Opción 1: Con datos de prueba (Recomendado para desarrollo)**
- Incluye 20 productos de ejemplo variados
- 5 categorías predefinidas
- 3 usuarios de prueba (admin, empleado, cliente)
- Perfecto para explorar todas las funcionalidades

🔲 **Opción 2: Base de datos limpia (Para producción)**
- Solo estructura de tablas
- 3 usuarios básicos (admin, empleado, cliente)
- Sin productos ni categorías
- Ideal para empezar con datos reales

#### 🔌 Paso 3: Prueba de Conexión
El instalador:
- Probará la conexión a MySQL
- Creará la base de datos si no existe
- Generará el archivo de configuración `.env`

#### 🗄️ Paso 4: Instalación de Base de Datos
El instalador creará automáticamente:
- 8 tablas principales
- Índices y relaciones
- Usuarios predefinidos
- Datos de prueba (si se seleccionó)

## 🗄️ Estructura de Base de Datos

El instalador crea automáticamente las siguientes tablas:

### Tablas Principales
1. **usuarios** - Gestión de usuarios (clientes, empleados, administradores)
2. **categorias** - Categorías de productos
3. **productos** - Catálogo de productos con stock y precios
4. **pedidos** - Órdenes de compra de clientes
5. **detalle_pedidos** - Detalles de productos por pedido
6. **carrito** - Carrito de compras persistente
7. **notificaciones** - Sistema de notificaciones en tiempo real
8. **facturas** - Facturación electrónica

### Datos de Prueba (Opción "Con datos de prueba")

Si eliges instalar con datos de prueba, obtendrás:

**5 Categorías:**
- 🏃 Tenis Deportivos
- 👟 Tenis Casuales  
- 👔 Zapatos Formales
- 🏃‍♂️ Zapatos Deportivos
- 🧦 Accesorios

**20 Productos de Ejemplo:**
- Variedad de marcas (Nike, Adidas, Puma, Reebok, Converse, etc.)
- Diferentes tallas y colores
- Rangos de precio desde $19,000 hasta $329,000 COP
- Stock variado para probar alertas
- Productos destacados para la página principal

## 🔧 Configuración

### Archivo de Configuración (.env)

El instalador genera automáticamente este archivo, pero puedes editarlo manualmente:

```env
# Base de Datos
DB_HOST=localhost
DB_NOMBRE=tennisyzapatos_db
DB_USUARIO=root
DB_PASSWORD=
DB_CHARSET=utf8mb4
DB_PUERTO=3306

# Aplicación
URL_BASE=http://localhost/tennisyfragancias/
APP_ENV=development
DEBUG_MODE=true
APP_SECRET_KEY=tu_clave_secreta_generada_automaticamente

# Empresa
EMPRESA_NOMBRE=Tennis y Fragancias
EMPRESA_CIUDAD=Barrancabermeja
EMPRESA_DEPARTAMENTO=Santander
EMPRESA_PAIS=Colombia
EMPRESA_EMAIL=info@tennisyfragancias.com
EMPRESA_TELEFONO=+57 300 123 4567

# MercadoPago (Configurar después)
MERCADOPAGO_PUBLIC_KEY=TU_PUBLIC_KEY_AQUI
MERCADOPAGO_ACCESS_TOKEN=TU_ACCESS_TOKEN_AQUI

# Email (Configurar para notificaciones)
EMAIL_HOST=smtp.gmail.com
EMAIL_PORT=587
EMAIL_USUARIO=tu_email@gmail.com
EMAIL_PASSWORD=tu_password
EMAIL_REMITENTE=info@tennisyfragancias.com
EMAIL_REMITENTE_NOMBRE=Tennis y Fragancias
```

### ⚡ Sin Archivos SQL Necesarios

El instalador **NO requiere archivos SQL**. Todo se genera mediante código PHP:
- ✅ Crea la base de datos si no existe
- ✅ Crea todas las tablas con estructura completa
- ✅ Añade índices y relaciones (Foreign Keys)
- ✅ Inserta usuarios predefinidos
- ✅ Carga datos de prueba (opcional)
- ✅ Soporta reinstalación sin errores

## 🎯 Funcionalidades por Rol

### 👑 Administrador
**Dashboard Completo:**
- 📊 Estadísticas de ventas, productos y usuarios
- 📈 Gráficos de productos más vendidos
- ⚠️ Alertas de stock bajo
- 📦 Pedidos recientes

**Gestión de Productos:**
- ➕ Crear, editar y eliminar productos
- 📸 Subir imágenes de productos (JPG, PNG, GIF, WEBP)
- 🏷️ Asignar categorías, tallas, colores
- 💰 Gestionar precios y ofertas
- 📦 Control de stock y stock mínimo
- ⭐ Marcar productos destacados
- 🔢 Generación automática de SKU

**Gestión de Categorías:**
- Crear y administrar categorías
- Activar/desactivar categorías

**Gestión de Usuarios:**
- Ver todos los usuarios
- Cambiar roles (cliente, empleado, administrador)
- Gestionar permisos

**Reportes:**
- Ventas por período
- Productos más vendidos
- Estadísticas de clientes

### 👔 Empleado
- 💼 Panel de ventas
- 🧾 Generar facturas
- 📋 Ver pedidos
- 👥 Atención al cliente

### 🛒 Cliente
- 🔍 Navegar catálogo de productos
- 🛒 Agregar productos al carrito
- 💳 Realizar compras con MercadoPago
- 📦 Seguimiento de pedidos
- 👤 Gestionar perfil y direcciones
- 🔔 Ver notificaciones
- 🔒 Cambiar contraseña

## 🔄 Sistema de Respaldo

- **Crear respaldo**: `http://localhost/tennisyfragancias/database/backup.php`
- **Respaldos automáticos** con fecha y hora
- **Restauración fácil** entre entornos
- **Historial completo** de respaldos

## 👥 Usuarios Predefinidos

El instalador crea automáticamente 3 usuarios de prueba:

### 👑 Administrador (Control Total)
- **Email**: `admin@tennisyfragancias.com`
- **Contraseña**: `admin123`
- **Permisos**: 
  - ✅ Gestionar productos, categorías, stock
  - ✅ Administrar usuarios y roles
  - ✅ Ver reportes y estadísticas completas
  - ✅ Gestionar pedidos y facturas
  - ✅ Configurar sistema
- **Datos**: 
  - Nombre: Administrador Sistema
  - Teléfono: +57 300 123 4567
  - Ubicación: Barrancabermeja, Santander

### 👔 Empleado (Ventas y Facturación)
- **Email**: `empleado@tennisyfragancias.com`
- **Contraseña**: `empleado123`
- **Permisos**:
  - ✅ Gestionar ventas y facturación
  - ✅ Ver pedidos y clientes
  - ✅ Atención al cliente
  - ❌ No puede modificar productos ni usuarios
- **Datos**:
  - Nombre: Empleado Ventas
  - Teléfono: +57 300 234 5678
  - Ubicación: Barrancabermeja, Santander

### 🛒 Cliente de Ejemplo
- **Email**: `cliente@example.com`
- **Contraseña**: `cliente123`
- **Permisos**:
  - ✅ Navegar catálogo
  - ✅ Agregar productos al carrito
  - ✅ Realizar compras
  - ✅ Ver historial de pedidos
  - ✅ Gestionar perfil personal
- **Datos**:
  - Nombre: Juan Carlos Pérez López
  - Teléfono: +57 311 456 7890
  - Dirección: Carrera 15 #28-45 Apto 301
  - Ubicación: Barrancabermeja, Santander
  - Código Postal: 687031

### ⚠️ Seguridad Importante
- **Producción**: Cambiar TODAS las contraseñas inmediatamente
- **Eliminar** el usuario cliente de ejemplo en producción
- **Actualizar** datos de contacto del admin y empleado
- Las contraseñas están encriptadas con `password_hash()` de PHP

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Pagos**: MercadoPago API
- **Servidor**: Apache (XAMPP)

## 📁 Estructura del Proyecto

```
tennisyfragancias/
├── app/
│   ├── config/          # Configuración
│   ├── controladores/  # Lógica de negocio
│   ├── modelos/        # Modelos de datos
│   └── vistas/         # Plantillas HTML
├── database/           # Scripts de base de datos
├── public/            # Archivos públicos
│   ├── css/           # Estilos
│   ├── js/            # JavaScript
│   └── imagenes/      # Imágenes
├── instalar.php       # Instalador automático
└── index.php         # Punto de entrada
```

## 🔒 Seguridad

- ✅ Contraseñas encriptadas
- ✅ Validación de datos
- ✅ Protección CSRF
- ✅ Sanitización de inputs
- ✅ Headers de seguridad

## 🔄 Reinstalación

Si necesitas reinstalar el sistema:

1. **Opción A - Mantener datos:**
   - Simplemente ejecuta `instalar.php` nuevamente
   - El instalador detectará tablas existentes
   - Elige "Base limpia" para no duplicar datos

2. **Opción B - Instalación limpia:**
   - Elimina la base de datos en phpMyAdmin
   - Ejecuta `instalar.php`
   - Elige tu opción preferida

---

## 🔒 Configuración de Seguridad para GitHub

### Archivos que NO se suben a GitHub (.gitignore)

El proyecto está configurado para **NO subir** archivos sensibles:

✅ **Archivos excluidos automáticamente:**
- `app/config/.env` (credenciales de base de datos)
- `public/imagenes/productos/*` (imágenes subidas por usuarios)
- `public/imagenes/categorias/*` (imágenes de categorías)
- `database/backups/*` (respaldos de base de datos)
- Archivos temporales, logs y cache

✅ **Archivos incluidos en el repositorio:**
- `env.example` (plantilla de configuración)
- `.gitkeep` (mantiene carpetas vacías)
- Todo el código fuente
- Documentación

### Para Desarrolladores

Si clonas el repositorio:
1. El archivo `.env` **NO estará presente** (es correcto)
2. El instalador lo creará automáticamente
3. Nunca hagas `git add app/config/.env`
4. Usa `env.example` como referencia

---

## 🚀 Despliegue en Producción (Coolify/Docker)

### Configuración de Webhook para Auto-Deploy

1. **En GitHub:**
   - Ve a Settings → Webhooks → Add webhook
   - Payload URL: `https://tu-coolify.com/api/v1/webhooks/github`
   - Content type: `application/json`
   - Events: "Just the push event"

2. **En Coolify:**
   - Activa "Auto Deploy on Push"
   - Configura la rama: `main`

3. **Resultado:**
   - Cada `git push` desplegará automáticamente
   - Sin intervención manual necesaria 🎉

### Variables de Entorno en Producción

En Coolify/Docker, configura estas variables:
```env
DB_HOST=tu_host_mysql
DB_NOMBRE=tu_base_datos
DB_USUARIO=tu_usuario
DB_PASSWORD=tu_password_segura
URL_BASE=https://tudominio.com/
APP_ENV=production
DEBUG_MODE=false
APP_SECRET_KEY=genera_clave_unica_aqui
```

---

## 📚 Guía de Uso Rápida

### 🔑 Credenciales Predefinidas

El instalador crea 3 usuarios automáticamente:

| Rol | Email | Contraseña | Permisos |
|-----|-------|------------|----------|
| 👑 **Admin** | `admin@tennisyfragancias.com` | `admin123` | Control total del sistema |
| 👔 **Empleado** | `empleado@tennisyfragancias.com` | `empleado123` | Ventas y facturación |
| 🛒 **Cliente** | `cliente@example.com` | `cliente123` | Compras online |

⚠️ **IMPORTANTE**: Cambiar estas contraseñas en producción

### 🎯 Funcionalidades por Rol

**👑 Administrador:**
- Dashboard con estadísticas
- Gestión completa de productos y categorías
- Control de usuarios y roles
- Reportes y análisis
- Configuración del sistema

**👔 Empleado:**
- Panel de ventas
- Generación de facturas
- Gestión de pedidos
- Atención al cliente

**🛒 Cliente:**
- Navegación del catálogo
- Carrito de compras
- Proceso de checkout
- Seguimiento de pedidos
- Gestión de perfil

---

## 🔗 Recursos Útiles

- **MercadoPago Developers**: https://www.mercadopago.com.co/developers
- **Bootstrap 5**: https://getbootstrap.com/docs/5.3/
- **PHP 7.4 Docs**: https://www.php.net/manual/es/
- **MySQL Docs**: https://dev.mysql.com/doc/

## 🧰 Solución de Problemas Comunes

### ❌ Error: "Access denied for user 'root'@'localhost'"
**Solución:**
- En XAMPP, el usuario `root` tiene contraseña vacía por defecto
- En el instalador, deja el campo contraseña en blanco
- Si cambiaste la contraseña de MySQL, úsala en el instalador

### ❌ Error: "Table already exists"
**Solución:**
- El instalador usa `CREATE TABLE IF NOT EXISTS`
- Puedes reinstalar sin problemas
- Para instalación limpia, elimina la base de datos primero en phpMyAdmin

### ❌ Error: "Extension not loaded"
**Solución:**
- Abre `php.ini` en XAMPP
- Descomenta (quita `;`) las líneas:
  ```ini
  extension=pdo_mysql
  extension=mbstring
  extension=curl
  extension=fileinfo
  ```
- Reinicia Apache

### ❌ Error: "Permission denied" al subir imágenes
**Solución:**
- Asegúrate que `public/imagenes/productos/` tenga permisos de escritura
- En Windows, propiedades → Seguridad → Permitir escritura
- El instalador verifica estos permisos automáticamente

### ❌ Error: "URL redirection issues"
**Solución:**
- Verifica que `.htaccess` tenga: `RewriteBase /tennisyfragancias/`
- Asegúrate que `mod_rewrite` esté habilitado en Apache
- Reinicia Apache después de cambios

### ❌ No se muestran productos
**Solución:**
- Si instalaste con "Base limpia", debes crear productos manualmente
- Como administrador: Dashboard → Productos → Nuevo Producto
- O reinstala con "Datos de prueba"

### ❌ Error en subida de imágenes: "Unsupported image type"
**Solución:**
- Solo se permiten: JPG, JPEG, PNG, GIF, WEBP
- Máximo 5MB por imagen
- El sistema valida tipo MIME real del archivo
- Evita archivos corruptos o con extensión incorrecta

---

## 🎓 Proyecto Universitario

Desarrollado como proyecto académico en Barrancabermeja, Santander, Colombia.

**Características destacadas:**
- ✅ Arquitectura MVC completa
- ✅ Sistema CRUD con múltiples tablas relacionadas
- ✅ Integración con pasarela de pagos (MercadoPago)
- ✅ Autenticación y autorización por roles
- ✅ 100% portable y fácil de instalar
- ✅ Código limpio y bien documentado

---

## 📄 Licencia

Proyecto académico - Uso libre con fines educativos

---

**Desarrollado con ❤️ en Barrancabermeja, Santander, Colombia**  
**Tennis y Fragancias © 2025**
