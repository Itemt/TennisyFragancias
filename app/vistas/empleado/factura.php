<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" id="factura-contenido">
                    <!-- Encabezado de la Factura -->
                    <div class="text-center mb-4">
                        <h2 class="text-primario"><i class="bi bi-shop"></i> Tennis y Fragancias</h2>
                        <p class="mb-0">Barrancabermeja, Santander, Colombia</p>
                        <p class="mb-0">Tel: <?= EMPRESA_TELEFONO ?></p>
                        <p>Email: <?= EMPRESA_EMAIL ?></p>
                        <h4>FACTURA DE VENTA</h4>
                    </div>
                    
                    <!-- Información de la Factura -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <strong>Factura N°:</strong> <?= Vista::escapar($factura['numero_factura']) ?><br>
                            <strong>Fecha:</strong> <?= Vista::formatearFechaHora($factura['fecha_emision']) ?>
                        </div>
                        <div class="col-6 text-end">
                            <strong>Pedido N°:</strong> <?= Vista::escapar($factura['numero_pedido']) ?><br>
                            <strong>Atendió:</strong> <?= Vista::escapar($factura['empleado_nombre'] . ' ' . $factura['empleado_apellido']) ?>
                        </div>
                    </div>
                    
                    <!-- Datos del Cliente -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6>Cliente:</h6>
                            <p class="mb-0">
                                <strong><?= Vista::escapar($factura['cliente_nombre'] . ' ' . $factura['cliente_apellido']) ?></strong><br>
                                Email: <?= Vista::escapar($factura['cliente_email']) ?><br>
                                Teléfono: <?= Vista::escapar($factura['cliente_telefono']) ?><br>
                                <?php if ($factura['cliente_direccion']): ?>
                                    Dirección: <?= Vista::escapar($factura['cliente_direccion']) ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Detalles de la Venta -->
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalles as $detalle): ?>
                                <tr>
                                    <td><?= Vista::escapar($detalle['nombre_producto']) ?></td>
                                    <td class="text-center"><?= $detalle['cantidad'] ?></td>
                                    <td class="text-end"><?= Vista::formatearPrecio($detalle['precio_unitario']) ?></td>
                                    <td class="text-end"><?= Vista::formatearPrecio($detalle['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-end"><?= Vista::formatearPrecio($factura['subtotal']) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>IVA (19%):</strong></td>
                                <td class="text-end"><?= Vista::formatearPrecio($factura['impuestos']) ?></td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="3" class="text-end"><strong class="fs-5">TOTAL:</strong></td>
                                <td class="text-end"><strong class="fs-5"><?= Vista::formatearPrecio($factura['total']) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <!-- Método de Pago -->
                    <div class="alert alert-info mb-4">
                        <strong>Método de Pago:</strong> <?= ucfirst(Vista::escapar($factura['metodo_pago'])) ?>
                    </div>
                    
                    <!-- Nota al Pie -->
                    <div class="text-center mt-4 border-top pt-3">
                        <p class="small mb-0">¡Gracias por su compra!</p>
                        <p class="small text-muted">Esta es una factura de venta. Por favor conserve este documento.</p>
                    </div>
                </div>
                
                <!-- Botones de Acción -->
                <div class="card-footer bg-white border-0 no-print">
                    <div class="d-flex gap-2">
                        <button onclick="imprimirFactura()" class="btn btn-primary">
                            <i class="bi bi-printer"></i> Imprimir
                        </button>
                        <a href="<?= Vista::url('empleado/panel') ?>" class="btn btn-success">
                            <i class="bi bi-arrow-left"></i> Volver al Panel
                        </a>
                        <a href="<?= Vista::url('empleado/ventas') ?>" class="btn btn-outline-secondary">
                            Nueva Venta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function imprimirFactura() {
    window.print();
}
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

