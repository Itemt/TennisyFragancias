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
     * para crear el esquema si no existen.
     */
    private function asegurarEsquemaInstalado() {
        try {
            // Comprobar existencia de tabla 'productos'
            $stmt = $this->conexion->query("SHOW TABLES LIKE 'productos'");
            $existeProductos = $stmt->fetchColumn();
            
            if (!$existeProductos) {
                $this->importarEsquemaDesdeSql();
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
        $sqlFile = (defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 2)) . '/database/tennisyzapatos_db.sql';
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
    
    // Prevenir clonación
    private function __clone() {}
    
    // Prevenir deserialización
    public function __wakeup() {
        throw new Exception("No se puede deserializar un singleton");
    }
}
