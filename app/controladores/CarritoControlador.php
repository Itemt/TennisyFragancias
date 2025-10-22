<?php
/**
 * Controlador de Carrito
 */
class CarritoControlador extends Controlador {
    
    public function index() {
        $this->verificarAutenticacion();
        
        $carritoModelo = $this->cargarModelo('Carrito');
        $items = $carritoModelo->obtenerItemsUsuario($_SESSION['usuario_id']);
        $total = $carritoModelo->calcularTotal($_SESSION['usuario_id']);
        
        $datos = [
            'titulo' => 'Carrito de Compras - ' . NOMBRE_SITIO,
            'items' => $items,
            'total' => $total
        ];
        
        $this->cargarVista('carrito/index', $datos);
    }
    
    public function agregar() {
        // Debug: Verificar estado de la sesión
        error_log("DEBUG CARRITO CONTROLADOR: Iniciando método agregar()");
        error_log("DEBUG CARRITO CONTROLADOR: Session ID: " . session_id());
        error_log("DEBUG CARRITO CONTROLADOR: Usuario ID en sesión: " . ($_SESSION['usuario_id'] ?? 'NO DEFINIDO'));
        error_log("DEBUG CARRITO CONTROLADOR: Método de solicitud: " . $_SERVER['REQUEST_METHOD']);
        
        $this->verificarAutenticacion();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $productoId = (int)($_POST['producto_id'] ?? 0);
        $cantidad = (int)($_POST['cantidad'] ?? 1);
        $tallaId = (int)($_POST['talla_id'] ?? 0);
        
        if ($productoId <= 0 || $cantidad <= 0) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Datos inválidos']);
            return;
        }
        
