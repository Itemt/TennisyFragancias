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
    
    // Prevenir clonación
    private function __clone() {}
    
    // Prevenir deserialización
    public function __wakeup() {
        throw new Exception("No se puede deserializar un singleton");
    }
}
?>

