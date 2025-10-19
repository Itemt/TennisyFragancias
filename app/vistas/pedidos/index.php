<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-4">Mis Pedidos</h1>
    
    <?php if (!empty($pedidos)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nº Pedido</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><strong><?= Vista::escapar($pedido['numero_pedido'] ?? 'PED-' . str_pad($pedido['id'], 3, '0', STR_PAD_LEFT)) ?></strong></td>
                            <td><?= Vista::formatearFecha($pedido['fecha_pedido']) ?></td>
                            <td><?= Vista::formatearPrecio($pedido['total']) ?></td>
                            <td><?= Vista::obtenerBadgeEstado($pedido['estado']) ?></td>
                            <td>
                                <?php if ($pedido['tipo_pedido'] === 'online'): ?>
                                    <span class="badge bg-info">Online</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Presencial</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= Vista::url('pedidos/ver/' . $pedido['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
            <h4>No tienes pedidos</h4>
            <p>Realiza tu primera compra y aparecerá aquí</p>
            <a href="<?= Vista::url('productos') ?>" class="btn btn-primario">Ver Productos</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

