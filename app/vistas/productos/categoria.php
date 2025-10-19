<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><?= Vista::escapar($categoria['nombre'] ?? 'Categoría') ?></h1>
        <a href="<?= Vista::url('productos') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-grid"></i> Ver todo el catálogo
        </a>
    </div>

    <?php if (!empty($productos)): ?>
        <div class="row g-4">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4">
                    <a href="<?= Vista::url('productos/ver/' . $producto['id']) ?>" class="text-decoration-none text-dark d-block">
                    <div class="card h-100 producto-card">
                        <?php if ($producto['imagen_principal']): ?>
                            <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                                 class="card-img-top" alt="<?= Vista::escapar($producto['nombre']) ?>" 
                                 style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image fs-1 text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= Vista::escapar($producto['nombre']) ?></h5>
                            <div class="mb-2">
                                <?php if ($producto['precio_oferta']): ?>
                                    <span class="precio-oferta fs-5"><?= Vista::formatearPrecio($producto['precio_oferta']) ?></span>
                                    <span class="precio-original small"><?= Vista::formatearPrecio($producto['precio']) ?></span>
                                <?php else: ?>
                                    <span class="fs-5 fw-bold"><?= Vista::formatearPrecio($producto['precio']) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($producto['stock_total'] > 0): ?>
                                <span class="badge bg-success small">Disponible</span>
                            <?php else: ?>
                                <span class="badge bg-danger small">Agotado</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="btn btn-primario w-100">
                                <i class="bi bi-eye"></i> Ver Detalles
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No hay productos disponibles en esta categoría.
        </div>
    <?php endif; ?>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>


