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
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->conexion = new PDO($dsn, DB_USUARIO, DB_PASSWORD, $opciones);
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

