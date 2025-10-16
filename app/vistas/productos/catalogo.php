<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-4">Catálogo de Productos</h1>
    
    <div class="row">
        <!-- Filtros -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header bg-secundario text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= Vista::url('productos') ?>">
                        <!-- Búsqueda -->
                        <div class="mb-3">
                            <label class="form-label">Buscar</label>
                            <input type="text" class="form-control" name="buscar" 
                                   value="<?= Vista::escapar($_GET['buscar'] ?? '') ?>" 
                                   placeholder="Nombre del producto...">
                        </div>
                        
                        <!-- Categoría -->
                        <?php if (!empty($categorias)): ?>
                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select class="form-select" name="categoria">
                                <option value="">Todas</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id'] ?>" 
                                            <?= ($filtros_activos['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                                        <?= Vista::escapar($categoria['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Género -->
                        <div class="mb-3">
                            <label class="form-label">Género</label>
                            <select class="form-select" name="genero">
                                <option value="">Todos</option>
                                <option value="hombre" <?= ($filtros_activos['genero'] == 'hombre') ? 'selected' : '' ?>>Hombre</option>
                                <option value="mujer" <?= ($filtros_activos['genero'] == 'mujer') ? 'selected' : '' ?>>Mujer</option>
                                <option value="unisex" <?= ($filtros_activos['genero'] == 'unisex') ? 'selected' : '' ?>>Unisex</option>
                                <option value="niño" <?= ($filtros_activos['genero'] == 'niño') ? 'selected' : '' ?>>Niño</option>
                                <option value="niña" <?= ($filtros_activos['genero'] == 'niña') ? 'selected' : '' ?>>Niña</option>
                            </select>
                        </div>
                        
                        <!-- Marca -->
                        <?php if (!empty($marcas)): ?>
                        <div class="mb-3">
                            <label class="form-label">Marca</label>
                            <select class="form-select" name="marca">
                                <option value="">Todas</option>
                                <?php foreach ($marcas as $marca): ?>
                                    <option value="<?= Vista::escapar($marca) ?>" 
                                            <?= ($filtros_activos['marca'] == $marca) ? 'selected' : '' ?>>
                                        <?= Vista::escapar($marca) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Precio -->
                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" name="precio_min" 
                                           placeholder="Mín" value="<?= Vista::escapar($filtros_activos['precio_min'] ?? '') ?>">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" name="precio_max" 
                                           placeholder="Máx" value="<?= Vista::escapar($filtros_activos['precio_max'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primario w-100 mb-2">Aplicar Filtros</button>
                        <a href="<?= Vista::url('productos') ?>" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Productos -->
        <div class="col-md-9">
            <!-- Ordenamiento -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted mb-0"><?= count($productos) ?> productos encontrados</p>
                <div>
                    <select class="form-select form-select-sm" onchange="window.location.href='<?= Vista::url('productos') ?>?orden=' + this.value">
                        <option value="reciente" <?= ($filtros_activos['orden'] == 'reciente') ? 'selected' : '' ?>>Más recientes</option>
                        <option value="precio_asc" <?= ($filtros_activos['orden'] == 'precio_asc') ? 'selected' : '' ?>>Precio: menor a mayor</option>
                        <option value="precio_desc" <?= ($filtros_activos['orden'] == 'precio_desc') ? 'selected' : '' ?>>Precio: mayor a menor</option>
                        <option value="nombre" <?= ($filtros_activos['orden'] == 'nombre') ? 'selected' : '' ?>>Nombre A-Z</option>
                    </select>
                </div>
            </div>
            
            <!-- Grid de productos -->
            <?php if (!empty($productos)): ?>
                <div class="row g-4">
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-4">
                            <div class="card h-100 producto-card">
                                <a href="<?= Vista::url('productos/ver/' . $producto['id']) ?>">
                                    <?php if ($producto['imagen_principal']): ?>
                                        <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                                             class="card-img-top" alt="<?= Vista::escapar($producto['nombre']) ?>" 
                                             style="height: 250px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image fs-1 text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?= Vista::url('productos/ver/' . $producto['id']) ?>" class="text-decoration-none text-dark">
                                            <?= Vista::escapar($producto['nombre']) ?>
                                        </a>
                                    </h5>
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
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No se encontraron productos con los criterios seleccionados.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

