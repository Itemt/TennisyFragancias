<?php
/**
 * Configuración Portable para Tennis y Fragancias
 * 
 * Esta clase permite cargar la configuración desde un archivo .env
 * o usar valores por defecto para facilitar la portabilidad del proyecto.
 */

class ConfiguracionPortable {
    private static $configuracion = [];
    private static $cargado = false;
    
    /**
     * Carga la configuración desde el archivo .env o usa valores por defecto
     */
    public static function cargar() {
        if (self::$cargado) {
            return;
        }
        
        $archivoEnv = __DIR__ . '/.env';
        
        // Intentar cargar desde archivo .env
        if (file_exists($archivoEnv)) {
            self::cargarDesdeArchivo($archivoEnv);
        } else {
            // Usar configuración por defecto
            self::usarConfiguracionPorDefecto();
        }
        
        // Definir constantes
        self::definirConstantes();
        
        self::$cargado = true;
    }
    
    /**
     * Carga configuración desde archivo .env
     */
    private static function cargarDesdeArchivo($archivo) {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lineas as $linea) {
            // Ignorar comentarios
            if (strpos(trim($linea), '#') === 0) {
                continue;
            }
            
            // Buscar líneas con formato KEY=VALUE
            if (strpos($linea, '=') !== false) {
                list($clave, $valor) = explode('=', $linea, 2);
                $clave = trim($clave);
                $valor = trim($valor);
                
                // Remover comillas si las hay
                $valor = trim($valor, '"\'');
                
                self::$configuracion[$clave] = $valor;
            }
        }
    }
    
    /**
     * Usa configuración por defecto si no existe archivo .env
     */
    private static function usarConfiguracionPorDefecto() {
        self::$configuracion = [
            // Base de datos
            'DB_HOST' => 'localhost',
            'DB_NOMBRE' => 'tennisyzapatos_db',
            'DB_USUARIO' => 'root',
            'DB_PASSWORD' => '',
            'DB_CHARSET' => 'utf8mb4',
            'DB_PUERTO' => '3306',
            
            // Aplicación
            'URL_BASE' => 'http://localhost/tennisyfragancias/',
            'EMPRESA_NOMBRE' => 'Tennis y Zapatos',
            'EMPRESA_CIUDAD' => 'Barrancabermeja',
            'EMPRESA_DEPARTAMENTO' => 'Santander',
            'EMPRESA_PAIS' => 'Colombia',
            'EMPRESA_EMAIL' => 'info@tennisyzapatos.com',
            'EMPRESA_TELEFONO' => '+57 300 123 4567',
            
            // MercadoPago
            'MERCADOPAGO_PUBLIC_KEY' => 'TU_PUBLIC_KEY_AQUI',
            'MERCADOPAGO_ACCESS_TOKEN' => 'TU_ACCESS_TOKEN_AQUI',
            
            // Email
            'EMAIL_HOST' => 'smtp.gmail.com',
            'EMAIL_PORT' => '587',
            'EMAIL_USUARIO' => 'tu_email@gmail.com',
            'EMAIL_PASSWORD' => 'tu_password',
            'EMAIL_REMITENTE' => 'info@tennisyzapatos.com',
            'EMAIL_REMITENTE_NOMBRE' => 'Tennis y Zapatos',
            
            // Seguridad
            'APP_SECRET_KEY' => 'clave_secreta_por_defecto_cambiar_en_produccion',
            'APP_ENV' => 'development',
            'DEBUG_MODE' => 'true'
        ];
    }
    
    /**
     * Define las constantes de la aplicación
     */
    private static function definirConstantes() {
        // Base de datos
        define('DB_HOST', self::obtener('DB_HOST', 'localhost'));
        define('DB_NOMBRE', self::obtener('DB_NOMBRE', 'tennisyzapatos_db'));
        define('DB_USUARIO', self::obtener('DB_USUARIO', 'root'));
        define('DB_PASSWORD', self::obtener('DB_PASSWORD', ''));
        define('DB_CHARSET', self::obtener('DB_CHARSET', 'utf8mb4'));
        define('DB_PUERTO', self::obtener('DB_PUERTO', '3306'));
        
        // Aplicación
        define('NOMBRE_SITIO', self::obtener('EMPRESA_NOMBRE', 'Tennis y Zapatos'));
        define('URL_BASE', self::obtener('URL_BASE', 'http://localhost/tennisyfragancias/'));
        define('URL_PUBLICA', URL_BASE . 'public/');
        
        // Empresa
        define('EMPRESA_NOMBRE', self::obtener('EMPRESA_NOMBRE', 'Tennis y Zapatos'));
        define('EMPRESA_CIUDAD', self::obtener('EMPRESA_CIUDAD', 'Barrancabermeja'));
        define('EMPRESA_DEPARTAMENTO', self::obtener('EMPRESA_DEPARTAMENTO', 'Santander'));
        define('EMPRESA_PAIS', self::obtener('EMPRESA_PAIS', 'Colombia'));
        define('EMPRESA_EMAIL', self::obtener('EMPRESA_EMAIL', 'info@tennisyzapatos.com'));
        define('EMPRESA_TELEFONO', self::obtener('EMPRESA_TELEFONO', '+57 300 123 4567'));
        
        // Colores corporativos
        define('COLOR_PRIMARIO', '#DC3545');
        define('COLOR_SECUNDARIO', '#000000');
        define('COLOR_TERCIARIO', '#FFFFFF');
        
        // MercadoPago
        define('MERCADOPAGO_PUBLIC_KEY', self::obtener('MERCADOPAGO_PUBLIC_KEY', 'TU_PUBLIC_KEY_AQUI'));
        define('MERCADOPAGO_ACCESS_TOKEN', self::obtener('MERCADOPAGO_ACCESS_TOKEN', 'TU_ACCESS_TOKEN_AQUI'));
        
        // Email
        define('EMAIL_HOST', self::obtener('EMAIL_HOST', 'smtp.gmail.com'));
        define('EMAIL_PORT', (int)self::obtener('EMAIL_PORT', '587'));
        define('EMAIL_USUARIO', self::obtener('EMAIL_USUARIO', 'tu_email@gmail.com'));
        define('EMAIL_PASSWORD', self::obtener('EMAIL_PASSWORD', 'tu_password'));
        define('EMAIL_REMITENTE', self::obtener('EMAIL_REMITENTE', 'info@tennisyzapatos.com'));
        define('EMAIL_REMITENTE_NOMBRE', self::obtener('EMAIL_REMITENTE_NOMBRE', 'Tennis y Zapatos'));
        
        // Seguridad
        define('APP_SECRET_KEY', self::obtener('APP_SECRET_KEY', 'clave_secreta_por_defecto'));
        define('APP_ENV', self::obtener('APP_ENV', 'development'));
        define('DEBUG_MODE', self::obtener('DEBUG_MODE', 'true') === 'true');
        
        // Sesión
        define('TIEMPO_SESION', 3600);
        
        // Roles
        define('ROL_ADMINISTRADOR', 'administrador');
        define('ROL_EMPLEADO', 'empleado');
        define('ROL_CLIENTE', 'cliente');
        
        // Estados
        define('ESTADO_PENDIENTE', 'pendiente');
        define('ESTADO_ENVIADO', 'enviado');
        define('ESTADO_ENTREGADO', 'entregado');
        define('ESTADO_CANCELADO', 'cancelado');
        
        // Paginación
        define('PRODUCTOS_POR_PAGINA', 12);
        define('PEDIDOS_POR_PAGINA', 10);
        
        // Imágenes
        define('RUTA_IMAGENES_PRODUCTOS', URL_PUBLICA . 'imagenes/productos/');
        define('TAMANO_MAXIMO_IMAGEN', 5242880);
    }
    
    /**
     * Obtiene un valor de configuración
     */
    public static function obtener($clave, $valorPorDefecto = null) {
        return isset(self::$configuracion[$clave]) ? self::$configuracion[$clave] : $valorPorDefecto;
    }
    
    /**
     * Verifica si la configuración está cargada
     */
    public static function estaCargada() {
        return self::$cargado;
    }
    
    /**
     * Obtiene toda la configuración
     */
    public static function obtenerTodaLaConfiguracion() {
        return self::$configuracion;
    }
}
?>
