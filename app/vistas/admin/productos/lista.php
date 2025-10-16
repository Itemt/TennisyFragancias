<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-box-seam"></i> Gestión de Productos</h1>
        <a href="<?= Vista::url('admin/producto_nuevo') ?>" class="btn btn-primario">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>SKU</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><small><?= Vista::escapar($producto['codigo_sku']) ?></small></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($producto['imagen_principal']): ?>
                                            <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                                                 alt="<?= Vista::escapar($producto['nombre']) ?>" 
                                                 style="width: 40px; height: 40px; object-fit: cover;" 
                                                 class="me-2">
                                        <?php endif; ?>
                                        <div>
                                            <?= Vista::escapar($producto['nombre']) ?>
                                            <?php if ($producto['destacado']): ?>
                                                <span class="badge bg-warning text-dark ms-1">Destacado</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?= Vista::escapar($producto['categoria_nombre']) ?></td>
                                <td><?= Vista::formatearPrecio($producto['precio']) ?></td>
                                <td>
                                    <?php if ($producto['stock'] <= $producto['stock_minimo']): ?>
                                        <span class="badge bg-danger"><?= $producto['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= $producto['stock'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($producto['estado'] === 'activo'): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= ucfirst($producto['estado']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= Vista::url('admin/producto_editar/' . $producto['id']) ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= Vista::url('admin/producto_eliminar/' . $producto['id']) ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

