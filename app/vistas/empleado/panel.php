<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid my-4">
    <h1 class="mb-4"><i class="bi bi-briefcase"></i> Panel de Empleado</h1>
    
    <!-- Menú Rápido -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="<?= Vista::url('empleado/ventas') ?>" class="text-decoration-none">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-plus fs-1"></i>
                        <h5 class="mt-2">Registrar Venta</h5>
                        <p class="small mb-0">Venta presencial en tienda</p>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-4">
            <a href="<?= Vista::url('empleado/pedidos') ?>" class="text-decoration-none">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam fs-1"></i>
                        <h5 class="mt-2">Gestionar Pedidos</h5>
                        <p class="small mb-0">Ver y actualizar pedidos</p>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-4">
            <a href="<?= Vista::url('productos') ?>" class="text-decoration-none">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-search fs-1"></i>
                        <h5 class="mt-2">Consultar Productos</h5>
                        <p class="small mb-0">Ver catálogo y stock</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="row">
        <!-- Pedidos Asignados -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-primario text-white">
                    <h5 class="mb-0"><i class="bi bi-person-check"></i> Mis Pedidos Asignados</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($pedidos_asignados)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº Pedido</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedidos_asignados as $pedido): ?>
                                        <tr>
                                            <td><strong><?= Vista::escapar($pedido['numero_pedido']) ?></strong></td>
                                            <td><?= Vista::escapar($pedido['cliente_nombre'] . ' ' . $pedido['cliente_apellido']) ?></td>
                                            <td><?= Vista::formatearPrecio($pedido['total']) ?></td>
                                            <td><?= Vista::obtenerBadgeEstado($pedido['estado']) ?></td>
                                            <td>
                                                <a href="<?= Vista::url('empleado/ver_pedido/' . $pedido['id']) ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center mb-0">No tienes pedidos asignados</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Pedidos Pendientes -->
            <div class="card mb-3">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="bi bi-clock"></i> Pedidos Pendientes</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($pedidos_pendientes)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach (array_slice($pedidos_pendientes, 0, 5) as $pedido): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small><strong><?= Vista::escapar($pedido['numero_pedido']) ?></strong></small><br>
                                            <small class="text-muted"><?= Vista::escapar($pedido['cliente_nombre']) ?></small>
                                        </div>
                                        <a href="<?= Vista::url('empleado/ver_pedido/' . $pedido['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small mb-0">No hay pedidos pendientes</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Productos con Stock Bajo -->
            <?php if (!empty($productos_stock_bajo)): ?>
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Alerta: Stock Bajo</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($productos_stock_bajo, 0, 5) as $producto): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <small><?= Vista::escapar($producto['nombre']) ?></small>
                                    <span class="badge bg-danger"><?= $producto['stock'] ?></span>
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

