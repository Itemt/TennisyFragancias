<?php
/**
 * Configuración de la base de datos
 */

// Cargar configuración portable
require_once __DIR__ . '/ConfiguracionPortable.php';
ConfiguracionPortable::cargar();

// Las constantes ya están definidas por ConfiguracionPortable

/**
 * Clase para gestionar la conexión a la base de datos
 */
class BaseDatos {
    private static $instancia = null;
    private $conexion;
    
    private function __construct() {
        try {
            $puerto = defined('DB_PUERTO') ? DB_PUERTO : '3306';
            $dsnConDb = "mysql:host=" . DB_HOST . ";port=" . $puerto . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
            $dsnSinDb = "mysql:host=" . DB_HOST . ";port=" . $puerto . ";charset=" . DB_CHARSET;
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            try {
                // Intentar conexión directa a la base de datos objetivo
                $this->conexion = new PDO($dsnConDb, DB_USUARIO, DB_PASSWORD, $opciones);
            } catch (PDOException $e) {
                // Si la base de datos no existe (1049), crearla y reintentar
                if (strpos($e->getMessage(), '1049') !== false || stripos($e->getMessage(), 'Unknown database') !== false) {
                    $pdoTemporal = new PDO($dsnSinDb, DB_USUARIO, DB_PASSWORD, $opciones);
                    $nombreDb = DB_NOMBRE;
                    $charset = DB_CHARSET;
                    $pdoTemporal->exec("CREATE DATABASE IF NOT EXISTS `{$nombreDb}` CHARACTER SET {$charset} COLLATE {$charset}_unicode_ci");
                    $pdoTemporal = null;
                    // Reintentar conexión a la base creada
                    $this->conexion = new PDO($dsnConDb, DB_USUARIO, DB_PASSWORD, $opciones);
                } else {
                    throw $e;
                }
            }

            // Verificar tablas críticas y auto-instalar esquema si faltan
            $this->asegurarEsquemaInstalado();
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
    
    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }
    
    public function obtenerConexion() {
        return $this->conexion;
    }

    /**
     * Verifica la existencia de tablas críticas y ejecuta el script SQL
     * para crear el esquema si no existen. También verifica si hay datos.
     */
    private function asegurarEsquemaInstalado() {
        try {
            // Comprobar existencia de tabla 'productos'
            $stmt = $this->conexion->query("SHOW TABLES LIKE 'productos'");
            $existeProductos = $stmt->fetchColumn();
            
            if (!$existeProductos) {
                $this->importarEsquemaDesdeSql();
            } else {
                // Verificar si hay datos en la base de datos
                $this->verificarYDatosIniciales();
            }
        } catch (Throwable $t) {
            // En caso de error silencioso, no bloquear la app
        }
    }

    /**
     * Importa el esquema desde el archivo SQL del proyecto.
     * Maneja bloques con DELIMITER para triggers convirtiéndolos a ';'.
     */
    private function importarEsquemaDesdeSql() {
        $sqlFile = (defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 2)) . '/database/tennisyzapatos_db_simple.sql';
        if (!file_exists($sqlFile)) {
            return;
        }
        $sql = file_get_contents($sqlFile);
        if ($sql === false) {
            return;
        }
        // Normalizar saltos de línea
        $sql = str_replace(["\r\n", "\r"], "\n", $sql);
        // Eliminar líneas de comentarios '-- ...' y vacías al dividir
        // Manejar bloques con DELIMITER // ... END// → END;
        $sql = str_replace(["DELIMITER //", "DELIMITER ;"], '', $sql);
        $sql = preg_replace("#/\\/#", ";", $sql); // reemplazar '//' por ';'
        
        $comandos = explode(';', $sql);
        foreach ($comandos as $comando) {
            $comando = trim($comando);
            if ($comando === '' || strpos($comando, '--') === 0) {
                continue;
            }
            try {
                $this->conexion->exec($comando);
            } catch (PDOException $e) {
                // Ignorar errores de objetos ya existentes
                $mensaje = $e->getMessage();
                if (stripos($mensaje, 'already exists') !== false) {
                    continue;
                }
                // Re-lanzar otros errores críticos
                throw $e;
            }
        }
    }

