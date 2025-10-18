<?php
/**
 * Controlador de Productos (Catálogo público)
 */
class ProductosControlador extends Controlador {
    
    public function index() {
        $productoModelo = $this->cargarModelo('Producto');
        $categoriaModelo = $this->cargarModelo('Categoria');
        
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $productosPorPagina = PRODUCTOS_POR_PAGINA;
        $offset = ($pagina - 1) * $productosPorPagina;
        
        // Obtener filtros
        $filtros = [
            'categoria_id' => $_GET['categoria'] ?? null,
            'genero' => $_GET['genero'] ?? null,
            'marca' => $_GET['marca'] ?? null,
            'precio_min' => $_GET['precio_min'] ?? null,
            'precio_max' => $_GET['precio_max'] ?? null,
            'orden' => $_GET['orden'] ?? 'reciente'
        ];
        
        // Obtener productos
        if (!empty($_GET['buscar'])) {
            $termino = $this->limpiarDatos($_GET['buscar']);
            $productos = $productoModelo->buscar($termino);
        } elseif (array_filter($filtros)) {
            $productos = $productoModelo->filtrar($filtros);
        } else {
            $productos = $productoModelo->obtenerCatalogo($productosPorPagina, $offset);
        }
        
        // Obtener categorías y marcas para filtros
        $categorias = $categoriaModelo->obtenerActivas();
        $marcas = $productoModelo->obtenerMarcas();
        
        $datos = [
            'titulo' => 'Catálogo de Productos - ' . NOMBRE_SITIO,
            'productos' => $productos,
            'categorias' => $categorias,
            'marcas' => $marcas,
            'filtros_activos' => $filtros,
            'pagina_actual' => $pagina
        ];
        
        $this->cargarVista('productos/catalogo', $datos);
    }
    
    public function ver($id) {
        $productoModelo = $this->cargarModelo('Producto');
        $producto = $productoModelo->obtenerPorId($id);
        
        if (!$producto) {
            $this->redirigir('productos');
            return;
        }
        
        // Obtener productos relacionados de la misma categoría
        $productosRelacionados = $productoModelo->obtenerPorCategoria($producto['categoria_id'], 4);
        
        $datos = [
            'titulo' => $producto['nombre'] . ' - ' . NOMBRE_SITIO,
            'producto' => $producto,
            'productos_relacionados' => $productosRelacionados
        ];
        
        $this->cargarVista('productos/detalle', $datos);
    }
    
    public function categoria($id) {
        $productoModelo = $this->cargarModelo('Producto');
        $categoriaModelo = $this->cargarModelo('Categoria');
        
        $categoria = $categoriaModelo->obtenerPorId($id);
        
        if (!$categoria) {
            $this->redirigir('productos');
            return;
        }
        
        $productos = $productoModelo->obtenerPorCategoria($id);
        
        $datos = [
            'titulo' => $categoria['nombre'] . ' - ' . NOMBRE_SITIO,
            'categoria' => $categoria,
            'productos' => $productos
        ];
        
        $this->cargarVista('productos/categoria', $datos);
    }
}
