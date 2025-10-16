<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Bienvenido a <span class="text-primario">Tennis y Fragancias</span></h1>
                <p class="lead">Los mejores productos en calzado deportivo y fragancias en Barrancabermeja</p>
                <a href="<?= Vista::url('productos') ?>" class="btn btn-primario btn-lg">
                    <i class="bi bi-shop"></i> Ver Catálogo
                </a>
            </div>
            <div class="col-md-6">
                <img src="<?= Vista::urlPublica('imagenes/hero-image.jpg') ?>" alt="Tennis y Fragancias" class="img-fluid rounded" onerror="this.src='https://via.placeholder.com/600x400?text=Tennis+y+Fragancias'">
            </div>
        </div>
    </div>
</section>

<!-- Categorías -->
<?php if (!empty($categorias)): ?>
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Explora Nuestras Categorías</h2>
        <div class="row g-4">
            <?php foreach ($categorias as $categoria): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?= Vista::url('productos/categoria/' . $categoria['id']) ?>" class="text-decoration-none">
                        <div class="card h-100 text-center producto-card">
                            <?php if ($categoria['imagen']): ?>
                                <img src="<?= Vista::urlPublica('imagenes/categorias/' . $categoria['imagen']) ?>" class="card-img-top" alt="<?= Vista::escapar($categoria['nombre']) ?>">
                            <?php else: ?>
                                <div class="bg-light" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-tag fs-1 text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= Vista::escapar($categoria['nombre']) ?></h5>
                                <p class="text-muted small"><?= $categoria['total_productos'] ?> productos</p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Productos Destacados -->
<?php if (!empty($productos_destacados)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Productos Destacados</h2>
        <div class="row g-4">
            <?php foreach ($productos_destacados as $producto): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 producto-card">
                        <?php if ($producto['imagen_principal']): ?>
                            <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" class="card-img-top" alt="<?= Vista::escapar($producto['nombre']) ?>" style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image fs-1 text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= Vista::escapar($producto['nombre']) ?></h5>
                            <p class="text-muted small"><?= Vista::escapar($producto['categoria_nombre']) ?></p>
                            <div class="mb-2">
                                <?php if ($producto['precio_oferta']): ?>
                                    <span class="precio-oferta fs-5"><?= Vista::formatearPrecio($producto['precio_oferta']) ?></span>
                                    <span class="precio-original small"><?= Vista::formatearPrecio($producto['precio']) ?></span>
                                <?php else: ?>
                                    <span class="fs-5 fw-bold"><?= Vista::formatearPrecio($producto['precio']) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($producto['stock'] > 0): ?>
                                <span class="badge bg-success small">Disponible</span>
                            <?php else: ?>
                                <span class="badge bg-danger small">Agotado</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="<?= Vista::url('productos/ver/' . $producto['id']) ?>" class="btn btn-primario w-100">
                                <i class="bi bi-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= Vista::url('productos') ?>" class="btn btn-outline-dark btn-lg">Ver Todos los Productos</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Características -->
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="p-3">
                    <i class="bi bi-truck fs-1 text-primario"></i>
                    <h5 class="mt-3">Envíos a Todo el País</h5>
                    <p class="text-muted small">Entrega rápida y segura</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <i class="bi bi-shield-check fs-1 text-primario"></i>
                    <h5 class="mt-3">Compra Segura</h5>
                    <p class="text-muted small">Protección de datos garantizada</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <i class="bi bi-arrow-clockwise fs-1 text-primario"></i>
                    <h5 class="mt-3">Cambios y Devoluciones</h5>
                    <p class="text-muted small">30 días para cambios</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <i class="bi bi-headset fs-1 text-primario"></i>
                    <h5 class="mt-3">Atención al Cliente</h5>
                    <p class="text-muted small">Estamos para ayudarte</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

