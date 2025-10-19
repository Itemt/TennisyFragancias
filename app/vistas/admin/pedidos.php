<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>
        
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-receipt"></i> Gestión de Pedidos</h1>
            </div>

            <!-- Tabla de pedidos -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Número</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos)): ?>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td><?= $pedido['id'] ?></td>
                                    <td><strong><?= $pedido['numero_pedido'] ?? 'PED-' . str_pad($pedido['id'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                                    <td><?= Vista::escapar($pedido['usuario_nombre'] ?? 'N/A') ?></td>
                                    <td><?= Vista::formatearPrecio($pedido['total']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $pedido['estado'] === 'entregado' ? 'success' : ($pedido['estado'] === 'pendiente' ? 'warning' : 'info') ?>">
                                            <?= ucfirst($pedido['estado']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></td>
                                    <td>
                                        <a href="<?= Vista::url('pedidos/detalle/' . $pedido['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1"></i><br>
                                    No hay pedidos registrados
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
