<?php
/**
 * Tennis y Zapatos - E-commerce
 * Punto de entrada principal de la aplicación
 * Barrancabermeja, Santander, Colombia
 */

// Iniciar sesión
session_start();

// Configuración de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir constantes
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('VIEWS_PATH', APP_PATH . '/vistas');
define('CONTROLLERS_PATH', APP_PATH . '/controladores');
define('MODELS_PATH', APP_PATH . '/modelos');

// Cargar configuración
require_once APP_PATH . '/config/configuracion.php';
require_once APP_PATH . '/config/base_datos.php';

// Cargar clases base
require_once APP_PATH . '/core/Controlador.php';
require_once APP_PATH . '/core/Modelo.php';
require_once APP_PATH . '/core/Vista.php';
require_once APP_PATH . '/core/Enrutador.php';

// Iniciar enrutador
$enrutador = new Enrutador();
$enrutador->manejarRuta();
?>

