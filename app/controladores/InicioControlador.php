<?php
/**
 * Controlador de Inicio
 */
class InicioControlador extends Controlador {
    
    public function index() {
        $productoModelo = $this->cargarModelo('Producto');
        $categoriaModelo = $this->cargarModelo('Categoria');
        
        // Obtener productos destacados
        $productosDestacados = $productoModelo->obtenerDestacados(8);
        
        // Obtener categorías activas
        $categorias = $categoriaModelo->obtenerConContador();
        
        $datos = [
            'titulo' => 'Inicio - ' . NOMBRE_SITIO,
            'productos_destacados' => $productosDestacados,
            'categorias' => $categorias
        ];
        
        $this->cargarVista('inicio/index', $datos);
    }
    
    public function sobre_nosotros() {
        $datos = [
            'titulo' => 'Sobre Nosotros - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('inicio/sobre_nosotros', $datos);
    }
    
    public function contacto() {
        $datos = [
            'titulo' => 'Contacto - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('inicio/contacto', $datos);
    }
    
    public function privacidad() {
        $datos = [
            'titulo' => 'Política de Privacidad - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('inicio/privacidad', $datos);
    }
    
    public function terminos() {
        $datos = [
            'titulo' => 'Términos y Condiciones - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('inicio/terminos', $datos);
    }
    
    public function devoluciones() {
        $datos = [
            'titulo' => 'Cambios y Devoluciones - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('inicio/devoluciones', $datos);
    }
    
    public function envios() {
        $datos = [
            'titulo' => 'Envíos y Entregas - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('inicio/envios', $datos);
    }
    
    public function faq() {
        $datos = [
            'titulo' => 'Preguntas Frecuentes - ' . NOMBRE_SITIO
        ];
        $this->cargarVista('inicio/faq', $datos);
    }
}
?>

