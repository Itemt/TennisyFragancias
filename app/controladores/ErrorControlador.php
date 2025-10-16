<?php
/**
 * Controlador de Errores
 */
class ErrorControlador extends Controlador {
    
    public function index() {
        http_response_code(404);
        $datos = [
            'titulo' => 'Página no encontrada - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('error/404', $datos);
    }
    
    public function sin_permiso() {
        http_response_code(403);
        $datos = [
            'titulo' => 'Acceso Denegado - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('error/403', $datos);
    }
}
?>