        if ($tallaId <= 0) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Debe seleccionar una talla']);
            return;
        }
        
        // Obtener el producto específico de la variante (producto + talla)
        $productoModelo = $this->cargarModelo('Producto');
        $variante = $productoModelo->obtenerVariantePorTalla($productoId, $tallaId);
        
        if (!$variante) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Variante no encontrada']);
            return;
        }
        
        // Verificar stock de la variante específica
        if ($variante['stock'] < $cantidad) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Stock insuficiente para esta talla']);
            return;
        }
        
        $precio = $variante['precio_oferta'] ?? $variante['precio'];
        $productoVarianteId = $variante['id']; // ID de la variante específica
        
        $carritoModelo = $this->cargarModelo('Carrito');
        
        // Debug: Log de los parámetros
        error_log("DEBUG CARRITO: Usuario ID: " . $_SESSION['usuario_id']);
        error_log("DEBUG CARRITO: Producto Variante ID: " . $productoVarianteId);
        error_log("DEBUG CARRITO: Cantidad: " . $cantidad);
        error_log("DEBUG CARRITO: Precio: " . $precio);
        error_log("DEBUG CARRITO: Talla ID: " . $tallaId);
        
        $resultado = $carritoModelo->agregarProducto($_SESSION['usuario_id'], $productoVarianteId, $cantidad, $precio, $tallaId);
        
        error_log("DEBUG CARRITO: Resultado agregarProducto: " . ($resultado ? 'true' : 'false'));
        
        if ($resultado) {
            $totalItems = $carritoModelo->contarItems($_SESSION['usuario_id']);
            error_log("DEBUG CARRITO: Total items: " . $totalItems);
            $this->enviarJson([
                'exito' => true, 
                'mensaje' => 'Producto agregado al carrito',
                'total_items' => $totalItems
            ]);
        } else {
            error_log("DEBUG CARRITO: Error al agregar producto al carrito");
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al agregar producto']);
        }
    }
    
    public function actualizar() {
        $this->verificarAutenticacion();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $carritoId = (int)($_POST['carrito_id'] ?? 0);
        $cantidad = (int)($_POST['cantidad'] ?? 1);
        
        if ($carritoId <= 0 || $cantidad <= 0) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Datos inválidos']);
            return;
        }
        
        $carritoModelo = $this->cargarModelo('Carrito');
        if ($carritoModelo->actualizarCantidad($carritoId, $cantidad)) {
            $total = $carritoModelo->calcularTotal($_SESSION['usuario_id']);
            $totalItems = $carritoModelo->contarItems($_SESSION['usuario_id']);
            $this->enviarJson([
                'exito' => true, 
                'mensaje' => 'Cantidad actualizada',
                'total' => $total,
                'total_items' => $totalItems
            ]);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al actualizar']);
        }
    }
    
    public function eliminar() {
        $this->verificarAutenticacion();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $carritoId = (int)($_POST['carrito_id'] ?? 0);
        
        $carritoModelo = $this->cargarModelo('Carrito');
        if ($carritoModelo->eliminarProducto($carritoId, $_SESSION['usuario_id'])) {
            $totalItems = $carritoModelo->contarItems($_SESSION['usuario_id']);
            $this->enviarJson([
                'exito' => true, 
                'mensaje' => 'Producto eliminado',
                'total_items' => $totalItems
            ]);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al eliminar']);
        }
    }
    
    public function vaciar() {
        $this->verificarAutenticacion();
        
        $carritoModelo = $this->cargarModelo('Carrito');
        if ($carritoModelo->vaciarCarrito($_SESSION['usuario_id'])) {
            $this->redirigir('carrito');
        }
    }
    
    public function contar() {
        $this->verificarAutenticacion();
        
        $carritoModelo = $this->cargarModelo('Carrito');
        $total = $carritoModelo->contarItems($_SESSION['usuario_id']);
        
        $this->enviarJson(['total' => $total]);
    }
    
    public function checkout() {
        $this->verificarAutenticacion();
        
        $carritoModelo = $this->cargarModelo('Carrito');
        $items = $carritoModelo->obtenerItemsUsuario($_SESSION['usuario_id']);
        
        if (empty($items)) {
            $this->redirigir('carrito');
            return;
        }
        
        // Verificar disponibilidad
        $noDisponibles = $carritoModelo->verificarDisponibilidad($_SESSION['usuario_id']);
        if (!empty($noDisponibles)) {
            $_SESSION['error'] = 'Algunos productos no están disponibles';
            $this->redirigir('carrito');
            return;
        }
        
        // Generar token CSRF
        $_SESSION['csrf_token'] = $this->generarTokenCSRF();
        
        $subtotal = $carritoModelo->calcularTotal($_SESSION['usuario_id']);
        $impuestos = $subtotal * 0.19; // IVA 19%
        $total = $subtotal + $impuestos;
        
        $datos = [
            'titulo' => 'Finalizar Compra - ' . NOMBRE_SITIO,
            'items' => $items,
            'subtotal' => $subtotal,
            'impuestos' => $impuestos,
            'total' => $total
        ];
        
        $this->cargarVista('carrito/checkout', $datos);
    }
    
    public function procesar_pedido() {
        $this->verificarAutenticacion();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('carrito/checkout');
            return;
        }
        
        // Verificar token CSRF
        if (!$this->verificarTokenCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token de seguridad inválido';
            $this->redirigir('carrito/checkout');
            return;
        }
        
        $carritoModelo = $this->cargarModelo('Carrito');
        $items = $carritoModelo->obtenerItemsUsuario($_SESSION['usuario_id']);
        
        if (empty($items)) {
            $this->redirigir('carrito');
            return;
        }
        
        // Calcular totales
        $subtotal = $carritoModelo->calcularTotal($_SESSION['usuario_id']);
        $impuestos = $subtotal * 0.19;
        $total = $subtotal + $impuestos;
        
        // Crear pedido
        $pedidoModelo = $this->cargarModelo('Pedido');
        $datosPedido = [
            'usuario_id' => $_SESSION['usuario_id'],
            'tipo_pedido' => 'online',
            'subtotal' => $subtotal,
            'impuestos' => $impuestos,
            'total' => $total,
            'metodo_pago' => $this->limpiarDatos($_POST['metodo_pago']),
            'direccion_envio' => $this->limpiarDatos($_POST['direccion']),
            'ciudad_envio' => $this->limpiarDatos($_POST['ciudad']),
            'telefono_contacto' => $this->limpiarDatos($_POST['telefono']),
            'notas_pedido' => $this->limpiarDatos($_POST['notas'] ?? '')
        ];
        
        if ($pedidoModelo->crearPedido($datosPedido)) {
            $pedidoId = $pedidoModelo->obtenerUltimoId();
            
            // Agregar detalles del pedido
            $detallePedidoModelo = $this->cargarModelo('DetallePedido');
            foreach ($items as $item) {
                $detallePedidoModelo->agregarDetalle(
                    $pedidoId,
                    $item['producto_id'],
                    $item['precio_unitario'],
                    $item['cantidad']
                );
            }
            
            // Vaciar carrito
            $carritoModelo->vaciarCarrito($_SESSION['usuario_id']);
            
            
            $_SESSION['exito'] = 'Pedido realizado con éxito';
            $this->redirigir('pedidos/ver/' . $pedidoId);
        } else {
            $_SESSION['error'] = 'Error al procesar el pedido';
            $this->redirigir('carrito/checkout');
        }
    }
}
?>
