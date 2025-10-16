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
                ?>
                <div class="step">
                    <h3>⚙️ Paso 2: Configuración de Base de Datos</h3>
                    <p>Configura los parámetros de conexión a la base de datos:</p>
                    
                    <form method="POST" action="?paso=3">
                        <div class="form-group">
                            <label for="db_host">Host de Base de Datos:</label>
                            <input type="text" id="db_host" name="db_host" value="localhost" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="db_nombre">Nombre de la Base de Datos:</label>
                            <input type="text" id="db_nombre" name="db_nombre" value="tennisyzapatos_db" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="db_usuario">Usuario:</label>
                            <input type="text" id="db_usuario" name="db_usuario" value="root" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="db_password">Contraseña:</label>
                            <input type="password" id="db_password" name="db_password">
                        </div>
                        
                        <div class="form-group">
                            <label for="db_puerto">Puerto:</label>
                            <input type="number" id="db_puerto" name="db_puerto" value="3306">
                        </div>
                        
                        <div class="form-group">
                            <label for="seed_demo">
                                <input type="checkbox" id="seed_demo" name="seed_demo" value="1" checked>
                                Cargar datos de ejemplo (productos y categorías)
                            </label>
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
                    $seed_demo = isset($_POST['seed_demo']) ? '1' : '0';
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
                        
                        // Leer y ejecutar script SQL con soporte de DELIMITER (triggers)
                        $sqlFile = 'database/tennisyzapatos_db.sql';
                        if (!file_exists($sqlFile)) {
                            throw new Exception('Archivo SQL no encontrado: ' . $sqlFile);
                        }
                        
                        $resultado = ejecutarSqlConDelimiters($pdo, $sqlFile);
                        $ejecutados = $resultado['ejecutados'];
                        $total = $resultado['total'];
                        
                        // Insertar datos de ejemplo si se seleccionó
                        if (!empty($_SESSION['seed_demo']) && $_SESSION['seed_demo'] === '1') {
                            insertarDatosDemo($pdo);
                        }
                        
                        echo '<div class="alert alert-success">';
                        echo "✅ Base de datos instalada exitosamente.<br>";
                        echo "📊 Comandos ejecutados: $ejecutados de $total<br>";
                        echo "🎉 El sistema está listo para usar.";
                        echo '</div>';
                        
                        echo '<div class="alert alert-info">';
                        echo '<strong>Credenciales de administrador:</strong><br>';
                        echo 'Email: admin@tennisyfragancias.com<br>';
                        echo 'Contraseña: admin123<br>';
                        echo '<em>⚠️ Cambia esta contraseña inmediatamente después del primer inicio de sesión.</em>';
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
                $requisitos['Archivo SQL de base de datos'] = file_exists('database/tennisyfragancias_db.sql');
                $requisitos['Archivo de configuración portable'] = file_exists('app/config/ConfiguracionPortable.php');
                
                return $requisitos;
            }
            ?>
        </div>
    </div>
</body>
</html>
