<?php
/**
 * Controlador de Pagos con MercadoPago
 */
require_once APP_PATH . '/helpers/MercadoPagoHelper.php';

class PagoControlador extends Controlador {
    
    public function procesar() {
        $this->verificarAutenticacion();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('carrito');
            return;
        }
        
        $pedidoId = (int)($_POST['pedido_id'] ?? 0);
        
        if ($pedidoId <= 0) {
            $_SESSION['error'] = 'Pedido inválido';
            $this->redirigir('carrito');
            return;
        }
        
        // Obtener pedido
        $pedidoModelo = $this->cargarModelo('Pedido');
        $pedido = $pedidoModelo->obtenerConDetalles($pedidoId);
        
        if (!$pedido || $pedido['usuario_id'] != $_SESSION['usuario_id']) {
            $_SESSION['error'] = 'Pedido no encontrado';
            $this->redirigir('pedidos');
            return;
        }
        
        // Obtener detalles del pedido
        $detallePedidoModelo = $this->cargarModelo('DetallePedido');
        $detalles = $detallePedidoModelo->obtenerPorPedido($pedidoId);
        
        // Preparar datos para MercadoPago
        $items = [];
        foreach ($detalles as $detalle) {
            $items[] = [
                'nombre' => $detalle['nombre_producto'],
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['precio_unitario']
            ];
        }
        
        $datosPago = [
            'pedido_id' => $pedidoId,
            'items' => $items,
            'nombre_cliente' => $pedido['cliente_nombre'] . ' ' . $pedido['cliente_apellido'],
            'email_cliente' => $pedido['cliente_email'],
            'telefono_cliente' => $pedido['telefono_contacto'],
            'direccion' => $pedido['direccion_envio'],
            'codigo_postal' => ''
        ];
        
        // Crear preferencia en MercadoPago
        $mercadopago = new MercadoPagoHelper();
        $preferencia = $mercadopago->crearPreferencia($datosPago);
        
        if ($preferencia && isset($preferencia['init_point'])) {
            // Actualizar pedido con ID de preferencia
            $pedidoModelo->actualizar($pedidoId, [
                'mercadopago_payment_id' => $preferencia['id']
            ]);
            
            // Redirigir a MercadoPago
            header('Location: ' . $preferencia['init_point']);
            exit();
        } else {
            $_SESSION['error'] = 'Error al procesar el pago';
            $this->redirigir('pedidos/ver/' . $pedidoId);
        }
    }
    
    public function exito() {
        $this->verificarAutenticacion();
        
        $paymentId = $_GET['payment_id'] ?? '';
        $externalReference = $_GET['external_reference'] ?? '';
        
        if ($paymentId && $externalReference) {
            // Actualizar estado del pedido
            $pedidoModelo = $this->cargarModelo('Pedido');
            $pedidoModelo->actualizar($externalReference, [
                'mercadopago_payment_id' => $paymentId,
                'mercadopago_status' => 'approved',
                'estado' => 'enviado'
            ]);
            
            $_SESSION['exito'] = 'Pago realizado con éxito';
        }
        
        $this->redirigir('pedidos/ver/' . $externalReference);
    }
    
    public function fallo() {
        $this->verificarAutenticacion();
        $_SESSION['error'] = 'El pago no pudo ser procesado';
        $this->redirigir('pedidos');
    }
    
    public function pendiente() {
        $this->verificarAutenticacion();
        $_SESSION['info'] = 'Pago pendiente de confirmación';
        $this->redirigir('pedidos');
    }
}
?>

