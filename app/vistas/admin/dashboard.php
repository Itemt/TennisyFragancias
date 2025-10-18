<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid my-4">
    <h1 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard Administrativo</h1>
    
    <!-- Estadísticas Principales -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Ventas Totales</h6>
                            <h3 class="mb-0"><?= Vista::formatearPrecio($estadisticas_pedidos['total_ventas'] ?? 0) ?></h3>
                        </div>
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Pedidos</h6>
                            <h3 class="mb-0"><?= $estadisticas_pedidos['total_pedidos'] ?? 0 ?></h3>
                        </div>
                        <i class="bi bi-box-seam fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Productos</h6>
                            <h3 class="mb-0"><?= $estadisticas_productos['total'] ?? 0 ?></h3>
                        </div>
                        <i class="bi bi-tags fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Clientes</h6>
                            <h3 class="mb-0"><?= $estadisticas_usuarios['clientes'] ?? 0 ?></h3>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Menú Rápido -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <a href="<?= Vista::url('admin/productos') ?>" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam fs-1 text-primario"></i>
                        <h5 class="mt-2">Gestionar Productos</h5>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <a href="<?= Vista::url('admin/categorias') ?>" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-tags fs-1 text-primario"></i>
                        <h5 class="mt-2">Categorías</h5>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <a href="<?= Vista::url('admin/usuarios') ?>" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-people fs-1 text-primario"></i>
                        <h5 class="mt-2">Usuarios</h5>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <a href="<?= Vista::url('admin/actualizar-stock') ?>" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-box-arrow-in-up fs-1 text-primario"></i>
                        <h5 class="mt-2">Actualizar Stock</h5>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <a href="<?= Vista::url('admin/reportes') ?>" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-graph-up fs-1 text-primario"></i>
                        <h5 class="mt-2">Reportes</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="row">
        <!-- Pedidos Recientes -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-primario text-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Pedidos Recientes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nº Pedido</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos_recientes as $pedido): ?>
                                    <tr>
                                        <td><strong><?= Vista::escapar($pedido['numero_pedido']) ?></strong></td>
                                        <td><?= Vista::escapar($pedido['cliente_nombre'] . ' ' . $pedido['cliente_apellido']) ?></td>
                                        <td><?= Vista::formatearPrecio($pedido['total']) ?></td>
                                        <td><?= Vista::obtenerBadgeEstado($pedido['estado']) ?></td>
                                        <td><?= Vista::formatearFecha($pedido['fecha_pedido']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Productos Más Vendidos -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-trophy"></i> Más Vendidos</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($productos_mas_vendidos, 0, 5) as $producto): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <small><?= Vista::escapar($producto['nombre_producto']) ?></small>
                                    <span class="badge bg-primary"><?= $producto['total_vendido'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Stock Bajo -->
            <?php if (!empty($productos_stock_bajo)): ?>
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Stock Bajo</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($productos_stock_bajo, 0, 5) as $producto): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
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

