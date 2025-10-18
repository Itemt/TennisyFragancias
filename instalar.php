<?php
/**
 * Script de Instalación Automática - Tennis y Fragancias
 * 
 * Este script facilita la instalación y configuración del proyecto
 * en diferentes entornos de manera automática.
 */

// Configuración de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Usar sesión para pasar opciones entre pasos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que estamos en un entorno web
if (php_sapi_name() === 'cli') {
    die("Este script debe ejecutarse desde un navegador web.\n");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador - Tennis y Fragancias</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: #DC3545;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .content {
            padding: 40px;
        }
        .step {
            margin-bottom: 30px;
            padding: 20px;
            border-left: 4px solid #DC3545;
            background: #f8f9fa;
        }
        .step h3 {
            margin-top: 0;
            color: #DC3545;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            background: #DC3545;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn:hover {
            background: #c82333;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .progress {
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar {
            background: #DC3545;
            height: 20px;
            transition: width 0.3s ease;
        }
        .checklist {
            list-style: none;
            padding: 0;
        }
        .checklist li {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .checklist li:before {
            content: "✓ ";
            color: #28a745;
            font-weight: bold;
        }
        .checklist li.error:before {
            content: "✗ ";
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Instalador Tennis y Fragancias</h1>
            <p>Configuración automática del sistema</p>
        </div>
        
        <div class="content">
            <?php
            $paso = isset($_GET['paso']) ? (int)$_GET['paso'] : 1;
            
            switch($paso) {
                case 1:
                    mostrarPaso1();
                    break;
                case 2:
                    mostrarPaso2();
                    break;
                case 3:
                    mostrarPaso3();
                    break;
                case 4:
                    mostrarPaso4();
                    break;
                default:
                    mostrarPaso1();
            }
            
            function mostrarPaso1() {
                ?>
                <div class="step">
                    <h3>📋 Paso 1: Verificación de Requisitos</h3>
                    
                    <?php if (!file_exists('app/config/.env')): ?>
                        <div class="alert alert-info">
                            <strong>🚀 Instalación desde GitHub</strong><br>
                            Parece que acabas de clonar el repositorio. Este instalador te ayudará a configurar todo automáticamente.<br><br>
                            <strong>Lo que hará este instalador:</strong><br>
                            ✅ Verificará los requisitos del sistema<br>
                            ✅ Creará el archivo de configuración .env<br>
                            ✅ Creará la base de datos automáticamente<br>
                            ✅ Instalará todas las tablas necesarias<br>
                            ✅ Creará los usuarios de prueba (admin, empleado, cliente)
                        </div>
                    <?php endif; ?>
                    
                    <p>Verificando que el sistema cumple con los requisitos mínimos...</p>
                    
                    <div class="progress">
                        <div class="progress-bar" style="width: 25%"></div>
                    </div>
                    
                    <ul class="checklist">
                        <?php
                        $requisitos = verificarRequisitos();
                        foreach($requisitos as $requisito => $cumple) {
                            echo '<li class="' . ($cumple ? '' : 'error') . '">' . $requisito . '</li>';
                        }
                        ?>
                    </ul>
                    
                    <?php if(array_search(false, $requisitos) === false): ?>
                        <div class="alert alert-success">
                            ✅ Todos los requisitos se cumplen. Puedes continuar con la instalación.
                        </div>
                        <a href="?paso=2" class="btn">Continuar</a>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            ❌ Algunos requisitos no se cumplen. Por favor, instala los componentes faltantes antes de continuar.
                        </div>
                        <a href="?paso=1" class="btn">Verificar Nuevamente</a>
                    <?php endif; ?>
                </div>
                <?php
            }
            
            function mostrarPaso2() {
                // Detectar si hay un archivo .env existente
                $envExiste = file_exists('app/config/.env');
                $configExistente = [];
                
                if ($envExiste) {
                    $lines = file('app/config/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    foreach ($lines as $line) {
                        if (strpos($line, '=') !== false && strpos(trim($line), '#') !== 0) {
                            list($key, $value) = explode('=', $line, 2);
                            $configExistente[trim($key)] = trim($value);
                        }
                    }
                }
                ?>
                <div class="step">
                    <h3>⚙️ Paso 2: Configuración de Base de Datos</h3>
                    
                    <?php if ($envExiste): ?>
                        <div class="alert alert-info">
                            ℹ️ Se detectó una configuración existente. Puedes mantenerla o modificarla.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            ℹ️ Primera instalación. Configura la conexión a tu base de datos.
                        </div>
                    <?php endif; ?>
                    
                    <p>Configura los parámetros de conexión a la base de datos:</p>
                    
                    <form method="POST" action="?paso=3">
                        <div class="form-group">
                            <label for="db_host">Host de Base de Datos:</label>
                            <input type="text" id="db_host" name="db_host" value="<?php echo isset($configExistente['DB_HOST']) ? htmlspecialchars($configExistente['DB_HOST']) : 'localhost'; ?>" required>
                            <small style="color: #6c757d;">Local: localhost | Docker: nombre_contenedor_mysql</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="db_nombre">Nombre de la Base de Datos:</label>
                            <input type="text" id="db_nombre" name="db_nombre" value="<?php echo isset($configExistente['DB_NOMBRE']) ? htmlspecialchars($configExistente['DB_NOMBRE']) : 'tennisyzapatos_db'; ?>" required>
                            <small style="color: #6c757d;">Se creará automáticamente si no existe</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="db_usuario">Usuario:</label>
                            <input type="text" id="db_usuario" name="db_usuario" value="<?php echo isset($configExistente['DB_USUARIO']) ? htmlspecialchars($configExistente['DB_USUARIO']) : 'root'; ?>" required>
                            <small style="color: #6c757d;">XAMPP: root | Producción: usuario específico</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="db_password">Contraseña:</label>
                            <input type="password" id="db_password" name="db_password" placeholder="<?php echo isset($configExistente['DB_PASSWORD']) && !empty($configExistente['DB_PASSWORD']) ? '••••••••' : 'Vacío por defecto en XAMPP'; ?>">
                            <small style="color: #6c757d;">Dejar vacío en XAMPP, usar contraseña segura en producción</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="db_puerto">Puerto:</label>
                            <input type="number" id="db_puerto" name="db_puerto" value="<?php echo isset($configExistente['DB_PUERTO']) ? htmlspecialchars($configExistente['DB_PUERTO']) : '3306'; ?>">
                            <small style="color: #6c757d;">3306 es el puerto por defecto de MySQL</small>
                        </div>
                        
                        <hr style="margin: 30px 0;">
                        
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; border-left: 4px solid #28a745;">
                            <h4 style="margin-top: 0; color: #28a745;">📦 Datos Iniciales</h4>
                            <p>Elige cómo quieres inicializar tu base de datos:</p>
                            
                            <div style="margin: 15px 0;">
                                <label style="display: block; padding: 15px; background: white; border: 2px solid #ddd; border-radius: 5px; cursor: pointer; margin-bottom: 10px;" onmouseover="this.style.borderColor='#28a745'" onmouseout="if(!document.getElementById('seed_demo').checked) this.style.borderColor='#ddd'">
                                    <input type="radio" name="seed_option" id="seed_demo" value="1" checked onchange="document.querySelectorAll('label').forEach(l => l.style.borderColor='#ddd'); this.parentElement.style.borderColor='#28a745';">
                                    <strong>🎯 Con datos de prueba (Recomendado)</strong><br>
                                    <small style="color: #6c757d;">Incluye 20 productos de ejemplo, 5 categorías y usuarios de prueba. Perfecto para explorar el sistema.</small>
                                </label>
                                
                                <label style="display: block; padding: 15px; background: white; border: 2px solid #ddd; border-radius: 5px; cursor: pointer;" onmouseover="this.style.borderColor='#dc3545'" onmouseout="if(!document.getElementById('seed_clean').checked) this.style.borderColor='#ddd'">
                                    <input type="radio" name="seed_option" id="seed_clean" value="0" onchange="document.querySelectorAll('label').forEach(l => l.style.borderColor='#ddd'); this.parentElement.style.borderColor='#dc3545';">
                                    <strong>🔲 Base de datos limpia</strong><br>
                                    <small style="color: #6c757d;">Solo estructura de tablas y usuarios admin/empleado. Ideal para producción.</small>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn">Probar Conexión y Continuar</button>
                        <a href="?paso=1" class="btn">Anterior</a>
                    </form>
                </div>
                <?php
            }
            
            function mostrarPaso3() {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $db_host = $_POST['db_host'];
                    $db_nombre = $_POST['db_nombre'];
                    $db_usuario = $_POST['db_usuario'];
                    $db_password = $_POST['db_password'];
                    $db_puerto = $_POST['db_puerto'] ?: '3306';
                    $seed_demo = isset($_POST['seed_option']) ? $_POST['seed_option'] : '1';
                    $_SESSION['seed_demo'] = $seed_demo;
                    
                    // Probar conexión
                    try {
                        $dsn = "mysql:host=$db_host;port=$db_puerto;charset=utf8mb4";
                        $pdo = new PDO($dsn, $db_usuario, $db_password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        // Crear base de datos si no existe
                        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_nombre` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                        $pdo->exec("USE `$db_nombre`");
                        
                        // Guardar configuración
                        $config = [
                            'DB_HOST' => $db_host,
                            'DB_NOMBRE' => $db_nombre,
                            'DB_USUARIO' => $db_usuario,
                            'DB_PASSWORD' => $db_password,
                            'DB_CHARSET' => 'utf8mb4',
                            'DB_PUERTO' => $db_puerto,
                            'URL_BASE' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/',
                            'EMPRESA_NOMBRE' => 'Tennis y Fragancias',
                            'EMPRESA_CIUDAD' => 'Barrancabermeja',
                            'EMPRESA_DEPARTAMENTO' => 'Santander',
                            'EMPRESA_PAIS' => 'Colombia',
                            'EMPRESA_EMAIL' => 'info@tennisyfragancias.com',
                            'EMPRESA_TELEFONO' => '+57 300 123 4567',
                            'MERCADOPAGO_PUBLIC_KEY' => 'TU_PUBLIC_KEY_AQUI',
                            'MERCADOPAGO_ACCESS_TOKEN' => 'TU_ACCESS_TOKEN_AQUI',
                            'EMAIL_HOST' => 'smtp.gmail.com',
                            'EMAIL_PORT' => '587',
                            'EMAIL_USUARIO' => 'tu_email@gmail.com',
                            'EMAIL_PASSWORD' => 'tu_password',
                            'EMAIL_REMITENTE' => 'info@tennisyfragancias.com',
                            'EMAIL_REMITENTE_NOMBRE' => 'Tennis y Fragancias',
                            'APP_SECRET_KEY' => bin2hex(random_bytes(32)),
                            'APP_ENV' => 'development',
                            'DEBUG_MODE' => 'true'
                        ];
                        
                        // Crear archivo .env
                        $envContent = '';
                        foreach($config as $key => $value) {
                            $envContent .= "$key=$value\n";
                        }
                        
                        file_put_contents('app/config/.env', $envContent);
                        
                        echo '<div class="alert alert-success">✅ Conexión exitosa y configuración guardada.</div>';
                        echo '<a href="?paso=4" class="btn">Continuar con la Instalación</a>';
                        echo '<a href="?paso=2" class="btn">Anterior</a>';
                        
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">❌ Error de conexión: ' . $e->getMessage() . '</div>';
                        echo '<a href="?paso=2" class="btn">Intentar Nuevamente</a>';
                    }
                } else {
                    header('Location: ?paso=2');
                }
            }
            
            function mostrarPaso4() {
                ?>
                <div class="step">
                    <h3>🗄️ Paso 3: Instalación de Base de Datos</h3>
                    <p>Instalando la estructura de la base de datos y datos iniciales...</p>
                    
                    <div class="progress">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                    
                    <?php
                    try {
                        // Cargar configuración
                        $envFile = 'app/config/.env';
                        if (!file_exists($envFile)) {
                            throw new Exception('Archivo de configuración no encontrado. Ejecuta primero el paso 2.');
                        }
                        
                        $config = [];
                        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        foreach ($lines as $line) {
                            if (strpos($line, '=') !== false && strpos(trim($line), '#') !== 0) {
                                list($key, $value) = explode('=', $line, 2);
                                $config[trim($key)] = trim($value);
                            }
                        }
                        
                        // Conectar a la base de datos
                        $dsn = "mysql:host={$config['DB_HOST']};port={$config['DB_PUERTO']};dbname={$config['DB_NOMBRE']};charset=utf8mb4";
                        $pdo = new PDO($dsn, $config['DB_USUARIO'], $config['DB_PASSWORD']);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        // Crear estructura de base de datos
                        $ejecutados = crearEstructuraBaseDatos($pdo);
                        
                        // Insertar datos de ejemplo si se seleccionó
                        $conDatosDemo = false;
                        if (!empty($_SESSION['seed_demo']) && $_SESSION['seed_demo'] === '1') {
                            insertarDatosDemo($pdo);
                            $conDatosDemo = true;
                        }
                        
                        echo '<div class="alert alert-success">';
                        echo "✅ Base de datos instalada exitosamente.<br>";
                        echo "📊 Tablas creadas: $ejecutados<br>";
                        if ($conDatosDemo) {
                            echo "📦 Datos de prueba cargados: 20 productos y 5 categorías<br>";
                        } else {
                            echo "🔲 Base de datos limpia (sin datos de prueba)<br>";
                        }
                        echo "🎉 El sistema está listo para usar.";
                        echo '</div>';
                        
                        echo '<div class="alert alert-info">';
                        echo '<strong>🔑 Credenciales predefinidas:</strong><br><br>';
                        
                        echo '<div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 10px;">';
                        echo '<strong>👑 Administrador (Control Total):</strong><br>';
                        echo 'Email: <code>admin@tennisyfragancias.com</code><br>';
                        echo 'Contraseña: <code>admin123</code><br>';
                        echo '<small>Gestiona productos, categorías, usuarios, pedidos y todo el sistema.</small>';
                        echo '</div>';
                        
                        echo '<div style="background: #d1ecf1; padding: 10px; border-radius: 5px; margin-bottom: 10px;">';
                        echo '<strong>👔 Empleado (Ventas y Facturación):</strong><br>';
                        echo 'Email: <code>empleado@tennisyfragancias.com</code><br>';
                        echo 'Contraseña: <code>empleado123</code><br>';
                        echo '<small>Gestiona ventas, facturación y atención al cliente.</small>';
                        echo '</div>';
                        
                        echo '<div style="background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 10px;">';
                        echo '<strong>🛒 Cliente de Ejemplo:</strong><br>';
                        echo 'Email: <code>cliente@example.com</code><br>';
                        echo 'Contraseña: <code>cliente123</code><br>';
                        echo '<small>Para probar el proceso de compra como cliente.</small>';
                        echo '</div>';
                        
                        echo '<em>⚠️ <strong>Importante:</strong> Cambia estas contraseñas inmediatamente en producción y elimina el cliente de ejemplo.</em>';
                        echo '</div>';
                        
                        echo '<a href="index.php" class="btn btn-success">🚀 Ir al Sistema</a>';
                        echo '<a href="?paso=1" class="btn">Reinstalar</a>';
                        
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">❌ Error durante la instalación: ' . $e->getMessage() . '</div>';
                        echo '<a href="?paso=4" class="btn">Reintentar</a>';
                        echo '<a href="?paso=2" class="btn">Volver a Configuración</a>';
                    }
                    ?>
                </div>
                <?php
            }
            
            /**
             * Crea toda la estructura de la base de datos
             */
            function crearEstructuraBaseDatos(PDO $pdo): int {
                $ejecutados = 0;
                
                // Tabla usuarios (normalizada - sin datos de dirección)
                $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL,
                    apellido VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    password_hash VARCHAR(255) NOT NULL,
                    telefono VARCHAR(20),
                    rol ENUM('cliente', 'empleado', 'administrador') DEFAULT 'cliente',
                    estado ENUM('activo', 'inactivo', 'suspendido') DEFAULT 'activo',
                    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    ultima_conexion TIMESTAMP NULL,
                    INDEX idx_email (email),
                    INDEX idx_rol (rol),
                    INDEX idx_estado (estado)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla direcciones (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS direcciones (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    usuario_id INT NOT NULL,
                    tipo ENUM('principal', 'envio', 'facturacion') DEFAULT 'principal',
                    direccion TEXT NOT NULL,
                    ciudad VARCHAR(100) NOT NULL,
                    departamento VARCHAR(100) NOT NULL,
                    codigo_postal VARCHAR(10),
                    es_principal TINYINT(1) DEFAULT 0,
                    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
                    INDEX idx_usuario (usuario_id),
                    INDEX idx_tipo (tipo),
                    INDEX idx_principal (es_principal)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla marcas (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS marcas (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL UNIQUE,
                    descripcion TEXT,
                    logo VARCHAR(255),
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_nombre (nombre),
                    INDEX idx_estado (estado)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla tallas (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS tallas (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(20) NOT NULL UNIQUE,
                    orden INT DEFAULT 0,
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    INDEX idx_nombre (nombre),
                    INDEX idx_orden (orden)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla colores (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS colores (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(50) NOT NULL UNIQUE,
                    codigo_hex VARCHAR(7),
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    INDEX idx_nombre (nombre)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla generos (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS generos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(20) NOT NULL UNIQUE,
                    descripcion VARCHAR(100),
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    INDEX idx_nombre (nombre)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla metodos_pago (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS metodos_pago (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(50) NOT NULL UNIQUE,
                    descripcion TEXT,
                    activo TINYINT(1) DEFAULT 1,
                    requiere_configuracion TINYINT(1) DEFAULT 0,
                    INDEX idx_nombre (nombre),
                    INDEX idx_activo (activo)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla estados_pedido (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS estados_pedido (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(50) NOT NULL UNIQUE,
                    descripcion VARCHAR(200),
                    orden INT DEFAULT 0,
                    es_final TINYINT(1) DEFAULT 0,
                    color VARCHAR(7) DEFAULT '#6c757d',
                    INDEX idx_nombre (nombre),
                    INDEX idx_orden (orden)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla categorias
                $pdo->exec("CREATE TABLE IF NOT EXISTS categorias (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL UNIQUE,
                    descripcion TEXT,
                    imagen VARCHAR(255),
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_nombre (nombre),
                    INDEX idx_estado (estado)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Asegurar índice único por nombre (por si la tabla existía sin la restricción)
                try {
                    $pdo->exec("ALTER TABLE categorias ADD UNIQUE KEY uq_categorias_nombre (nombre)");
                } catch (PDOException $e) {
                    // Ignorar si ya existe el índice único
                }
                
                // Eliminar posibles duplicados previos por nombre, conservando el registro con id menor
                try {
                    $pdo->exec("DELETE c1 FROM categorias c1 INNER JOIN categorias c2 ON c1.nombre = c2.nombre AND c1.id > c2.id");
                } catch (PDOException $e) {
                    // No interrumpir instalación si falla
                }
                
                // Tabla productos (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    codigo_sku VARCHAR(50) NOT NULL UNIQUE,
                    nombre VARCHAR(200) NOT NULL,
                    descripcion TEXT,
                    precio DECIMAL(10,2) NOT NULL,
                    precio_oferta DECIMAL(10,2),
                    categoria_id INT NOT NULL,
                    marca_id INT,
                    talla_id INT,
                    color_id INT,
                    genero_id INT,
                    stock INT NOT NULL DEFAULT 0,
                    stock_minimo INT DEFAULT 5,
                    imagen_principal VARCHAR(255),
                    destacado TINYINT(1) DEFAULT 0,
                    estado ENUM('activo', 'inactivo', 'agotado') DEFAULT 'activo',
                    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE,
                    FOREIGN KEY (marca_id) REFERENCES marcas(id) ON DELETE SET NULL,
                    FOREIGN KEY (talla_id) REFERENCES tallas(id) ON DELETE SET NULL,
                    FOREIGN KEY (color_id) REFERENCES colores(id) ON DELETE SET NULL,
                    FOREIGN KEY (genero_id) REFERENCES generos(id) ON DELETE SET NULL,
                    INDEX idx_codigo_sku (codigo_sku),
                    INDEX idx_nombre (nombre),
                    INDEX idx_categoria (categoria_id),
                    INDEX idx_marca (marca_id),
                    INDEX idx_talla (talla_id),
                    INDEX idx_color (color_id),
                    INDEX idx_genero (genero_id),
                    INDEX idx_precio (precio),
                    INDEX idx_destacado (destacado),
                    INDEX idx_estado (estado)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla pedidos (normalizada)
                $pdo->exec("CREATE TABLE IF NOT EXISTS pedidos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    usuario_id INT NOT NULL,
                    numero_orden VARCHAR(50) NOT NULL UNIQUE,
                    subtotal DECIMAL(10,2) NOT NULL,
                    costo_envio DECIMAL(10,2) DEFAULT 0,
                    descuento DECIMAL(10,2) DEFAULT 0,
                    total DECIMAL(10,2) NOT NULL,
                    estado_id INT NOT NULL,
                    metodo_pago_id INT,
                    estado_pago ENUM('pendiente', 'pagado', 'rechazado', 'reembolsado') DEFAULT 'pendiente',
                    direccion_envio_id INT,
                    telefono_contacto VARCHAR(20) NOT NULL,
                    notas TEXT,
                    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
                    FOREIGN KEY (estado_id) REFERENCES estados_pedido(id),
                    FOREIGN KEY (metodo_pago_id) REFERENCES metodos_pago(id) ON DELETE SET NULL,
                    FOREIGN KEY (direccion_envio_id) REFERENCES direcciones(id) ON DELETE SET NULL,
                    INDEX idx_numero_orden (numero_orden),
                    INDEX idx_usuario (usuario_id),
                    INDEX idx_estado (estado_id),
                    INDEX idx_metodo_pago (metodo_pago_id),
                    INDEX idx_estado_pago (estado_pago),
                    INDEX idx_fecha_pedido (fecha_pedido)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;

                // Migraciones suaves para columnas nuevas usadas en el modelo
                try { $pdo->exec("ALTER TABLE pedidos ADD COLUMN IF NOT EXISTS tipo_pedido ENUM('online','presencial') DEFAULT 'online'"); } catch (PDOException $e) {}
                try { $pdo->exec("ALTER TABLE pedidos ADD COLUMN IF NOT EXISTS empleado_id INT NULL"); } catch (PDOException $e) {}
                try { $pdo->exec("ALTER TABLE pedidos ADD INDEX IF NOT EXISTS idx_empleado (empleado_id)"); } catch (PDOException $e) {}
                
                // Tabla detalle_pedidos
                $pdo->exec("CREATE TABLE IF NOT EXISTS detalle_pedidos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    pedido_id INT NOT NULL,
                    producto_id INT NOT NULL,
                    cantidad INT NOT NULL,
                    precio_unitario DECIMAL(10,2) NOT NULL,
                    subtotal DECIMAL(10,2) NOT NULL,
                    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
                    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
                    INDEX idx_pedido (pedido_id),
                    INDEX idx_producto (producto_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla carrito
                $pdo->exec("CREATE TABLE IF NOT EXISTS carrito (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    usuario_id INT NOT NULL,
                    producto_id INT NOT NULL,
                    cantidad INT NOT NULL DEFAULT 1,
                    precio_unitario DECIMAL(10,2) DEFAULT 0,
                    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
                    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
                    UNIQUE KEY unique_usuario_producto (usuario_id, producto_id),
                    INDEX idx_usuario (usuario_id),
                    INDEX idx_producto (producto_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Asegurar columna precio_unitario para instalaciones previas
                try { $pdo->exec("ALTER TABLE carrito ADD COLUMN IF NOT EXISTS precio_unitario DECIMAL(10,2) DEFAULT 0"); } catch (PDOException $e) {}
                
                
                // Tabla facturas
                $pdo->exec("CREATE TABLE IF NOT EXISTS facturas (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    pedido_id INT NOT NULL UNIQUE,
                    numero_factura VARCHAR(50) NOT NULL UNIQUE,
                    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    total DECIMAL(10,2) NOT NULL,
                    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
                    INDEX idx_numero_factura (numero_factura),
                    INDEX idx_pedido (pedido_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Tabla historial de stock
                $pdo->exec("CREATE TABLE IF NOT EXISTS historial_stock (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    producto_id INT NOT NULL,
                    usuario_id INT,
                    tipo ENUM('entrada', 'salida', 'ajuste') NOT NULL,
                    cantidad INT NOT NULL,
                    stock_anterior INT NOT NULL,
                    stock_nuevo INT NOT NULL,
                    motivo VARCHAR(255),
                    fecha_movimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
                    INDEX idx_producto (producto_id),
                    INDEX idx_fecha (fecha_movimiento),
                    INDEX idx_tipo (tipo)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                $ejecutados++;
                
                // Insertar datos básicos en tablas normalizadas
                
                // Insertar marcas
                $pdo->exec("INSERT IGNORE INTO marcas (nombre, descripcion, estado) VALUES 
                    ('Nike', 'Nike Inc. - Just Do It', 'activo'),
                    ('Adidas', 'Adidas AG - Impossible is Nothing', 'activo'),
                    ('Puma', 'Puma SE - Forever Faster', 'activo'),
                    ('Reebok', 'Reebok International Ltd.', 'activo'),
                    ('Converse', 'Converse Inc. - All Star', 'activo'),
                    ('New Balance', 'New Balance Athletics Inc.', 'activo'),
                    ('Vans', 'Vans Inc. - Off The Wall', 'activo'),
                    ('Jordan', 'Air Jordan by Nike', 'activo'),
                    ('Under Armour', 'Under Armour Inc.', 'activo'),
                    ('Fila', 'Fila Holdings Corp.', 'activo')");
                
                // Insertar tallas
                $pdo->exec("INSERT IGNORE INTO tallas (nombre, orden, estado) VALUES 
                    ('XS', 1, 'activo'),
                    ('S', 2, 'activo'),
                    ('M', 3, 'activo'),
                    ('L', 4, 'activo'),
                    ('XL', 5, 'activo'),
                    ('XXL', 6, 'activo'),
                    ('28', 7, 'activo'),
                    ('29', 8, 'activo'),
                    ('30', 9, 'activo'),
                    ('31', 10, 'activo'),
                    ('32', 11, 'activo'),
                    ('33', 12, 'activo'),
                    ('34', 13, 'activo'),
                    ('35', 14, 'activo'),
                    ('36', 15, 'activo'),
                    ('37', 16, 'activo'),
                    ('38', 17, 'activo'),
                    ('39', 18, 'activo'),
                    ('40', 19, 'activo'),
                    ('41', 20, 'activo'),
                    ('42', 21, 'activo'),
                    ('43', 22, 'activo'),
                    ('44', 23, 'activo'),
                    ('45', 24, 'activo')");
                
                // Insertar colores
                $pdo->exec("INSERT IGNORE INTO colores (nombre, codigo_hex, estado) VALUES 
                    ('Negro', '#000000', 'activo'),
                    ('Blanco', '#FFFFFF', 'activo'),
                    ('Rojo', '#FF0000', 'activo'),
                    ('Azul', '#0000FF', 'activo'),
                    ('Verde', '#008000', 'activo'),
                    ('Amarillo', '#FFFF00', 'activo'),
                    ('Naranja', '#FFA500', 'activo'),
                    ('Rosa', '#FFC0CB', 'activo'),
                    ('Morado', '#800080', 'activo'),
                    ('Gris', '#808080', 'activo'),
                    ('Marrón', '#A52A2A', 'activo'),
                    ('Azul Marino', '#000080', 'activo'),
                    ('Turquesa', '#40E0D0', 'activo'),
                    ('Dorado', '#FFD700', 'activo'),
                    ('Plateado', '#C0C0C0', 'activo')");
                
                // Insertar géneros
                $pdo->exec("INSERT IGNORE INTO generos (nombre, descripcion, estado) VALUES 
                    ('Hombre', 'Productos para hombres', 'activo'),
                    ('Mujer', 'Productos para mujeres', 'activo'),
                    ('Niño', 'Productos para niños', 'activo'),
                    ('Niña', 'Productos para niñas', 'activo'),
                    ('Unisex', 'Productos unisex', 'activo')");
                
                // Insertar métodos de pago
                $pdo->exec("INSERT IGNORE INTO metodos_pago (nombre, descripcion, activo, requiere_configuracion) VALUES 
                    ('Efectivo', 'Pago en efectivo', 1, 0),
                    ('Tarjeta de Crédito', 'Pago con tarjeta de crédito', 1, 1),
                    ('Tarjeta Débito', 'Pago con tarjeta débito', 1, 1),
                    ('Transferencia Bancaria', 'Transferencia bancaria', 1, 0),
                    ('MercadoPago', 'Pago a través de MercadoPago', 1, 1),
                    ('Nequi', 'Pago con Nequi', 1, 1),
                    ('Daviplata', 'Pago con Daviplata', 1, 1)");
                
                // Insertar estados de pedido
                $pdo->exec("INSERT IGNORE INTO estados_pedido (nombre, descripcion, orden, es_final, color) VALUES 
                    ('Pendiente', 'Pedido pendiente de confirmación', 1, 0, '#ffc107'),
                    ('Confirmado', 'Pedido confirmado y en preparación', 2, 0, '#17a2b8'),
                    ('Enviado', 'Pedido enviado al cliente', 3, 0, '#007bff'),
                    ('Entregado', 'Pedido entregado exitosamente', 4, 1, '#28a745'),
                    ('Cancelado', 'Pedido cancelado', 5, 1, '#dc3545'),
                    ('Reembolsado', 'Pedido reembolsado', 6, 1, '#6c757d')");
                
                // Insertar usuario administrador por defecto
                $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
                $pdo->exec("INSERT IGNORE INTO usuarios (nombre, apellido, email, password_hash, telefono, rol, estado) 
                           VALUES ('Administrador', 'Sistema', 'admin@tennisyfragancias.com', '$passwordHash', '+57 300 123 4567', 'administrador', 'activo')");
                
                // Insertar usuario empleado por defecto
                $passwordHashEmpleado = password_hash('empleado123', PASSWORD_DEFAULT);
                $pdo->exec("INSERT IGNORE INTO usuarios (nombre, apellido, email, password_hash, telefono, rol, estado) 
                           VALUES ('Empleado', 'Ventas', 'empleado@tennisyfragancias.com', '$passwordHashEmpleado', '+57 300 234 5678', 'empleado', 'activo')");
                
                // Insertar usuario cliente de ejemplo
                $passwordHashCliente = password_hash('cliente123', PASSWORD_DEFAULT);
                $pdo->exec("INSERT IGNORE INTO usuarios (nombre, apellido, email, password_hash, telefono, rol, estado) 
                           VALUES ('Juan Carlos', 'Pérez López', 'cliente@example.com', '$passwordHashCliente', '+57 311 456 7890', 'cliente', 'activo')");
                
                // Insertar direcciones para los usuarios
                $pdo->exec("INSERT IGNORE INTO direcciones (usuario_id, tipo, direccion, ciudad, departamento, codigo_postal, es_principal) VALUES 
                    (1, 'principal', 'Calle Principal #123', 'Barrancabermeja', 'Santander', '687031', 1),
                    (2, 'principal', 'Calle Comercio #45', 'Barrancabermeja', 'Santander', '687031', 1),
                    (3, 'principal', 'Carrera 15 #28-45 Apto 301', 'Barrancabermeja', 'Santander', '687031', 1)");
                
                return $ejecutados;
            }
            
            /**
             * Ejecuta un archivo SQL respetando cambios de DELIMITER
             * y omitiendo comentarios de una línea que empiezan con '--'.
             */
            function ejecutarSqlConDelimiters(PDO $pdo, string $rutaArchivo): array {
                $handle = fopen($rutaArchivo, 'r');
                if (!$handle) {
                    throw new Exception('No se pudo abrir el archivo SQL.');
                }
                $delimitador = ';';
                $buffer = '';
                $ejecutados = 0;
                $total = 0;
                while (($line = fgets($handle)) !== false) {
                    $line = rtrim($line, "\r\n");
                    $trim = ltrim($line);
                    // Omitir comentarios '--' y líneas vacías
                    if ($trim === '' || strpos($trim, '--') === 0) {
                        continue;
                    }
                    // Manejar cambio de delimitador
                    if (stripos($trim, 'DELIMITER ') === 0) {
                        $delimitador = trim(substr($trim, 10));
                        continue;
                    }
                    $buffer .= $line . "\n";
                    // Si termina con el delimitador actual, ejecutar
                    if (substr($buffer, -strlen($delimitador)) === $delimitador) {
                        $statement = trim(substr($buffer, 0, -strlen($delimitador)));
                        if ($statement !== '') {
                            $total++;
                            try {
                                // Suavizar instalaciones repetidas: añadir IF NOT EXISTS donde aplique
                                $stmtNorm = preg_replace('/^CREATE\s+DATABASE\s+(?!IF\s+NOT\s+EXISTS)/i', 'CREATE DATABASE IF NOT EXISTS ', $statement);
                                $stmtNorm = preg_replace('/^CREATE\s+TABLE\s+(?!IF\s+NOT\s+EXISTS)/i', 'CREATE TABLE IF NOT EXISTS ', $stmtNorm);
                                $stmtNorm = preg_replace('/^CREATE\s+VIEW\s+(?!IF\s+NOT\s+EXISTS)/i', 'CREATE VIEW IF NOT EXISTS ', $stmtNorm);
                                // Los TRIGGER no soportan IF NOT EXISTS; se manejarán por catch
                                $pdo->exec($stmtNorm);
                                $ejecutados++;
                            } catch (PDOException $e) {
                                // Ignorar objetos ya existentes
                                $msg = $e->getMessage();
                                if (
                                    stripos($msg, 'already exists') === false &&
                                    stripos($msg, '42S01') === false && // base table or view already exists
                                    stripos($msg, '1050') === false
                                ) {
                                    fclose($handle);
                                    throw $e;
                                }
                            }
                        }
                        $buffer = '';
                    }
                }
                fclose($handle);
                // Ejecutar cualquier resto sin delimitador final
                $statement = trim($buffer);
                if ($statement !== '') {
                    $total++;
                    try {
                        $stmtNorm = preg_replace('/^CREATE\s+DATABASE\s+(?!IF\s+NOT\s+EXISTS)/i', 'CREATE DATABASE IF NOT EXISTS ', $statement);
                        $stmtNorm = preg_replace('/^CREATE\s+TABLE\s+(?!IF\s+NOT\s+EXISTS)/i', 'CREATE TABLE IF NOT EXISTS ', $stmtNorm);
                        $stmtNorm = preg_replace('/^CREATE\s+VIEW\s+(?!IF\s+NOT\s+EXISTS)/i', 'CREATE VIEW IF NOT EXISTS ', $stmtNorm);
                        $pdo->exec($stmtNorm);
                        $ejecutados++;
                    } catch (PDOException $e) {
                        $msg = $e->getMessage();
                        if (
                            stripos($msg, 'already exists') === false &&
                            stripos($msg, '42S01') === false &&
                            stripos($msg, '1050') === false
                        ) {
                            throw $e;
                        }
                    }
                }
                return ['ejecutados' => $ejecutados, 'total' => $total];
            }
            
            /**
             * Inserta categorías y productos de ejemplo para una demo completa.
             */
            function insertarDatosDemo(PDO $pdo): void {
                // Asegurar categorías base
                $categorias = [
                    'Tenis Deportivos' => 'Calzado deportivo para hombre, mujer y niños',
                    'Tenis Casuales' => 'Calzado casual para el día a día',
                    'Zapatos Formales' => 'Calzado formal para hombre y mujer',
                    'Zapatos Deportivos' => 'Calzado deportivo especializado',
                    'Accesorios' => 'Medias, cordones y accesorios para calzado'
                ];
                $stmtCat = $pdo->prepare("INSERT INTO categorias (nombre, descripcion, estado) VALUES (:n, :d, 'activo') ON DUPLICATE KEY UPDATE descripcion=VALUES(descripcion), estado='activo'");
                foreach ($categorias as $nombre => $desc) {
                    $stmtCat->execute([':n' => $nombre, ':d' => $desc]);
                }
                // Mapa nombre -> id
                $ids = [];
                $res = $pdo->query("SELECT id, nombre FROM categorias");
                foreach ($res->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $ids[$row['nombre']] = (int)$row['id'];
                }
                
                // Productos de ejemplo
                $productos = [
                    ['Tenis Runner Pro', 'Tenis Deportivos', 219000, 30, 'RUNPRO-001', 'unisex', 'Nike', '42', 'Azul'],
                    ['Tenis Street Classic', 'Tenis Casuales', 189000, 25, 'STREET-002', 'unisex', 'Adidas', '41', 'Blanco'],
                    ['Zapato Oxford Premium', 'Zapatos Formales', 259000, 15, 'OXFORD-003', 'hombre', 'Clarks', '43', 'Negro'],
                    ['Zapato Derby Elegance', 'Zapatos Formales', 249000, 12, 'DERBY-004', 'hombre', 'Bata', '42', 'Café'],
                    ['Tenis Trail Grip', 'Zapatos Deportivos', 299000, 18, 'TRAIL-005', 'unisex', 'Salomon', '42', 'Gris'],
                    ['Tenis Ultra Light', 'Tenis Deportivos', 239000, 40, 'ULTRA-006', 'mujer', 'Puma', '38', 'Rosa'],
                    ['Tenis Retro 90s', 'Tenis Casuales', 199000, 28, 'RETRO-007', 'unisex', 'Reebok', '41', 'Blanco'],
                    ['Cordones Resistentes', 'Accesorios', 19000, 200, 'ACC-CL-008', 'unisex', 'Generic', null, 'Negro'],
                    ['Medias Deportivas Pack x3', 'Accesorios', 35000, 150, 'ACC-MD-009', 'unisex', 'Generic', null, 'Blanco'],
                    ['Plantillas Confort', 'Accesorios', 42000, 120, 'ACC-PL-010', 'unisex', 'Dr. Scholl', null, 'Azul'],
                    ['Tenis Air Zoom', 'Tenis Deportivos', 329000, 20, 'AIRZ-011', 'unisex', 'Nike', '42', 'Negro'],
                    ['Tenis Canvas Low', 'Tenis Casuales', 159000, 35, 'CANV-012', 'unisex', 'Converse', '41', 'Rojo'],
                    ['Tenis City Walk', 'Tenis Casuales', 179000, 27, 'CITY-013', 'unisex', 'Skechers', '42', 'Gris'],
                    ['Tenis Court Pro', 'Zapatos Deportivos', 269000, 22, 'COURT-014', 'unisex', 'Wilson', '43', 'Blanco'],
                    ['Zapato Loafer Ejecutivo', 'Zapatos Formales', 239000, 10, 'LOAF-015', 'hombre', 'Florsheim', '42', 'Marrón'],
                    ['Tenis Marathon X', 'Tenis Deportivos', 289000, 16, 'MARAX-016', 'unisex', 'Asics', '42', 'Azul'],
                    ['Tenis Flex Run', 'Tenis Deportivos', 209000, 26, 'FLEX-017', 'mujer', 'New Balance', '39', 'Morado'],
                    ['Tenis Urban Move', 'Tenis Casuales', 169000, 32, 'URBAN-018', 'unisex', 'Vans', '41', 'Negro'],
                    ['Zapato Monk Strap', 'Zapatos Formales', 279000, 8, 'MONK-019', 'hombre', 'Bata', '42', 'Café'],
                    ['Tenis Pro Training', 'Zapatos Deportivos', 259000, 19, 'TRAIN-020', 'unisex', 'Under Armour', '43', 'Azul']
                ];
                $stmtProd = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria_id, stock, imagen_principal, marca, talla, color, genero, codigo_sku, estado, destacado) VALUES (:n, :d, :p, :cat, :s, :img, :m, :t, :c, :g, :sku, 'activo', 1) ON DUPLICATE KEY UPDATE precio=VALUES(precio), stock=VALUES(stock), estado='activo', destacado=1");
                foreach ($productos as $p) {
                    list($nombre, $catNombre, $precio, $stock, $sku, $genero, $marca, $talla, $color) = $p;
                    $catId = isset($ids[$catNombre]) ? $ids[$catNombre] : null;
                    if (!$catId) continue;
                    $stmtProd->execute([
                        ':n' => $nombre,
                        ':d' => $nombre . ' - Producto de demostración.',
                        ':p' => $precio,
                        ':cat' => $catId,
                        ':s' => $stock,
                        ':img' => null,
                        ':m' => $marca,
                        ':t' => $talla,
                        ':c' => $color,
                        ':g' => $genero,
                        ':sku' => $sku
                    ]);
                }
            }
            
            function verificarRequisitos() {
                $requisitos = [];
                
                // PHP Version
                $phpVersion = version_compare(PHP_VERSION, '7.4.0', '>=');
                $requisitos['PHP 7.4 o superior: ' . PHP_VERSION] = $phpVersion;
                
                // Extensiones PHP
                $extensiones = ['pdo', 'pdo_mysql', 'curl', 'mbstring', 'openssl', 'fileinfo'];
                foreach($extensiones as $ext) {
                    $requisitos["Extensión PHP $ext"] = extension_loaded($ext);
                }
                
                // Permisos de escritura
                $requisitos['Permisos de escritura en app/config/'] = is_writable('app/config/');
                $requisitos['Permisos de escritura en public/imagenes/'] = is_writable('public/imagenes/');
                
                // Archivos necesarios
                $requisitos['Archivo de configuración portable'] = file_exists('app/config/ConfiguracionPortable.php');
                
                return $requisitos;
            }
            ?>
        </div>
    </div>
</body>
</html>
