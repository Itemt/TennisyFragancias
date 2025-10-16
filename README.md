# 🥾 Tennis y Zapatos - E-commerce

Sistema de comercio electrónico especializado en zapatos deportivos, casuales y accesorios.

## 🚀 Características

- ✅ **Sistema de Usuarios**: Administradores, empleados y clientes
- 🛒 **Carrito de Compras**: Gestión completa de productos
- 💳 **Pagos**: Integración con MercadoPago
- 📦 **Gestión de Pedidos**: Seguimiento completo del estado
- 🗄️ **Inventario**: Control de stock y movimientos
- 📧 **Notificaciones**: Sistema de alertas por email
- 📊 **Reportes**: Dashboard administrativo completo

## 🎯 Instalación Rápida

### Método 1: Instalador Automático (Recomendado)

1. **Copiar archivos** a `C:\xampp\htdocs\tennisyfragancias\`
2. **Iniciar XAMPP** (Apache + MySQL)
3. **Ejecutar instalador**: `http://localhost/tennisyfragancias/instalar.php`
4. **¡Listo!** El sistema se configura automáticamente

### Método 2: Instalación Manual

1. Crear base de datos: `tennisyzapatos_db`
2. Importar: `database/tennisyzapatos_db.sql`
3. Configurar: `app/config/.env`
4. Acceder: `http://localhost/tennisyfragancias/`

## 🔧 Configuración

### Archivo de Configuración (.env)

```env
# Base de Datos
DB_HOST=localhost
DB_NOMBRE=tennisyzapatos_db
DB_USUARIO=root
DB_PASSWORD=

# Aplicación
URL_BASE=http://localhost/tennisyfragancias/
EMPRESA_NOMBRE=Tennis y Zapatos
EMPRESA_EMAIL=info@tennisyzapatos.com
```

## 📦 Categorías de Productos

- 🏃 **Tenis Deportivos**: Calzado deportivo para todas las edades
- 👟 **Tenis Casuales**: Calzado casual para el día a día
- 👔 **Zapatos Formales**: Calzado formal para hombre y mujer
- 🏃‍♂️ **Zapatos Deportivos**: Calzado deportivo especializado
- 🧦 **Accesorios**: Medias, cordones y accesorios

## 🔄 Sistema de Respaldo

- **Crear respaldo**: `http://localhost/tennisyfragancias/database/backup.php`
- **Respaldos automáticos** con fecha y hora
- **Restauración fácil** entre entornos
- **Historial completo** de respaldos

## 👥 Usuarios por Defecto

### Administrador
- **Email**: admin@tennisyzapatos.com
- **Contraseña**: admin123
- **⚠️ Cambiar inmediatamente después del primer acceso**

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

## 📞 Soporte

Para problemas o dudas:

1. Revisar `INSTALACION.md` para instrucciones detalladas
2. Usar el instalador automático (`instalar.php`)
3. Verificar logs de Apache y PHP
4. Consultar `README_PORTABILIDAD.md` para portabilidad

## 🎓 Proyecto Universitario

Este proyecto fue desarrollado como parte de un proyecto universitario en Barrancabermeja, Santander, Colombia.

### Características Académicas

- 📚 **Documentación completa** para evaluación
- 🔄 **Sistema portable** para fácil entrega
- 🛠️ **Herramientas incluidas** para instalación
- 📖 **Guías paso a paso** para profesores

---

**Desarrollado con ❤️ para la educación universitaria**