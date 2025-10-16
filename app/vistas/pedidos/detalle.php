<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pedido #<?= Vista::escapar($pedido['numero_pedido']) ?></h1>
        <a href="<?= Vista::url('pedidos') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Información del Pedido -->
            <div class="card mb-4">
                <div class="card-header bg-primario text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Fecha del Pedido:</strong><br>
                            <?= Vista::formatearFechaHora($pedido['fecha_pedido']) ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Estado:</strong><br>
                            <?= Vista::obtenerBadgeEstado($pedido['estado']) ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Método de Pago:</strong><br>
                            <?= ucfirst(Vista::escapar($pedido['metodo_pago'])) ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Tipo de Pedido:</strong><br>
                            <?= ucfirst(Vista::escapar($pedido['tipo_pedido'])) ?>
                        </div>
                        
                        <?php if ($pedido['fecha_envio']): ?>
                        <div class="col-md-6 mb-3">
                            <strong>Fecha de Envío:</strong><br>
                            <?= Vista::formatearFechaHora($pedido['fecha_envio']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($pedido['fecha_entrega']): ?>
                        <div class="col-md-6 mb-3">
                            <strong>Fecha de Entrega:</strong><br>
                            <?= Vista::formatearFechaHora($pedido['fecha_entrega']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Dirección de Envío -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Dirección de Envío</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><?= Vista::escapar($pedido['direccion_envio']) ?></p>
                    <p class="mb-1"><?= Vista::escapar($pedido['ciudad_envio']) ?></p>
                    <p class="mb-0"><strong>Teléfono:</strong> <?= Vista::escapar($pedido['telefono_contacto']) ?></p>
                </div>
            </div>
            
            <!-- Productos -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Productos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles as $detalle): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if ($detalle['imagen_principal']): ?>
                                                    <img src="<?= Vista::urlPublica('imagenes/productos/' . $detalle['imagen_principal']) ?>" 
                                                         alt="<?= Vista::escapar($detalle['nombre_producto']) ?>" 
                                                         style="width: 50px; height: 50px; object-fit: cover;" 
                                                         class="me-2">
                                                <?php endif; ?>
                                                <?= Vista::escapar($detalle['nombre_producto']) ?>
                                            </div>
                                        </td>
                                        <td><?= Vista::formatearPrecio($detalle['precio_unitario']) ?></td>
                                        <td><?= $detalle['cantidad'] ?></td>
                                        <td><?= Vista::formatearPrecio($detalle['subtotal']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Resumen -->
            <div class="card">
                <div class="card-header bg-secundario text-white">
                    <h5 class="mb-0"><i class="bi bi-calculator"></i> Resumen</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span><?= Vista::formatearPrecio($pedido['subtotal']) ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>IVA:</span>
                        <span><?= Vista::formatearPrecio($pedido['impuestos']) ?></span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <strong class="fs-5">Total:</strong>
                        <strong class="fs-4 text-primario"><?= Vista::formatearPrecio($pedido['total']) ?></strong>
                    </div>
                </div>
            </div>
            
            <!-- Seguimiento -->
            <?php if ($pedido['tipo_pedido'] === 'online'): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Seguimiento</h5>
                </div>
                <div class="card-body">
                    <div class="position-relative">
                        <?php
                        $estados = ['pendiente', 'enviado', 'entregado'];
                        $estadoActual = array_search($pedido['estado'], $estados);
                        ?>
                        
                        <?php foreach ($estados as $index => $estado): ?>
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <?php if ($index <= $estadoActual): ?>
                                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                    <?php else: ?>
                                        <i class="bi bi-circle text-muted fs-4"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <strong><?= ucfirst($estado) ?></strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

