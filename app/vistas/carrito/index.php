<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-4">Carrito de Compras</h1>
    
    <?php if (!empty($items)): ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Talla</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['imagen_principal']): ?>
                                                        <img src="<?= Vista::urlPublica('imagenes/productos/' . $item['imagen_principal']) ?>" 
                                                             alt="<?= Vista::escapar($item['nombre']) ?>" 
                                                             style="width: 60px; height: 60px; object-fit: cover;" 
                                                             class="me-3">
                                                    <?php endif; ?>
                                                    <div>
                                                        <a href="<?= Vista::url('productos/ver/' . $item['producto_id']) ?>">
                                                            <?= Vista::escapar($item['nombre']) ?>
                                                        </a>
                                                        <br>
                                                        <small class="text-muted"><?= Vista::escapar($item['categoria_nombre']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= Vista::escapar($item['talla_nombre'] ?? 'N/A') ?>
                                                </span>
                                            </td>
                                            <td><?= Vista::formatearPrecio($item['precio_unitario']) ?></td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm cantidad-input" 
                                                       value="<?= $item['cantidad'] ?>" 
                                                       min="1" 
                                                       max="<?= $item['stock'] ?>"
                                                       data-carrito-id="<?= $item['id'] ?>"
                                                       style="width: 80px;">
                                            </td>
                                            <td class="fw-bold"><?= Vista::formatearPrecio($item['precio_unitario'] * $item['cantidad']) ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-danger eliminar-item" 
                                                        data-carrito-id="<?= $item['id'] ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Resumen del Pedido</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotal"><?= Vista::formatearPrecio($total) ?></span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>IVA (19%):</span>
                            <span id="iva"><?= Vista::formatearPrecio($total * 0.19) ?></span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-primario fs-4" id="total"><?= Vista::formatearPrecio($total * 1.19) ?></strong>
                        </div>
                        
                        <a href="<?= Vista::url('carrito/checkout') ?>" class="btn btn-primario w-100 btn-lg mb-2">
                            <i class="bi bi-credit-card"></i> Proceder al Pago
                        </a>
                        
                        <a href="<?= Vista::url('productos') ?>" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left"></i> Seguir Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
            <h4>Tu carrito está vacío</h4>
            <p>Explora nuestro catálogo y encuentra los productos perfectos para ti</p>
            <a href="<?= Vista::url('productos') ?>" class="btn btn-primario">Ver Productos</a>
        </div>
    <?php endif; ?>
</div>

<script>
// Actualizar cantidad
document.querySelectorAll('.cantidad-input').forEach(input => {
    input.addEventListener('change', function() {
        const carritoId = this.dataset.carritoId;
        const cantidad = this.value;
        
        const formData = new FormData();
        formData.append('carrito_id', carritoId);
        formData.append('cantidad', cantidad);
        
        fetch('<?= Vista::url("carrito/actualizar") ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                // Actualizar contador del carrito
                if (data.total_items !== undefined) {
                    document.getElementById('carrito-contador').textContent = data.total_items;
                }
                location.reload();
            } else {
                alert(data.mensaje);
            }
        });
    });
});

// Eliminar item
document.querySelectorAll('.eliminar-item').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm('¿Eliminar este producto del carrito?')) return;
        
        const carritoId = this.dataset.carritoId;
        
        const formData = new FormData();
        formData.append('carrito_id', carritoId);
        
        fetch('<?= Vista::url("carrito/eliminar") ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                // Actualizar contador del carrito
                if (data.total_items !== undefined) {
                    document.getElementById('carrito-contador').textContent = data.total_items;
                }
                location.reload();
            } else {
                alert(data.mensaje);
            }
        });
    });
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

