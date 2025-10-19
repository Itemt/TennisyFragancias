<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-eye"></i> Vista Completa del Producto</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/productos') ?>" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Volver a Productos
                    </a>
                    <a href="<?= Vista::url('admin/producto-editar/' . $producto['id']) ?>" class="btn btn-warning me-2">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="<?= Vista::url('productos/ver/' . $producto['id']) ?>" class="btn btn-info" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> Ver Público
                    </a>
                </div>
            </div>

            <!-- Información del producto -->
            <div class="row">
                <!-- Imagen del producto -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Imagen del Producto</h5>
                        </div>
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

                <!-- Información básica -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Información Básica</h5>
                        </div>
                        <div class="card-body">
                            <h3 class="h4 mb-3"><?= Vista::escapar($producto['nombre']) ?></h3>
                            
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
                                <h6>Descripción</h6>
                                <p class="text-muted"><?= nl2br(Vista::escapar($producto['descripcion'])) ?></p>
                            </div>

                            <!-- Información detallada -->
                            <div class="row">
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
                        </div>
                    </div>

                    <!-- Stock y estado -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Stock y Estado</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Stock Total</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-<?= $producto['stock_total'] > 0 ? 'success' : 'danger' ?> fs-6">
                                            <?= $producto['stock_total'] ?>
                                        </span>
                                        <?php if ($producto['stock_total'] <= 0): ?>
                                            <span class="text-danger small">Agotado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6>Estado</h6>
                                    <span class="badge bg-<?= $producto['estado'] === 'activo' ? 'success' : ($producto['estado'] === 'inactivo' ? 'warning' : 'danger') ?>">
                                        <?= ucfirst($producto['estado']) ?>
                                    </span>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6>Stock Mínimo</h6>
                                    <p class="mb-0"><?= $producto['stock_minimo'] ?> unidades</p>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6>Producto Destacado</h6>
                                    <?php if ($producto['destacado']): ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star-fill"></i> Destacado
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">No destacado</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variantes del producto -->
            <?php if (!empty($producto['variantes']) && count($producto['variantes']) > 1): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Variantes del Producto</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Talla</th>
                                            <th>Color</th>
                                            <th>SKU</th>
                                            <th class="text-end">Stock</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-end">Precio Oferta</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($producto['variantes'] as $variante): ?>
                                        <tr>
                                            <td><code><?= $variante['id'] ?></code></td>
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
                                            <td class="text-end"><?= Vista::formatearPrecio($variante['precio']) ?></td>
                                            <td class="text-end">
                                                <?php if ($variante['precio_oferta'] && $variante['precio_oferta'] < $variante['precio']): ?>
                                                    <span class="text-success fw-bold"><?= Vista::formatearPrecio($variante['precio_oferta']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $variante['estado'] === 'activo' ? 'success' : ($variante['estado'] === 'inactivo' ? 'warning' : 'danger') ?>">
                                                    <?= ucfirst($variante['estado']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= Vista::url('admin/producto-editar/' . $variante['id']) ?>" 
                                                       class="btn btn-warning btn-sm" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= Vista::url('admin/actualizar-stock') ?>" 
                                                       class="btn btn-info btn-sm" title="Actualizar Stock">
                                                        <i class="bi bi-box-arrow-in-up"></i>
                                                    </a>
                                                </div>
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

            <!-- Información adicional -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Información Adicional</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Fecha de Creación</h6>
                                    <p class="mb-3"><?= date('d/m/Y H:i', strtotime($producto['fecha_creacion'])) ?></p>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6>Última Actualización</h6>
                                    <p class="mb-3"><?= date('d/m/Y H:i', strtotime($producto['fecha_actualizacion'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos relacionados -->
            <?php if (!empty($productos_relacionados)): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Productos Relacionados</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($productos_relacionados as $productoRelacionado): ?>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <?php if ($productoRelacionado['imagen_principal']): ?>
                                            <img src="<?= Vista::urlPublica('imagenes/productos/' . $productoRelacionado['imagen_principal']) ?>" 
                                                 alt="<?= Vista::escapar($productoRelacionado['nombre']) ?>" 
                                                 class="card-img-top" 
                                                 style="height: 150px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 150px;">
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
                                                <div class="d-grid gap-1">
                                                    <a href="<?= Vista::url('admin/producto-vista/' . $productoRelacionado['id']) ?>" class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-eye"></i> Vista Completa
                                                    </a>
                                                    <a href="<?= Vista::url('admin/producto-editar/' . $productoRelacionado['id']) ?>" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil"></i> Editar
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
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
