<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>
        
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-plus-circle"></i> Agregar Nueva Variante</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/producto-vista/' . $producto['id']) ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al Producto
                    </a>
                </div>
            </div>

            <!-- Información del producto base -->
            <div class="alert alert-info">
                <h5><i class="bi bi-info-circle"></i> Producto Base</h5>
                <p class="mb-0"><strong><?= Vista::escapar($producto['nombre']) ?></strong> - <?= Vista::escapar($producto['categoria_nombre']) ?></p>
                <small class="text-muted">Se creará una nueva variante con el mismo nombre pero diferente talla/color</small>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Información de la Nueva Variante</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Talla -->
                                    <div class="col-md-6">
                                        <label class="form-label">Talla *</label>
                                        <select class="form-select" name="talla_id" required>
                                            <option value="">Selecciona una talla</option>
                                            <?php foreach ($tallas as $talla): ?>
                                                <option value="<?= $talla['id'] ?>">
                                                    <?= Vista::escapar($talla['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Color -->
                                    <div class="col-md-6">
                                        <label class="form-label">Color</label>
                                        <select class="form-select" name="color_id">
                                            <option value="">Sin color</option>
                                            <?php foreach ($colores as $color): ?>
                                                <option value="<?= $color['id'] ?>">
                                                    <?= Vista::escapar($color['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Precio -->
                                    <div class="col-md-6">
                                        <label class="form-label">Precio *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="precio" 
                                                   value="<?= $producto['precio'] ?>" step="0.01" min="0" required>
                                        </div>
                                    </div>

                                    <!-- Precio Oferta -->
                                    <div class="col-md-6">
                                        <label class="form-label">Precio Oferta</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="precio_oferta" 
                                                   step="0.01" min="0">
                                        </div>
                                        <small class="text-muted">Dejar vacío si no hay oferta</small>
                                    </div>

                                    <!-- Stock -->
                                    <div class="col-md-6">
                                        <label class="form-label">Stock Inicial *</label>
                                        <input type="number" class="form-control" name="stock" 
                                               value="0" min="0" required>
                                    </div>

                                    <!-- Stock Mínimo -->
                                    <div class="col-md-6">
                                        <label class="form-label">Stock Mínimo</label>
                                        <input type="number" class="form-control" name="stock_minimo" 
                                               value="<?= $producto['stock_minimo'] ?>" min="0">
                                    </div>

                                    <!-- SKU -->
                                    <div class="col-md-12">
                                        <label class="form-label">Código SKU</label>
                                        <input type="text" class="form-control" name="codigo_sku" 
                                               placeholder="Ej: TF-001-22-0002">
                                        <small class="text-muted">Código único para esta variante</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Acciones</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Crear Variante
                                    </button>
                                    <a href="<?= Vista::url('admin/producto-vista/' . $producto['id']) ?>" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">Información</h6>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> 
                                    La nueva variante tendrá el mismo nombre, categoría, marca y género que el producto base.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
