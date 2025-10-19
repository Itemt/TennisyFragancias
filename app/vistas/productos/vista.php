<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= Vista::url('') ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= Vista::url('productos') ?>">Productos</a></li>
            <li class="breadcrumb-item"><a href="<?= Vista::url('productos/categoria/' . $producto['categoria_id']) ?>"><?= Vista::escapar($producto['categoria_nombre']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= Vista::escapar($producto['nombre']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <?php if ($producto['imagen_principal']): ?>
                        <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                             alt="<?= Vista::escapar($producto['nombre']) ?>" 
                             class="img-fluid w-100" 
                             style="max-height: 500px; object-fit: cover;">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 400px;">
                            <div class="text-center text-muted">
                                <i class="bi bi-image" style="font-size: 4rem;"></i>
                                <p class="mt-2">Sin imagen</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3"><?= Vista::escapar($producto['nombre']) ?></h1>
                    
                    <!-- Precio -->
                    <div class="mb-4">
                        <?php if ($producto['precio_oferta'] && $producto['precio_oferta'] < $producto['precio']): ?>
                            <div class="d-flex align-items-center gap-3">
                                <span class="h4 text-success mb-0"><?= Vista::formatearPrecio($producto['precio_oferta']) ?></span>
                                <span class="text-decoration-line-through text-muted"><?= Vista::formatearPrecio($producto['precio']) ?></span>
                                <span class="badge bg-danger">Oferta</span>
                            </div>
                        <?php else: ?>
                            <span class="h4 text-primary"><?= Vista::formatearPrecio($producto['precio']) ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <h5>Descripción</h5>
                        <p class="text-muted"><?= nl2br(Vista::escapar($producto['descripcion'])) ?></p>
                    </div>

                    <!-- Información detallada -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Categoría</h6>
                            <p class="mb-3"><?= Vista::escapar($producto['categoria_nombre']) ?></p>
                        </div>
                        
                        <?php if ($producto['marca_nombre']): ?>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Marca</h6>
                            <p class="mb-3"><?= Vista::escapar($producto['marca_nombre']) ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Género</h6>
                            <p class="mb-3"><?= ucfirst(Vista::escapar($producto['genero_nombre'] ?? 'No especificado')) ?></p>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">SKU</h6>
                            <p class="mb-3"><code><?= Vista::escapar($producto['codigo_sku']) ?></code></p>
                        </div>
                    </div>

                    <!-- Stock total -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-<?= $producto['stock_total'] > 0 ? 'success' : 'danger' ?> fs-6">
                                Stock Total: <?= $producto['stock_total'] ?>
                            </span>
                            <?php if ($producto['stock_total'] <= 0): ?>
                                <span class="text-danger small">Agotado</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Botón para ver detalle con tallas -->
                    <div class="d-grid gap-2">
                        <a href="<?= Vista::url('productos/ver/' . $producto['id']) ?>" class="btn btn-primary btn-lg">
                            <i class="bi bi-eye"></i> Ver Detalle con Tallas
                        </a>
                        <a href="<?= Vista::url('productos') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver al Catálogo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información Adicional</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Estado del Producto</h6>
                            <p class="mb-3">
                                <span class="badge bg-<?= $producto['estado'] === 'activo' ? 'success' : ($producto['estado'] === 'inactivo' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($producto['estado']) ?>
                                </span>
                            </p>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Producto Destacado</h6>
                            <p class="mb-3">
                                <?php if ($producto['destacado']): ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-star-fill"></i> Destacado
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">No destacado</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Stock Mínimo</h6>
                            <p class="mb-3"><?= $producto['stock_minimo'] ?> unidades</p>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Fecha de Creación</h6>
                            <p class="mb-3"><?= date('d/m/Y H:i', strtotime($producto['fecha_creacion'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Variantes del producto (si las hay) -->
    <?php if (!empty($producto['variantes']) && count($producto['variantes']) > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Variantes Disponibles</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Talla</th>
                                    <th>Color</th>
                                    <th>SKU</th>
                                    <th class="text-end">Stock</th>
                                    <th class="text-end">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($producto['variantes'] as $variante): ?>
                                <tr>
                                    <td>
                                        <strong><?= Vista::escapar($variante['talla_nombre'] ?? 'Sin talla') ?></strong>
                                    </td>
                                    <td><?= Vista::escapar($variante['color_nombre'] ?? 'Sin color') ?></td>
                                    <td><code><?= Vista::escapar($variante['codigo_sku']) ?></code></td>
                                    <td class="text-end">
                                        <span class="badge bg-<?= $variante['stock'] > 0 ? 'success' : 'danger' ?>">
                                            <?= $variante['stock'] ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <?php if ($variante['precio_oferta'] && $variante['precio_oferta'] < $variante['precio']): ?>
                                            <span class="text-success fw-bold"><?= Vista::formatearPrecio($variante['precio_oferta']) ?></span>
                                            <br><small class="text-decoration-line-through text-muted"><?= Vista::formatearPrecio($variante['precio']) ?></small>
                                        <?php else: ?>
                                            <span><?= Vista::formatearPrecio($variante['precio']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Productos relacionados -->
    <?php if (!empty($productos_relacionados)): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-4">Productos Relacionados</h4>
            <div class="row">
                <?php foreach ($productos_relacionados as $productoRelacionado): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <?php if ($productoRelacionado['imagen_principal']): ?>
                            <img src="<?= Vista::urlPublica('imagenes/productos/' . $productoRelacionado['imagen_principal']) ?>" 
                                 alt="<?= Vista::escapar($productoRelacionado['nombre']) ?>" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= Vista::escapar($productoRelacionado['nombre']) ?></h6>
                            <p class="card-text text-muted small">
                                <?= Vista::escapar($productoRelacionado['marca_nombre'] ?? '') ?>
                            </p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <?php if ($productoRelacionado['precio_oferta'] && $productoRelacionado['precio_oferta'] < $productoRelacionado['precio']): ?>
                                        <span class="text-success fw-bold"><?= Vista::formatearPrecio($productoRelacionado['precio_oferta']) ?></span>
                                        <small class="text-decoration-line-through text-muted"><?= Vista::formatearPrecio($productoRelacionado['precio']) ?></small>
                                    <?php else: ?>
                                        <span class="fw-bold"><?= Vista::formatearPrecio($productoRelacionado['precio']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="<?= Vista::url('productos/vista/' . $productoRelacionado['id']) ?>" class="btn btn-outline-primary btn-sm">
                                        Ver Vista Completa
                                    </a>
                                    <a href="<?= Vista::url('productos/ver/' . $productoRelacionado['id']) ?>" class="btn btn-primary btn-sm">
                                        Ver con Tallas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
