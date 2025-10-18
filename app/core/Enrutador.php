<?php
/**
 * Clase Enrutador - Gestiona las rutas de la aplicación
 */
class Enrutador {
    private $controlador = 'InicioControlador';
    private $metodo = 'index';
    private $parametros = [];
    
    public function __construct() {
        $url = $this->obtenerUrl();
        
        // Buscar controlador
        if (isset($url[0])) {
            $controladorNombre = ucfirst($url[0]) . 'Controlador';
            $rutaControlador = CONTROLLERS_PATH . '/' . $controladorNombre . '.php';
            
            if (file_exists($rutaControlador)) {
                $this->controlador = $controladorNombre;
                unset($url[0]);
            }
        }
        
        // Cargar controlador
        require_once CONTROLLERS_PATH . '/' . $this->controlador . '.php';
        $this->controlador = new $this->controlador;
        
        // Buscar método
        if (isset($url[1])) {
            if (method_exists($this->controlador, $url[1])) {
                $this->metodo = $url[1];
                unset($url[1]);
            }
        }
        
        // Obtener parámetros
        $this->parametros = $url ? array_values($url) : [];
    }
    
    public function manejarRuta() {
        call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
    }
    
    private function obtenerUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
