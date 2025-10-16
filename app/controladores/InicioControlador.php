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
}
?>

