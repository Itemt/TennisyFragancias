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
            // Manejar rutas con múltiples niveles como stock/actualizar
            if (isset($url[2])) {
                $metodoNombre = $this->convertirGuionesACamelCase($url[1] . '_' . $url[2]);
                if (method_exists($this->controlador, $metodoNombre)) {
                    $this->metodo = $metodoNombre;
                    unset($url[1], $url[2]);
                } else {
                    // Intentar solo con el segundo nivel
                    $metodoNombre = $this->convertirGuionesACamelCase($url[2]);
                    if (method_exists($this->controlador, $metodoNombre)) {
                        $this->metodo = $metodoNombre;
                        unset($url[1], $url[2]);
                    }
                }
            } else {
                // Convertir guiones a camelCase
                $metodoNombre = $this->convertirGuionesACamelCase($url[1]);
                
                if (method_exists($this->controlador, $metodoNombre)) {
                    $this->metodo = $metodoNombre;
                    unset($url[1]);
                }
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
    
    /**
     * Convertir guiones a camelCase
     * Ejemplo: actualizar-stock -> actualizarStock
     */
    private function convertirGuionesACamelCase($string) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
    }
}
