# 🥾 Tennis y Fragancias - E-commerce

Sistema de comercio electrónico completo especializado en calzado deportivo, casual, formal y accesorios. Desarrollado como proyecto universitario en Barrancabermeja, Santander, Colombia.

> **🚀 Despliegue Automático**: Configurado para CI/CD con Coolify/GitHub Actions  
> **📦 100% Portable**: Instalación automática con un solo comando  
> **🔧 Sin configuración manual**: El instalador hace todo por ti

## 🌟 Características Principales

- ✅ **Sistema de Usuarios Multi-rol**: Administradores, empleados y clientes con permisos diferenciados
- 🛒 **Carrito de Compras**: Gestión completa con persistencia de sesión
- 💳 **Pasarela de Pagos**: Integración con MercadoPago
- 📦 **Gestión de Pedidos**: Seguimiento completo con estados
- 🗄️ **Gestión de Inventario**: Control de stock, alertas de stock mínimo
- 🏷️ **Sistema de Categorías**: Organización por tipos de productos
- 📊 **Dashboard Administrativo**: Reportes, estadísticas y gráficos
- 🔐 **Seguridad**: Encriptación de contraseñas, validación de datos, protección CSRF
- 📱 **Diseño Responsive**: Compatible con dispositivos móviles y tablets
- 🎨 **Interfaz Moderna**: Diseño atractivo con Bootstrap 5
- 🖱️ **UX Mejorada**: Las cards de productos (catálogo, categorías e inicio) son completamente clickeables
- 🖼️ **Branding**: Soporte de logo y favicon personalizados
- 🏪 **Venta Presencial**: Sistema completo de punto de venta para empleados
- 📋 **Gestión de Variantes**: Productos con múltiples tallas y colores
- 🔍 **Búsqueda Avanzada**: Filtros por categoría, marca, talla y búsqueda de texto
- 📊 **Historial de Stock**: Seguimiento completo de movimientos de inventario
- 🎯 **Vista Detallada**: Páginas especializadas para administradores y clientes

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

# 4. Abrir el navegador
# Ir a: http://localhost/tennisyfragancias/
# El sistema se configurará automáticamente
# ¡Listo! 🎉
```

### Opción B: Instalación Local (Descarga ZIP)

1. **Descargar** el proyecto desde GitHub (Code → Download ZIP)
2. **Extraer** en `C:\xampp\htdocs\tennisyfragancias\`
3. **Iniciar XAMPP** (Apache + MySQL)
4. **Abrir navegador**: `http://localhost/tennisyfragancias/`
5. **Seguir la configuración** automática

### Requisitos del Sistema
- ✅ PHP 7.4+ (incluido en XAMPP)
- ✅ MySQL 5.7+ (incluido en XAMPP)
- ✅ Apache (incluido en XAMPP)
- ✅ Extensiones PHP: PDO, MySQL, cURL, mbstring

---

## 🗄️ Estructura de Base de Datos Normalizada

El sistema crea automáticamente las siguientes tablas normalizadas:

### Tablas Principales
1. **usuarios** - Gestión de usuarios (clientes, empleados, administradores)
2. **direcciones** - Direcciones de usuarios (normalizada)
3. **categorias** - Categorías de productos
4. **productos** - Catálogo de productos con referencias normalizadas
5. **pedidos** - Órdenes de compra con referencias normalizadas
6. **detalle_pedidos** - Detalles de productos por pedido
7. **carrito** - Carrito de compras persistente
8. **facturas** - Facturación electrónica
9. **historial_stock** - Seguimiento de movimientos de inventario

### Tablas de Referencia (Normalizadas)
10. **marcas** - Marcas de productos
11. **tallas** - Tallas disponibles
12. **colores** - Colores disponibles
13. **generos** - Géneros de productos
14. **metodos_pago** - Métodos de pago disponibles
15. **estados_pedido** - Estados de pedidos
16. **estados_pago** - Estados de pagos

---

## 🎯 Funcionalidades por Rol

### 👑 Administrador

