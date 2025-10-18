<?php
/**
 * Controlador de Empleado
 */
class EmpleadoControlador extends Controlador {
    
    public function panel() {
        $this->verificarRol([ROL_EMPLEADO, ROL_ADMINISTRADOR]);
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        $productoModelo = $this->cargarModelo('Producto');
        
        // Obtener pedidos asignados al empleado
        $pedidosAsignados = $pedidoModelo->obtenerPorEmpleado($_SESSION['usuario_id']);
        
        // Obtener pedidos pendientes sin asignar
        $pedidosPendientes = $pedidoModelo->obtenerTodosConCliente(['estado' => 'pendiente']);
        
        // Productos con stock bajo
        $productosStockBajo = $productoModelo->obtenerStockBajo();
        
        $datos = [
            'titulo' => 'Panel de Empleado - ' . NOMBRE_SITIO,
            'pedidos_asignados' => $pedidosAsignados,
            'pedidos_pendientes' => $pedidosPendientes,
            'productos_stock_bajo' => $productosStockBajo
        ];
        
        $this->cargarVista('empleado/panel', $datos);
    }
    
    public function ventas() {
        $this->verificarRol([ROL_EMPLEADO, ROL_ADMINISTRADOR]);
        
        $productoModelo = $this->cargarModelo('Producto');
        $categoriaModelo = $this->cargarModelo('Categoria');
        
        $productos = $productoModelo->obtenerCatalogo();
        $categorias = $categoriaModelo->obtenerActivas();
        
        $datos = [
            'titulo' => 'Registrar Venta Presencial - ' . NOMBRE_SITIO,
            'productos' => $productos,
            'categorias' => $categorias
        ];
        
        $this->cargarVista('empleado/ventas', $datos);
    }
    
    public function procesar_venta() {
        $this->verificarRol([ROL_EMPLEADO, ROL_ADMINISTRADOR]);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('empleado/ventas');
            return;
        }
        
        $items = json_decode($_POST['items'], true);
        
        if (empty($items)) {
            $_SESSION['error'] = 'No hay productos en la venta';
            $this->redirigir('empleado/ventas');
            return;
        }
        
        // Calcular totales
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        $impuestos = $subtotal * 0.19;
        $total = $subtotal + $impuestos;
        
        // Datos del cliente
        $clienteNombre = $this->limpiarDatos($_POST['cliente_nombre']);
        $clienteTelefono = $this->limpiarDatos($_POST['cliente_telefono']);
        $clienteEmail = $this->limpiarDatos($_POST['cliente_email'] ?? '');
        
        // Buscar o crear cliente
        $usuarioModelo = $this->cargarModelo('Usuario');
        $cliente = null;
        
        if (!empty($clienteEmail)) {
            $cliente = $usuarioModelo->obtenerPorEmail($clienteEmail);
        }
        
        if (!$cliente) {
            // Crear cliente temporal
            $datosCliente = [
                'nombre' => $clienteNombre,
                'apellido' => '',
                'email' => $clienteEmail ?: 'cliente_' . time() . '@temporal.com',
                'telefono' => $clienteTelefono,
                'password' => bin2hex(random_bytes(16)),
                'rol' => ROL_CLIENTE
            ];
            $usuarioModelo->registrar($datosCliente);
            $clienteId = $usuarioModelo->obtenerUltimoId();
        } else {
            $clienteId = $cliente['id'];
        }
        
        // Crear pedido
        $pedidoModelo = $this->cargarModelo('Pedido');
        $datosPedido = [
            'usuario_id' => $clienteId,
            'empleado_id' => $_SESSION['usuario_id'],
            'tipo_pedido' => 'presencial',
            'subtotal' => $subtotal,
            'impuestos' => $impuestos,
            'total' => $total,
            'metodo_pago' => $this->limpiarDatos($_POST['metodo_pago']),
            'estado' => 'entregado', // Venta presencial se entrega inmediatamente
            'direccion_envio' => 'Tienda física - Barrancabermeja',
            'ciudad_envio' => 'Barrancabermeja',
            'telefono_contacto' => $clienteTelefono,
            'notas_pedido' => 'Venta presencial'
        ];
        
