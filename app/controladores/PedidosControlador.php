<?php
/**
 * Controlador de Pedidos (Cliente)
 */
class PedidosControlador extends Controlador {
    
    public function index() {
        $this->verificarAutenticacion();
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        $pedidos = $pedidoModelo->obtenerPorUsuario($_SESSION['usuario_id']);
        
        $datos = [
            'titulo' => 'Mis Pedidos - ' . NOMBRE_SITIO,
            'pedidos' => $pedidos
        ];
        
        $this->cargarVista('pedidos/index', $datos);
    }
    
    public function ver($id) {
        $this->verificarAutenticacion();
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        $pedido = $pedidoModelo->obtenerConDetalles($id);
        
        // Verificar que el pedido pertenece al usuario
        if (!$pedido || $pedido['usuario_id'] != $_SESSION['usuario_id']) {
            $this->redirigir('pedidos');
            return;
        }
        
        $detallePedidoModelo = $this->cargarModelo('DetallePedido');
        $detalles = $detallePedidoModelo->obtenerPorPedido($id);
        
        $datos = [
            'titulo' => 'Pedido #' . $pedido['numero_pedido'] . ' - ' . NOMBRE_SITIO,
            'pedido' => $pedido,
            'detalles' => $detalles
        ];
        
        $this->cargarVista('pedidos/detalle', $datos);
    }
}
?>