**Dashboard Completo:**
- 📊 Estadísticas de ventas, productos y usuarios
- 📈 Gráficos de productos más vendidos
- ⚠️ Alertas de stock bajo
- 📦 Pedidos recientes
- 🎨 Títulos unificados con colores oscuros

**Gestión de Productos:**
- ➕ Crear, editar y eliminar productos
- 📸 Subir imágenes de productos (JPG, PNG, GIF, WEBP)
- 🏷️ Asignar categorías, tallas, colores
- 💰 Gestionar precios y ofertas
- 📦 Control de stock y stock mínimo
- ⭐ Marcar productos destacados
- 🔢 Generación automática de SKU
- 🔄 **Gestión de Variantes**: Productos con múltiples tallas y colores
- 👁️ **Vista Completa**: Página detallada con toda la información del producto
- ➕ **Agregar Variantes**: Crear nuevas tallas para productos existentes
- 🗑️ **Eliminación Masiva**: Eliminar producto y todas sus variantes de una vez

**Gestión de Stock:**
- 📊 **Historial Detallado**: Seguimiento completo de movimientos
- 🔍 **Filtros Avanzados**: Por tipo, fecha, producto
- 📈 **Reportes**: Entradas, salidas, ajustes
- ⚠️ **Alertas**: Stock bajo y productos agotados

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

**Panel de Ventas:**
- 💼 **Venta Presencial**: Sistema completo de punto de venta
- 🔍 **Búsqueda Avanzada**: Por nombre, SKU, descripción
- 🎨 **Interfaz Mejorada**: Colores oscuros para mejor legibilidad
- 🛒 **Carrito Dinámico**: Gestión en tiempo real
- 🧾 **Generar Facturas**: Sistema completo de facturación
- 📋 **Ver Pedidos**: Gestión de órdenes
- 👥 **Atención al Cliente**: Herramientas de soporte

### 🛒 Cliente

**Experiencia de Compra:**
- 🔍 **Navegación Mejorada**: Catálogo con productos agrupados por variantes
- 🛒 **Carrito Inteligente**: Gestión de variantes por talla
- 💳 **Checkout Seguro**: Integración con MercadoPago
- 📦 **Seguimiento**: Estado de pedidos en tiempo real
- 👤 **Perfil Completo**: Gestión de datos personales
- 🔒 **Seguridad**: Cambio de contraseñas seguro

**Catálogo de Productos:**
- 🏷️ **Productos Agrupados**: Una entrada por producto, múltiples variantes
- 🎯 **Selección de Talla**: Al entrar al detalle del producto
- 📊 **Estado de Stock**: "Disponible" o "Agotado" (sin números específicos)
- 🖼️ **Imágenes Optimizadas**: Placeholders cuando no hay imagen
- 🔍 **Búsqueda Inteligente**: Filtros por categoría, marca, talla

---

## 🛠️ Nuevas Funcionalidades Implementadas

### 📦 Gestión de Variantes de Productos
- **Productos Agrupados**: Los productos con múltiples tallas aparecen una sola vez en el catálogo
- **Selección de Talla**: Al entrar al detalle, se puede elegir la talla específica
- **Stock por Variante**: Control individual de stock por cada talla/color
- **Eliminación Masiva**: Al eliminar un producto, se eliminan todas sus variantes

### 🔍 Sistema de Búsqueda Mejorado
- **Búsqueda Multi-campo**: Busca en nombre, SKU y descripción
- **Filtros Avanzados**: Por categoría, marca, talla
- **Búsqueda en Tiempo Real**: Filtra productos mientras escribes
- **Indicadores Visuales**: Mensajes cuando no hay resultados

### 📊 Gestión de Stock Avanzada
- **Historial Completo**: Seguimiento de todos los movimientos
- **Filtros por Fecha**: Rango de fechas personalizable
- **Filtros por Tipo**: Entradas, salidas, ajustes
- **Búsqueda de Productos**: Por nombre o SKU
- **Reportes Detallados**: Estadísticas de movimientos