        if ($pedidoModelo->crearPedido($datosPedido)) {
            $pedidoId = $pedidoModelo->obtenerUltimoId();
            
            // Agregar detalles
            $detallePedidoModelo = $this->cargarModelo('DetallePedido');
            foreach ($items as $item) {
                $detallePedidoModelo->agregarDetalle(
                    $pedidoId,
                    $item['id'],
                    $item['nombre'],
                    $item['precio'],
                    $item['cantidad']
                );
            }
            
            // Generar factura
            $facturaModelo = $this->cargarModelo('Factura');
            $pedido = $pedidoModelo->obtenerPorId($pedidoId);
            $numeroFactura = $facturaModelo->crearDesdePedido($pedido, $_SESSION['usuario_id']);
            
            $_SESSION['exito'] = 'Venta registrada correctamente';
            $this->redirigir('empleado/factura/' . $numeroFactura);
        } else {
            $_SESSION['error'] = 'Error al registrar la venta';
            $this->redirigir('empleado/ventas');
        }
    }
    
    public function pedidos() {
        $this->verificarRol([ROL_EMPLEADO, ROL_ADMINISTRADOR]);
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        
        $filtros = [];
        if (isset($_GET['estado'])) {
            $filtros['estado'] = $_GET['estado'];
        }
        
        $pedidos = $pedidoModelo->obtenerTodosConCliente($filtros);
        
        $datos = [
            'titulo' => 'Gestión de Pedidos - ' . NOMBRE_SITIO,
            'pedidos' => $pedidos,
            'filtro_estado' => $_GET['estado'] ?? 'todos'
        ];
        
        $this->cargarVista('empleado/pedidos', $datos);
    }
    
    public function ver_pedido($id) {
        $this->verificarRol([ROL_EMPLEADO, ROL_ADMINISTRADOR]);
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        $pedido = $pedidoModelo->obtenerConDetalles($id);
        
        if (!$pedido) {
            $this->redirigir('empleado/pedidos');
            return;
        }
        
        $detallePedidoModelo = $this->cargarModelo('DetallePedido');
        $detalles = $detallePedidoModelo->obtenerPorPedido($id);
        
        $datos = [
            'titulo' => 'Pedido #' . $pedido['numero_pedido'] . ' - ' . NOMBRE_SITIO,
            'pedido' => $pedido,
            'detalles' => $detalles
        ];
        
        $this->cargarVista('empleado/ver_pedido', $datos);
    }
    
    public function actualizar_estado_pedido() {
        $this->verificarRol([ROL_EMPLEADO, ROL_ADMINISTRADOR]);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $pedidoId = (int)($_POST['pedido_id'] ?? 0);
        $estadoNuevo = $this->limpiarDatos($_POST['estado'] ?? '');
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        if ($pedidoModelo->actualizarEstado($pedidoId, $estadoNuevo)) {
            $this->enviarJson(['exito' => true, 'mensaje' => 'Estado actualizado']);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al actualizar']);
        }
    }
    
    public function factura($numeroFactura) {
        $this->verificarRol([ROL_EMPLEADO, ROL_ADMINISTRADOR]);
        
        $facturaModelo = $this->cargarModelo('Factura');
        $factura = $facturaModelo->obtenerPorNumero($numeroFactura);
        
        if (!$factura) {
            $this->redirigir('empleado/panel');
            return;
        }
        
        $detallePedidoModelo = $this->cargarModelo('DetallePedido');
        $detalles = $detallePedidoModelo->obtenerPorPedido($factura['pedido_id']);
        
        $datos = [
            'titulo' => 'Factura #' . $numeroFactura . ' - ' . NOMBRE_SITIO,
            'factura' => $factura,
            'detalles' => $detalles
        ];
        
        $this->cargarVista('empleado/factura', $datos);
    }
}