    /**
     * Limpia todos los datos existentes para empezar de cero
     */
    public function limpiarDatosExistentes() {
        try {
            error_log("DEBUG: Iniciando limpieza de datos existentes");
            
            // Deshabilitar verificación de claves foráneas temporalmente
            $this->conexion->exec("SET FOREIGN_KEY_CHECKS = 0");
            
            // Limpiar tablas en orden correcto (respetando foreign keys)
            $tablas = [
                'detalle_pedidos',
                'carrito', 
                'historial_stock',
                'facturas',
                'pedidos'
            ];
            
            foreach ($tablas as $tabla) {
                $stmt = $this->conexion->prepare("DELETE FROM $tabla");
                $stmt->execute();
                $eliminados = $stmt->rowCount();
                error_log("DEBUG: Eliminados $eliminados registros de $tabla");
            }
            
            // Solo eliminar clientes, mantener admin y empleado
            $stmt = $this->conexion->prepare("DELETE FROM usuarios WHERE rol = 'cliente'");
            $stmt->execute();
            $eliminados = $stmt->rowCount();
            error_log("DEBUG: Eliminados $eliminados clientes");
            
            // Rehabilitar verificación de claves foráneas
            $this->conexion->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            error_log("DEBUG: Limpieza completada exitosamente");
            return true;
            
        } catch (Exception $e) {
            error_log("ERROR en limpiarDatosExistentes: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica si hay datos iniciales y los inserta si es necesario
     */
    private function verificarYDatosIniciales() {
        try {
            // Verificar y actualizar estructura de tabla carrito
            $this->verificarEstructuraCarrito();
            
            // Verificar si ya se ejecutó el llenado de datos
            $stmt = $this->conexion->query("SELECT COUNT(*) as total FROM pedidos");
            $pedidosExistentes = $stmt->fetch()['total'];
            
            if ($pedidosExistentes > 100) {
                error_log("DEBUG: Ya hay suficientes datos ($pedidosExistentes pedidos), no se ejecuta llenado");
                return;
            }
            
            // Verificar si hay clientes (excluyendo admin y empleado)
            $stmt = $this->conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'");
            $clientes = $stmt->fetch()['total'];
            
            // Log para debug
            error_log("DEBUG: Clientes encontrados: $clientes");
            
            // Verificar estructura de tabla usuarios
            $stmt = $this->conexion->query("DESCRIBE usuarios");
            $columnas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nombresColumnas = array_column($columnas, 'Field');
            error_log("DEBUG: Columnas disponibles en usuarios: " . implode(', ', $nombresColumnas));
            
            // Si hay menos de 10 clientes, llenar con datos de producción
            if ($clientes < 10) {
                error_log("DEBUG: Iniciando llenado de datos de producción");
                $this->llenarDatosProduccion();
                error_log("DEBUG: Llenado de datos completado");
                
                // Verificar cuántos clientes hay después
                $stmt = $this->conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'");
                $clientesDespues = $stmt->fetch()['total'];
                error_log("DEBUG: Clientes después del llenado: $clientesDespues");
                
                // Si aún hay pocos clientes, intentar insertar solo clientes
                if ($clientesDespues < 10) {
                    error_log("DEBUG: Aún hay pocos clientes, intentando inserción directa");
                    $this->insertarClientes();
                }
            } else {
                error_log("DEBUG: Ya hay suficientes clientes, no se llenan datos");
            }
        } catch (Throwable $t) {
            error_log("ERROR en verificarYDatosIniciales: " . $t->getMessage());
        }
    }

    /**
     * Verifica y actualiza la estructura de la tabla carrito
     */
    private function verificarEstructuraCarrito() {
        try {
            // Verificar si la columna talla_id existe en la tabla carrito
            $stmt = $this->conexion->query("SHOW COLUMNS FROM carrito LIKE 'talla_id'");
            $columnaExiste = $stmt->fetch();
            
            if (!$columnaExiste) {
                error_log("DEBUG: Columna talla_id no existe en carrito, agregándola...");
                
                // Agregar la columna talla_id
                $this->conexion->exec("ALTER TABLE carrito ADD COLUMN talla_id int(11) DEFAULT NULL AFTER producto_id");
                
                // Agregar índice para la nueva columna
                $this->conexion->exec("ALTER TABLE carrito ADD KEY idx_talla (talla_id)");
                
                error_log("DEBUG: Columna talla_id agregada exitosamente a la tabla carrito");
            } else {
                error_log("DEBUG: Columna talla_id ya existe en la tabla carrito");
            }
        } catch (Exception $e) {
            error_log("ERROR al verificar estructura de carrito: " . $e->getMessage());
        }
    }

    /**
     * Llena la base de datos con datos de producción
     */
    private function llenarDatosProduccion() {
        try {
            error_log("DEBUG: Iniciando llenarDatosProduccion");
            
            // Desactivar restricciones temporalmente
            $this->conexion->exec("SET FOREIGN_KEY_CHECKS = 0");
            
            // Insertar clientes
            error_log("DEBUG: Insertando clientes");
            $this->insertarClientes();
            
            // Insertar productos adicionales
            error_log("DEBUG: Insertando productos adicionales");
            $this->insertarProductosAdicionales();
            
            // Insertar pedidos
            error_log("DEBUG: Insertando pedidos");
            $this->insertarPedidos();
            
            // Insertar facturas
            error_log("DEBUG: Insertando facturas");
            $this->insertarFacturas();
            
            // Insertar historial de stock
            error_log("DEBUG: Insertando historial de stock");
            $this->insertarHistorialStock();
            
            // Insertar productos en carrito
            error_log("DEBUG: Insertando carrito");
            $this->insertarCarrito();
            
            // Insertar direcciones
            error_log("DEBUG: Insertando direcciones");
            $this->insertarDirecciones();
            
            // Reactivar restricciones
            $this->conexion->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            error_log("DEBUG: llenarDatosProduccion completado exitosamente");
            
        } catch (Throwable $t) {
            error_log("ERROR en llenarDatosProduccion: " . $t->getMessage());
            $this->conexion->exec("SET FOREIGN_KEY_CHECKS = 1");
        }
    }

    /**
     * Inserta clientes de prueba
     */
    private function insertarClientes() {
        // Verificar si ya hay suficientes clientes
        $stmt = $this->conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'");
        $clientesExistentes = $stmt->fetch()['total'];
        error_log("DEBUG: Clientes existentes antes de insertar: $clientesExistentes");
        
        if ($clientesExistentes >= 15) {
            error_log("DEBUG: Ya hay suficientes clientes, no se insertan más");
            return;
        }
        
        $clientes = [
            ['María', 'González Rodríguez', 'maria.gonzalez@email.com', '+57 310 123 4567'],
            ['Carlos', 'Martínez López', 'carlos.martinez@email.com', '+57 311 234 5678'],
            ['Ana', 'Fernández Silva', 'ana.fernandez@email.com', '+57 312 345 6789'],
            ['Luis', 'Ramírez Torres', 'luis.ramirez@email.com', '+57 313 456 7890'],
            ['Sofia', 'Herrera Jiménez', 'sofia.herrera@email.com', '+57 314 567 8901'],
            ['Diego', 'Vargas Morales', 'diego.vargas@email.com', '+57 315 678 9012'],
            ['Valentina', 'Castro Ruiz', 'valentina.castro@email.com', '+57 316 789 0123'],
            ['Andrés', 'Mendoza Peña', 'andres.mendoza@email.com', '+57 317 890 1234'],
            ['Camila', 'Rojas Gutiérrez', 'camila.rojas@email.com', '+57 318 901 2345'],
            ['Sebastián', 'Moreno Vega', 'sebastian.moreno@email.com', '+57 319 012 3456'],
            ['Isabella', 'Díaz Castillo', 'isabella.diaz@email.com', '+57 320 123 4567'],
            ['Mateo', 'Sánchez Aguilar', 'mateo.sanchez@email.com', '+57 321 234 5678'],
            ['Natalia', 'Cruz Herrera', 'natalia.cruz@email.com', '+57 322 345 6789'],
            ['Alejandro', 'Flores Medina', 'alejandro.flores@email.com', '+57 323 456 7890'],
            ['Gabriela', 'Ortega Ramos', 'gabriela.ortega@email.com', '+57 324 567 8901']
        ];

        // Preparar statement con manejo de errores mejorado
        try {
            $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, telefono, rol, estado) VALUES (?, ?, ?, ?, ?, 'cliente', 'activo')");
            error_log("DEBUG: Statement preparado exitosamente");
        } catch (PDOException $e) {
            error_log("ERROR preparando statement: " . $e->getMessage());
            return;
        }
        
        $clientesInsertados = 0;
        
        foreach ($clientes as $index => $cliente) {
            try {
                $resultado = $stmt->execute([
                    $cliente[0], 
                    $cliente[1], 
                    $cliente[2], 
                    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password hash
                    $cliente[3]
                ]);
                
                if ($resultado) {
                    $clientesInsertados++;
                    error_log("DEBUG: Cliente " . ($index + 1) . " insertado: " . $cliente[0] . " " . $cliente[1]);
                } else {
                    error_log("ERROR: Falló la inserción del cliente " . ($index + 1) . ": " . $cliente[0]);
                }
                
            } catch (PDOException $e) {
                error_log("ERROR insertando cliente " . ($index + 1) . " (" . $cliente[0] . "): " . $e->getMessage());
                // Continuar con el siguiente cliente
                continue;
            }
        }
        
        error_log("DEBUG: Total clientes insertados: $clientesInsertados");
        
        // Verificar cuántos clientes hay después
        $stmt = $this->conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'");
        $clientesDespues = $stmt->fetch()['total'];
        error_log("DEBUG: Total clientes después de inserción: $clientesDespues");
    }

    /**
     * Inserta productos adicionales
     */
    private function insertarProductosAdicionales() {
        $productos = [
            ['Air Force 1', 'Zapatillas clásicas Nike Air Force 1 en cuero blanco', 280000.00, 250000.00, 1, 1, 13, 1, 1, 20, 'TF-NK-001-40-0001', 1],
            ['Air Max 90', 'Zapatillas Nike Air Max 90 con tecnología de amortiguación', 320000.00, NULL, 1, 1, 14, 1, 1, 15, 'TF-NK-002-41-0001', 1],
            ['Dunk Low', 'Zapatillas Nike Dunk Low estilo retro', 250000.00, 220000.00, 2, 1, 12, 3, 3, 18, 'TF-NK-003-39-0001', 0],
            ['React Element 55', 'Zapatillas Nike React con tecnología React', 300000.00, NULL, 1, 1, 15, 2, 1, 12, 'TF-NK-004-42-0001', 0],
            ['Blazer Mid', 'Zapatillas Nike Blazer Mid clásicas', 200000.00, 180000.00, 2, 1, 11, 1, 3, 25, 'TF-NK-005-38-0001', 0],
            ['Ultraboost 22', 'Zapatillas Adidas Ultraboost 22 con Boost', 450000.00, 400000.00, 1, 2, 13, 1, 1, 10, 'TF-AD-001-40-0001', 1],
            ['Gazelle', 'Zapatillas Adidas Gazelle clásicas', 180000.00, NULL, 2, 2, 12, 4, 3, 22, 'TF-AD-002-39-0001', 0],
            ['NMD R1', 'Zapatillas Adidas NMD R1 con Boost', 350000.00, 320000.00, 1, 2, 14, 2, 1, 16, 'TF-AD-003-41-0001', 1],
            ['Samba', 'Zapatillas Adidas Samba icónicas', 160000.00, 140000.00, 2, 2, 10, 1, 3, 30, 'TF-AD-004-37-0001', 0],
            ['Yeezy Boost 350', 'Zapatillas Adidas Yeezy Boost 350', 800000.00, NULL, 1, 2, 15, 1, 1, 5, 'TF-AD-005-42-0001', 1],
            ['RS-X Reinvention', 'Zapatillas Puma RS-X con tecnología RS', 220000.00, 200000.00, 1, 3, 13, 3, 1, 18, 'TF-PM-001-40-0001', 0],
            ['Suede Classic', 'Zapatillas Puma Suede Classic', 150000.00, NULL, 2, 3, 12, 2, 3, 25, 'TF-PM-002-39-0001', 0],
            ['Thunder Spectra', 'Zapatillas Puma Thunder Spectra', 280000.00, 250000.00, 1, 3, 14, 1, 1, 14, 'TF-PM-003-41-0001', 0],
            ['Cali Sport', 'Zapatillas Puma Cali Sport', 190000.00, 170000.00, 2, 3, 11, 4, 2, 20, 'TF-PM-004-38-0001', 0],
            ['Future Rider', 'Zapatillas Puma Future Rider', 200000.00, NULL, 1, 3, 15, 2, 1, 16, 'TF-PM-005-42-0001', 0],
            ['Chuck Taylor All Star High', 'Zapatillas Converse Chuck Taylor All Star High', 120000.00, 100000.00, 2, 5, 12, 1, 3, 35, 'TF-CV-001-39-0001', 1],
            ['Chuck Taylor All Star Low', 'Zapatillas Converse Chuck Taylor All Star Low', 110000.00, 95000.00, 2, 5, 11, 2, 3, 40, 'TF-CV-002-38-0001', 1],
            ['One Star', 'Zapatillas Converse One Star', 140000.00, NULL, 2, 5, 13, 3, 3, 28, 'TF-CV-003-40-0001', 0],
            ['Jack Purcell', 'Zapatillas Converse Jack Purcell', 130000.00, 115000.00, 2, 5, 14, 1, 3, 22, 'TF-CV-004-41-0001', 0],
            ['Chuck 70', 'Zapatillas Converse Chuck 70', 160000.00, 140000.00, 2, 5, 15, 2, 3, 18, 'TF-CV-005-42-0001', 0],
            ['Old Skool Classic', 'Zapatillas Vans Old Skool Classic', 150000.00, 130000.00, 2, 6, 12, 1, 3, 30, 'TF-VN-001-39-0001', 1],
            ['Authentic', 'Zapatillas Vans Authentic', 120000.00, NULL, 2, 6, 11, 2, 3, 35, 'TF-VN-002-38-0001', 1],
            ['Sk8-Hi', 'Zapatillas Vans Sk8-Hi', 160000.00, 140000.00, 2, 6, 13, 3, 3, 25, 'TF-VN-003-40-0001', 0],
            ['Era', 'Zapatillas Vans Era', 130000.00, 115000.00, 2, 6, 14, 1, 3, 28, 'TF-VN-004-41-0001', 0],
            ['Slip-On', 'Zapatillas Vans Slip-On', 140000.00, NULL, 2, 6, 15, 2, 3, 32, 'TF-VN-005-42-0001', 0],
            ['574 Core', 'Zapatillas New Balance 574 Core', 200000.00, 180000.00, 1, 7, 13, 1, 1, 20, 'TF-NB-001-40-0001', 1],
            ['990v5', 'Zapatillas New Balance 990v5', 450000.00, NULL, 1, 7, 14, 2, 1, 8, 'TF-NB-002-41-0001', 1],
            ['327', 'Zapatillas New Balance 327', 180000.00, 160000.00, 2, 7, 12, 3, 3, 25, 'TF-NB-003-39-0001', 0],
            ['1080v12', 'Zapatillas New Balance 1080v12', 380000.00, 350000.00, 1, 7, 15, 1, 1, 12, 'TF-NB-004-42-0001', 0],
            ['530', 'Zapatillas New Balance 530', 160000.00, NULL, 2, 7, 11, 2, 3, 30, 'TF-NB-005-38-0001', 0],
            ['Classic Leather', 'Zapatillas Reebok Classic Leather', 170000.00, 150000.00, 2, 4, 13, 1, 3, 25, 'TF-RB-001-40-0001', 0],
            ['Club C 85', 'Zapatillas Reebok Club C 85', 160000.00, NULL, 2, 4, 12, 2, 3, 28, 'TF-RB-002-39-0001', 0],
            ['Nano X1', 'Zapatillas Reebok Nano X1', 300000.00, 280000.00, 1, 4, 14, 3, 1, 15, 'TF-RB-003-41-0001', 0],
            ['Zig Kinetica', 'Zapatillas Reebok Zig Kinetica', 250000.00, 220000.00, 1, 4, 15, 1, 1, 18, 'TF-RB-004-42-0001', 0],
            ['Floatride Energy', 'Zapatillas Reebok Floatride Energy', 200000.00, 180000.00, 1, 4, 11, 2, 1, 20, 'TF-RB-005-38-0001', 0],
            ['Charged Assert 9', 'Zapatillas Under Armour Charged Assert 9', 180000.00, NULL, 1, 8, 13, 1, 1, 22, 'TF-UA-001-40-0001', 0],
            ['HOVR Phantom 2', 'Zapatillas Under Armour HOVR Phantom 2', 280000.00, 250000.00, 1, 8, 14, 2, 1, 16, 'TF-UA-002-41-0001', 0],
            ['Charged Bandit 6', 'Zapatillas Under Armour Charged Bandit 6', 200000.00, 180000.00, 1, 8, 15, 3, 1, 18, 'TF-UA-003-42-0001', 0],
            ['HOVR Sonic 4', 'Zapatillas Under Armour HOVR Sonic 4', 240000.00, NULL, 1, 8, 12, 1, 1, 20, 'TF-UA-004-39-0001', 0],
            ['Charged Pursuit 2', 'Zapatillas Under Armour Charged Pursuit 2', 160000.00, 140000.00, 1, 8, 11, 2, 1, 25, 'TF-UA-005-38-0001', 0]
        ];

        $stmt = $this->conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, precio_oferta, categoria_id, marca_id, talla_id, color_id, genero_id, stock, stock_minimo, codigo_sku, destacado, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 5, ?, ?, 'activo')");
        
        foreach ($productos as $producto) {
            try {
                $stmt->execute($producto);
            } catch (PDOException $e) {
                // Ignorar errores de duplicados
                if (stripos($e->getMessage(), 'Duplicate entry') === false) {
                    continue;
                }
            }
        }
    }

    /**
     * Inserta pedidos de ejemplo (6 meses de actividad)
     */
    private function insertarPedidos() {
        $pedidos = [];
        $fechaInicio = strtotime('2024-04-01'); // 6 meses atrás
        $fechaFin = strtotime('2024-10-19'); // Hoy
        $contadorPedido = 1;
        
        // Verificar cuántos clientes hay realmente
        $stmt = $this->conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'");
        $totalClientes = $stmt->fetch()['total'];
        error_log("DEBUG: Total clientes en BD: $totalClientes");
        
        // Obtener IDs de clientes disponibles
        $stmt = $this->conexion->query("SELECT id FROM usuarios WHERE rol = 'cliente' ORDER BY id");
        $clientesDisponibles = $stmt->fetchAll(PDO::FETCH_COLUMN);
        error_log("DEBUG: IDs de clientes disponibles: " . implode(', ', $clientesDisponibles));
        
        // Generar pedidos distribuidos en 6 meses (más realista)
        for ($i = 0; $i < 25; $i++) { // Solo 25 pedidos (más realista) en 6 meses (más realista)
            // Distribución más realista: más pedidos en meses recientes
            $mesActual = date('n'); // Mes actual (1-12)
            $mesesAtras = rand(1, 6); // 1-6 meses atrás
            $mesPedido = max(1, $mesActual - $mesesAtras);
            
            // Generar fecha aleatoria en el mes específico
            $primerDiaMes = mktime(0, 0, 0, $mesPedido, 1, date('Y'));
            $ultimoDiaMes = mktime(23, 59, 59, $mesPedido, date('t', $primerDiaMes), date('Y'));
            $fechaAleatoria = rand($primerDiaMes, $ultimoDiaMes);
            $fechaPedido = date('Y-m-d H:i:s', $fechaAleatoria);
            
            // Cliente aleatorio de los disponibles
            $clienteId = $clientesDisponibles[array_rand($clientesDisponibles)];
            
            // Método de pago aleatorio
            $metodoPago = rand(1, 5);
            
            // Estado aleatorio (más entregados que pendientes)
            $estados = [5, 5, 5, 4, 4, 3, 2, 1]; // Más entregados
            $estadoPedido = $estados[array_rand($estados)];
            
            // Tipo de pedido
            $tipoPedido = rand(1, 10) <= 7 ? 'online' : 'presencial';
            
            // Total aleatorio entre 100k y 800k
            $total = rand(100000, 800000);
            
            // Fechas de envío y entrega según estado
            $fechaEnvio = null;
            $fechaEntrega = null;
            
            if ($estadoPedido >= 4) {
                $fechaEnvio = date('Y-m-d H:i:s', $fechaAleatoria + rand(86400, 259200)); // 1-3 días después
            }
            
            if ($estadoPedido == 5) {
                $fechaEntrega = date('Y-m-d H:i:s', $fechaAleatoria + rand(172800, 432000)); // 2-5 días después
            }
            
            $numeroPedido = 'PED-2024-' . str_pad($contadorPedido, 3, '0', STR_PAD_LEFT);
            $contadorPedido++;
            
            $pedidos[] = [
                $numeroPedido, 
                $clienteId, 
                2, // empleado_id
                $total, 
                $total, 
                $metodoPago, 
                $estadoPedido, 
                $tipoPedido, 
                $fechaPedido, 
                $fechaEnvio, 
                $fechaEntrega
            ];
        }

        // Verificar estructura de la tabla pedidos y adaptar la inserción
        try {
            $stmt = $this->conexion->query("DESCRIBE pedidos");
            $columnas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nombresColumnas = array_column($columnas, 'Field');
            error_log("DEBUG: Columnas disponibles en pedidos: " . implode(', ', $nombresColumnas));
            
            // Verificar si numero_pedido existe
            if (in_array('numero_pedido', $nombresColumnas)) {
                error_log("DEBUG: Columna numero_pedido encontrada, usando inserción completa");
                $stmt = $this->conexion->prepare("INSERT INTO pedidos (numero_pedido, usuario_id, empleado_id, total, subtotal, metodo_pago_id, estado_pedido_id, tipo_pedido, fecha_pedido, fecha_envio, fecha_entrega) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                
                foreach ($pedidos as $pedido) {
                    try {
                        $stmt->execute($pedido);
                        error_log("DEBUG: Pedido insertado: " . $pedido[0]);
                    } catch (PDOException $e) {
                        error_log("ERROR insertando pedido: " . $e->getMessage());
                        if (stripos($e->getMessage(), 'Duplicate entry') === false) {
                            continue;
                        }
                    }
                }
            } else {
                error_log("DEBUG: Columna numero_pedido NO encontrada, usando inserción simplificada");
                // Insertar solo con las columnas que existen: usuario_id, empleado_id, total, estado, tipo_pedido, fecha_pedido
                $stmt = $this->conexion->prepare("INSERT INTO pedidos (usuario_id, empleado_id, total, estado, tipo_pedido, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?)");
                
                foreach ($pedidos as $pedido) {
                    // Crear array simplificado: usuario_id, empleado_id, total, estado, tipo_pedido, fecha_pedido
                    $pedidoSimplificado = [
                        $pedido[1], // usuario_id
                        $pedido[2], // empleado_id  
                        $pedido[3], // total
                        'entregado', // estado (hardcoded por ahora)
                        $pedido[7], // tipo_pedido
                        $pedido[8]  // fecha_pedido
                    ];
                    
                    try {
                        $stmt->execute($pedidoSimplificado);
                        error_log("DEBUG: Pedido insertado simplificado");
                    } catch (PDOException $e) {
                        error_log("ERROR insertando pedido simplificado: " . $e->getMessage());
                        if (stripos($e->getMessage(), 'Duplicate entry') === false) {
                            continue;
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            error_log("ERROR: No se puede describir tabla pedidos: " . $e->getMessage());
            return; // Salir si no se puede acceder a la tabla
        }
        
        // Insertar detalles de pedidos
        $this->insertarDetallesPedidos();
    }

    /**
     * Inserta detalles de pedidos
     */
    private function insertarDetallesPedidos() {
        // Obtener todos los pedidos insertados
        $stmt = $this->conexion->query("SELECT id FROM pedidos ORDER BY id");
        $pedidos = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Obtener productos disponibles
        $stmt = $this->conexion->query("SELECT id, precio FROM productos WHERE estado = 'activo'");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = $this->conexion->prepare("INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($pedidos as $pedidoId) {
            // 1-3 productos por pedido
            $numProductos = rand(1, 3);
            $productosSeleccionados = array_rand($productos, min($numProductos, count($productos)));
            
            if (!is_array($productosSeleccionados)) {
                $productosSeleccionados = [$productosSeleccionados];
            }
            
            foreach ($productosSeleccionados as $indice) {
                $producto = $productos[$indice];
                $cantidad = rand(1, 3);
                $precioUnitario = $producto['precio'];
                $subtotal = $precioUnitario * $cantidad;
                
                try {
                    $stmt->execute([
                        $pedidoId,
                        $producto['id'],
                        $cantidad,
                        $precioUnitario,
                        $subtotal
                    ]);
                } catch (PDOException $e) {
                    continue;
                }
            }
        }
    }

    /**
     * Inserta facturas de ejemplo (para todos los pedidos)
     */
    private function insertarFacturas() {
        // Verificar estructura de la tabla facturas
        try {
            $stmt = $this->conexion->query("DESCRIBE facturas");
            $columnas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nombresColumnas = array_column($columnas, 'Field');
            error_log("DEBUG: Columnas disponibles en facturas: " . implode(', ', $nombresColumnas));
            
            // Obtener todos los pedidos
            $stmt = $this->conexion->query("SELECT id, total, fecha_pedido FROM pedidos ORDER BY id");
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("DEBUG: " . count($pedidos) . " pedidos encontrados para generar facturas");
            
            if (in_array('usuario_id', $nombresColumnas)) {
                error_log("DEBUG: Columna usuario_id encontrada en facturas, usando inserción completa");
                $stmt = $this->conexion->prepare("INSERT INTO facturas (numero_factura, pedido_id, usuario_id, empleado_id, total, fecha_emision, fecha_vencimiento, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                $contadorFactura = 1;
                $facturasInsertadas = 0;
                
                foreach ($pedidos as $pedido) {
                    $numeroFactura = 'FAC-2024-' . str_pad($contadorFactura, 3, '0', STR_PAD_LEFT);
                    $contadorFactura++;
                    
                    // Estado de factura (más pagadas que pendientes)
                    $estadosFactura = ['pagada', 'pagada', 'pagada', 'pagada', 'pagada', 'pendiente', 'pendiente', 'vencida'];
                    $estadoFactura = $estadosFactura[array_rand($estadosFactura)];
                    
                    // Fecha de emisión = fecha del pedido
                    $fechaEmision = $pedido['fecha_pedido'];
                    
                    // Fecha de vencimiento (7 días después para pagadas, 30 días para pendientes)
                    $diasVencimiento = $estadoFactura === 'pagada' ? 7 : 30;
                    $fechaVencimiento = date('Y-m-d H:i:s', strtotime($fechaEmision) + ($diasVencimiento * 86400));
                    
                    // Obtener cliente aleatorio de los disponibles
                    $stmtClientes = $this->conexion->query("SELECT id FROM usuarios WHERE rol = 'cliente' ORDER BY id");
                    $clientesDisponibles = $stmtClientes->fetchAll(PDO::FETCH_COLUMN);
                    $clienteAleatorio = $clientesDisponibles[array_rand($clientesDisponibles)];
                    
                    // Obtener empleado aleatorio para esta factura específica
                    $stmtEmpleados = $this->conexion->query("SELECT id FROM usuarios WHERE rol = 'empleado' ORDER BY id");
                    $empleadosDisponibles = $stmtEmpleados->fetchAll(PDO::FETCH_COLUMN);
                    if (empty($empleadosDisponibles)) {
                        $empleadosDisponibles = [1]; // Fallback al admin si no hay empleados
                    }
                    $empleadoAleatorio = $empleadosDisponibles[array_rand($empleadosDisponibles)];
                    
                    try {
                        $stmt->execute([
                            $numeroFactura,
                            $pedido['id'],
                            $clienteAleatorio, // usuario_id aleatorio de clientes disponibles
                            $empleadoAleatorio, // empleado_id aleatorio para cada factura
                            $pedido['total'],
                            $fechaEmision,
                            $fechaVencimiento,
                            $estadoFactura
                        ]);
                        $facturasInsertadas++;
                        error_log("DEBUG: Factura $numeroFactura insertada para pedido " . $pedido['id'] . " asignada a empleado ID: $empleadoAleatorio");
                    } catch (PDOException $e) {
                        error_log("ERROR insertando factura: " . $e->getMessage());
                        if (stripos($e->getMessage(), 'Duplicate entry') === false) {
                            continue;
                        }
                    }
                }
                error_log("DEBUG: Total facturas insertadas (completa): $facturasInsertadas");
            } else {
                error_log("DEBUG: Columna usuario_id NO encontrada en facturas, usando inserción ultra-simplificada");
                // Solo usar las columnas que realmente existen: id, pedido_id, numero_factura, fecha_emision, total
                $stmt = $this->conexion->prepare("INSERT INTO facturas (numero_factura, pedido_id, fecha_emision, total) VALUES (?, ?, ?, ?)");
                
                $contadorFactura = 1;
                $facturasInsertadas = 0;
                
                foreach ($pedidos as $pedido) {
                    $numeroFactura = 'FAC-2024-' . str_pad($contadorFactura, 3, '0', STR_PAD_LEFT);
                    $contadorFactura++;
                    
                    // Fecha de emisión = fecha del pedido
                    $fechaEmision = $pedido['fecha_pedido'];
                    
                    try {
                        $stmt->execute([
                            $numeroFactura,
                            $pedido['id'],
                            $fechaEmision,
                            $pedido['total']
                        ]);
                        $facturasInsertadas++;
                        error_log("DEBUG: Factura insertada: $numeroFactura para pedido " . $pedido['id']);
                    } catch (PDOException $e) {
                        error_log("ERROR insertando factura ultra-simplificada: " . $e->getMessage());
                        if (stripos($e->getMessage(), 'Duplicate entry') === false) {
                            continue;
                        }
                    }
                }
                error_log("DEBUG: Total facturas insertadas (ultra-simplificada): $facturasInsertadas");
            }
        } catch (PDOException $e) {
            error_log("ERROR: No se puede describir tabla facturas: " . $e->getMessage());
            return;
        }
    }

    /**
     * Inserta historial de stock (6 meses de actividad)
     */
    private function insertarHistorialStock() {
        // Obtener todos los productos
        $stmt = $this->conexion->query("SELECT id, stock FROM productos WHERE estado = 'activo'");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $fechaInicio = strtotime('2024-04-01'); // 6 meses atrás
        $fechaFin = strtotime('2024-10-19'); // Hoy
        
        $stmt = $this->conexion->prepare("INSERT INTO historial_stock (producto_id, usuario_id, tipo, cantidad, stock_anterior, stock_nuevo, motivo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $totalRegistros = 0;
        $maximoRegistros = 200; // Límite máximo de registros
        
        foreach ($productos as $producto) {
            if ($totalRegistros >= $maximoRegistros) {
                error_log("DEBUG: Límite de registros de historial alcanzado ($maximoRegistros)");
                break;
            }
            $productoId = $producto['id'];
            $stockActual = $producto['stock'];
            
            // Insertar entrada inicial
            try {
                $stmt->execute([
                    $productoId,
                    1, // admin
                    'entrada',
                    $stockActual,
                    0,
                    $stockActual,
                    'Stock inicial'
                ]);
                $totalRegistros++;
            } catch (PDOException $e) {
                continue;
            }
            
            // Generar movimientos de stock durante 6 meses
            $stockTemporal = $stockActual;
            
            // Entradas de stock (reposiciones)
            for ($i = 0; $i < rand(1, 2); $i++) {
                $fechaAleatoria = rand($fechaInicio, $fechaFin);
                $cantidadEntrada = rand(5, 25);
                $stockAnterior = $stockTemporal;
                $stockTemporal += $cantidadEntrada;
                
                try {
                    $stmt->execute([
                        $productoId,
                        1, // admin
                        'entrada',
                        $cantidadEntrada,
                        $stockAnterior,
                        $stockTemporal,
                        'Reposición de stock'
                    ]);
                    $totalRegistros++;
                } catch (PDOException $e) {
                    continue;
                }
            }
            
            // Salidas de stock (ventas)
            for ($i = 0; $i < rand(2, 5); $i++) {
                $fechaAleatoria = rand($fechaInicio, $fechaFin);
                $cantidadSalida = rand(1, 5);
                
                if ($stockTemporal >= $cantidadSalida) {
                    $stockAnterior = $stockTemporal;
                    $stockTemporal -= $cantidadSalida;
                    
                    try {
                        $stmt->execute([
                            $productoId,
                            2, // empleado
                            'salida',
                            $cantidadSalida,
                            $stockAnterior,
                            $stockTemporal,
                            'Venta de producto'
                        ]);
                        $totalRegistros++;
                    } catch (PDOException $e) {
                        continue;
                    }
                }
            }
            
            // Ajustes de stock (muy pocos)
            for ($i = 0; $i < rand(0, 1); $i++) {
                $fechaAleatoria = rand($fechaInicio, $fechaFin);
                $ajuste = rand(-3, 3);
                
                if ($ajuste != 0 && $stockTemporal + $ajuste >= 0) {
                    $stockAnterior = $stockTemporal;
                    $stockTemporal += $ajuste;
                    
                    try {
                        $stmt->execute([
                            $productoId,
                            1, // admin
                            'ajuste',
                            abs($ajuste),
                            $stockAnterior,
                            $stockTemporal,
                            $ajuste > 0 ? 'Ajuste positivo' : 'Ajuste por pérdida'
                        ]);
                        $totalRegistros++;
                    } catch (PDOException $e) {
                        continue;
                    }
                }
            }
        }
        
        error_log("DEBUG: Total registros de historial de stock generados: $totalRegistros");
    }

    /**
     * Inserta productos en carrito (actividad actual)
     */
    private function insertarCarrito() {
        // Obtener productos disponibles
        $stmt = $this->conexion->query("SELECT id, precio FROM productos WHERE estado = 'activo'");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Verificar estructura de tabla carrito
        try {
            $stmt = $this->conexion->query("DESCRIBE carrito");
            $columnas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nombresColumnas = array_column($columnas, 'Field');
            error_log("DEBUG: Columnas disponibles en carrito: " . implode(', ', $nombresColumnas));
            
            if (in_array('precio', $nombresColumnas)) {
                $stmt = $this->conexion->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
            } else {
                $stmt = $this->conexion->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
            }
        } catch (PDOException $e) {
            error_log("ERROR: No se puede describir tabla carrito: " . $e->getMessage());
            return;
        }
        
        // Obtener clientes disponibles
        $stmt = $this->conexion->query("SELECT id FROM usuarios WHERE rol = 'cliente' ORDER BY id");
        $clientesDisponibles = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Insertar productos en carrito para diferentes clientes
        for ($i = 0; $i < 8; $i++) { // Solo 8 productos en carrito (más realista)
            $clienteId = $clientesDisponibles[array_rand($clientesDisponibles)]; // Cliente aleatorio de los disponibles
            $producto = $productos[array_rand($productos)];
            $cantidad = rand(1, 3);
            
            try {
                if (in_array('precio', $nombresColumnas)) {
                    $stmt->execute([
                        $clienteId,
                        $producto['id'],
                        $cantidad,
                        $producto['precio']
                    ]);
                } else {
                    $stmt->execute([
                        $clienteId,
                        $producto['id'],
                        $cantidad
                    ]);
                }
                error_log("DEBUG: Producto agregado al carrito del cliente $clienteId");
            } catch (PDOException $e) {
                error_log("ERROR insertando en carrito: " . $e->getMessage());
                // Ignorar errores de duplicados
                if (stripos($e->getMessage(), 'Duplicate entry') === false) {
                    continue;
                }
            }
        }
    }

    /**
     * Inserta direcciones para todos los clientes
     */
    private function insertarDirecciones() {
        $ciudades = [
            ['Bogotá', 'Cundinamarca', '110111'],
            ['Medellín', 'Antioquia', '050001'],
            ['Cali', 'Valle del Cauca', '760001'],
            ['Cartagena', 'Bolívar', '130001'],
            ['Bucaramanga', 'Santander', '680001'],
            ['Pereira', 'Risaralda', '660001'],
            ['Manizales', 'Caldas', '170001'],
            ['Ibagué', 'Tolima', '730001'],
            ['Santa Marta', 'Magdalena', '470001'],
            ['Pasto', 'Nariño', '520001'],
            ['Armenia', 'Quindío', '630001'],
            ['Villavicencio', 'Meta', '500001'],
            ['Neiva', 'Huila', '410001'],
            ['Montería', 'Córdoba', '230001'],
            ['Barrancabermeja', 'Santander', '687031']
        ];

        $stmt = $this->conexion->prepare("INSERT INTO direcciones (usuario_id, direccion, ciudad, departamento, codigo_postal, pais, es_principal) VALUES (?, ?, ?, ?, ?, 'Colombia', 1)");
        
        // Insertar direcciones para clientes (IDs 3-17)
        for ($i = 3; $i <= 17; $i++) {
            $ciudad = $ciudades[array_rand($ciudades)];
            $direccion = 'Calle ' . rand(1, 200) . ' #' . rand(1, 100) . '-' . rand(10, 99) . ' Casa ' . rand(1, 5);
            
            try {
                $stmt->execute([
                    $i,
                    $direccion,
                    $ciudad[0],
                    $ciudad[1],
                    $ciudad[2]
                ]);
            } catch (PDOException $e) {
                // Ignorar errores de duplicados
                if (stripos($e->getMessage(), 'Duplicate entry') === false) {
                    continue;
                }
            }
        }
    }
    
    // Prevenir clonación
    private function __clone() {}
    
    // Prevenir deserialización
    public function __wakeup() {
        throw new Exception("No se puede deserializar un singleton");
    }
}