### 🎨 Mejoras de Interfaz
- **Colores Unificados**: Títulos con colores oscuros para mejor legibilidad
- **Placeholders Inteligentes**: Imágenes de respaldo cuando no hay foto
- **Botones Contextuales**: Acciones específicas según la vista
- **Responsive Mejorado**: Mejor experiencia en móviles

### 🏪 Sistema de Venta Presencial
- **Punto de Venta Completo**: Interfaz dedicada para empleados
- **Búsqueda de Productos**: Sistema robusto de búsqueda
- **Carrito Dinámico**: Gestión en tiempo real
- **Cálculo Automático**: Subtotal, descuentos, total
- **Facturación**: Generación automática de facturas

---

## 🔧 Configuración

### Archivo de Configuración (.env)

El sistema genera automáticamente este archivo:

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

---

## 👥 Usuarios Predefinidos

El sistema crea automáticamente 3 usuarios de prueba:

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
  - ✅ Sistema de venta presencial
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

---

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Pagos**: MercadoPago API
- **Servidor**: Apache (XAMPP)
- **Framework**: MVC personalizado
- **UI**: Bootstrap 5 + Bootstrap Icons

---

## 📁 Estructura del Proyecto

```
tennisyfragancias/
├── app/
│   ├── config/          # Configuración
│   ├── controladores/  # Lógica de negocio
│   ├── modelos/        # Modelos de datos
│   ├── vistas/         # Plantillas HTML
│   │   ├── admin/      # Vistas administrativas
│   │   ├── empleado/  # Vistas de empleados
│   │   ├── productos/ # Vistas de productos
│   │   └── layout/    # Layouts comunes
│   └── helpers/        # Funciones auxiliares
├── database/           # Scripts de base de datos
├── public/            # Archivos públicos
│   ├── css/           # Estilos
│   ├── js/            # JavaScript
│   └── imagenes/      # Imágenes
├── index.php          # Punto de entrada
└── README.md          # Documentación
```

---

## 🔒 Seguridad

- ✅ Contraseñas encriptadas
- ✅ Validación de datos
- ✅ Protección CSRF
- ✅ Sanitización de inputs
- ✅ Headers de seguridad
- ✅ Validación de archivos
- ✅ Control de acceso por roles

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

## 🧰 Solución de Problemas Comunes

### ❌ Error: "Access denied for user 'root'@'localhost'"
**Solución:**
- En XAMPP, el usuario `root` tiene contraseña vacía por defecto
- Si cambiaste la contraseña de MySQL, úsala en la configuración

### ❌ Error: "Table already exists"
**Solución:**
- El sistema usa `CREATE TABLE IF NOT EXISTS`
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

### ❌ Error: "URL redirection issues"
**Solución:**
- Verifica que `.htaccess` tenga: `RewriteBase /tennisyfragancias/`
- Asegúrate que `mod_rewrite` esté habilitado en Apache
- Reinicia Apache después de cambios

### ❌ No se muestran productos
**Solución:**
- Si instalaste con "Base limpia", debes crear productos manualmente
- Como administrador: Dashboard → Productos → Nuevo Producto

### ❌ Error en subida de imágenes: "Unsupported image type"
**Solución:**
- Solo se permiten: JPG, JPEG, PNG, GIF, WEBP
- Máximo 5MB por imagen
- El sistema valida tipo MIME real del archivo
- Evita archivos corruptos o con extensión incorrecta

### ❌ Error: "Column not found" en base de datos
**Solución:**
- Ejecuta el instalador nuevamente
- El sistema actualizará la estructura de la base de datos
- No se perderán los datos existentes

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
- ✅ Sistema de variantes de productos
- ✅ Gestión avanzada de stock
- ✅ Sistema de venta presencial
- ✅ Búsqueda y filtros inteligentes

---

## 📄 Licencia

Proyecto académico - Uso libre con fines educativos

---

**Desarrollado con ❤️ en Barrancabermeja, Santander, Colombia**  
**Tennis y Fragancias © 2025**