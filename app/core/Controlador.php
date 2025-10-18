<?php
/**
 * Clase base Controlador
 */
class Controlador {
    
    /**
     * Cargar un modelo
     */
    protected function cargarModelo($modelo) {
        $rutaModelo = MODELS_PATH . '/' . $modelo . '.php';
        if (file_exists($rutaModelo)) {
            require_once $rutaModelo;
            return new $modelo();
        }
        die("El modelo {$modelo} no existe");
    }
    
    /**
     * Cargar una vista
     */
    protected function cargarVista($vista, $datos = []) {
        $rutaVista = VIEWS_PATH . '/' . $vista . '.php';
        if (file_exists($rutaVista)) {
            extract($datos);
            require_once $rutaVista;
        } else {
            die("La vista {$vista} no existe");
        }
    }
    
    /**
     * Redirigir a una URL
     */
    protected function redirigir($url) {
        header('Location: ' . URL_BASE . $url);
        exit();
    }
    
    /**
     * Verificar si el usuario está autenticado
     */
    protected function verificarAutenticacion() {
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirigir('auth/login');
        }
    }
    
    /**
     * Verificar rol de usuario
     */
    protected function verificarRol($rolesPermitidos) {
        $this->verificarAutenticacion();
        
        if (!is_array($rolesPermitidos)) {
            $rolesPermitidos = [$rolesPermitidos];
        }
        
        if (!in_array($_SESSION['usuario_rol'], $rolesPermitidos)) {
            $this->redirigir('error/sin-permiso');
        }
    }
    
    /**
     * Enviar respuesta JSON
     */
    protected function enviarJson($datos, $codigo = 200) {
        http_response_code($codigo);
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit();
    }
    
    /**
     * Limpiar datos de entrada
     */
    protected function limpiarDatos($datos) {
        return htmlspecialchars(strip_tags(trim($datos)));
    }
    
    /**
     * Validar email
     */
    protected function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Generar token CSRF
     */
    protected function generarTokenCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verificar token CSRF
     */
    protected function verificarTokenCSRF($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
}
