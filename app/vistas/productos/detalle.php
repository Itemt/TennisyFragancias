<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= Vista::url() ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= Vista::url('productos') ?>">Productos</a></li>
            <li class="breadcrumb-item active"><?= Vista::escapar($producto['nombre']) ?></li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <?php if ($producto['imagen_principal']): ?>
                    <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                         class="card-img-top" alt="<?= Vista::escapar($producto['nombre']) ?>">
                <?php else: ?>
                    <div class="bg-light" style="height: 500px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-image fs-1 text-muted"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Información del producto -->
        <div class="col-md-6">
            <h1 class="mb-3"><?= Vista::escapar($producto['nombre']) ?></h1>
            
            <div class="mb-3">
                <span class="badge bg-secondary"><?= Vista::escapar($producto['categoria_nombre']) ?></span>
                <?php if ($producto['destacado']): ?>
                    <span class="badge bg-warning text-dark">Destacado</span>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <?php if ($producto['precio_oferta']): ?>
                    <h2 class="precio-oferta mb-0"><?= Vista::formatearPrecio($producto['precio_oferta']) ?></h2>
                    <p class="precio-original"><?= Vista::formatearPrecio($producto['precio']) ?></p>
                    <span class="badge bg-danger">
                        <?= round((($producto['precio'] - $producto['precio_oferta']) / $producto['precio']) * 100) ?>% de descuento
                    </span>
                <?php else: ?>
                    <h2 class="mb-0"><?= Vista::formatearPrecio($producto['precio']) ?></h2>
                <?php endif; ?>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Descripción</h5>
                    <p><?= nl2br(Vista::escapar($producto['descripcion'])) ?></p>
                    
                    <hr>
                    
                    <div class="row">
                        <?php if ($producto['marca_nombre']): ?>
                        <div class="col-6 mb-2">
                            <strong>Marca:</strong><br>
                            <?= Vista::escapar($producto['marca_nombre']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($producto['talla_nombre']): ?>
                        <div class="col-6 mb-2">
                            <strong>Talla:</strong><br>
                            <?= Vista::escapar($producto['talla_nombre']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($producto['color_nombre']): ?>
                        <div class="col-6 mb-2">
                            <strong>Color:</strong><br>
                            <?= Vista::escapar($producto['color_nombre']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="col-6 mb-2">
                            <strong>Género:</strong><br>
                            <?= ucfirst(Vista::escapar($producto['genero_nombre'] ?? 'No especificado')) ?>
                        </div>
                        
                        <div class="col-6 mb-2">
                            <strong>SKU:</strong><br>
                            <?= Vista::escapar($producto['codigo_sku']) ?>
                        </div>
                        
                        <div class="col-6 mb-2">
                            <strong>Disponibilidad:</strong><br>
                            <?php if ($producto['stock'] > 0): ?>
                                <span class="badge bg-success">En stock (<?= $producto['stock'] ?> unidades)</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Agotado</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Agregar al carrito -->
            <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_rol'] === ROL_CLIENTE): ?>
                <?php if ($producto['stock'] > 0): ?>
                    <form id="form-agregar-carrito" class="mb-3">
                        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Talla:</label>
                                <select class="form-select" name="talla_id" required>
                                    <option value="">Selecciona una talla</option>
                                    <?php if ($producto['talla_nombre']): ?>
                                        <option value="<?= $producto['talla_id'] ?>" selected>
                                            <?= Vista::escapar($producto['talla_nombre']) ?>
                                        </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cantidad:</label>
                                <input type="number" class="form-control" name="cantidad" value="1" min="1" max="<?= $producto['stock'] ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primario btn-lg w-100">
                            <i class="bi bi-cart-plus"></i> Agregar al Carrito
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Producto actualmente agotado
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    <a href="<?= Vista::url('auth/login') ?>">Inicia sesión</a> para agregar productos al carrito
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Productos relacionados -->
    <?php if (!empty($productos_relacionados)): ?>
    <div class="mt-5">
        <h3 class="mb-4">Productos Relacionados</h3>
        <div class="row g-4">
            <?php foreach ($productos_relacionados as $relacionado): ?>
                <?php if ($relacionado['id'] != $producto['id']): ?>
                <div class="col-md-3">
                    <div class="card h-100 producto-card">
                        <a href="<?= Vista::url('productos/ver/' . $relacionado['id']) ?>">
                            <?php if ($relacionado['imagen_principal']): ?>
                                <img src="<?= Vista::urlPublica('imagenes/productos/' . $relacionado['imagen_principal']) ?>" 
                                     class="card-img-top" alt="<?= Vista::escapar($relacionado['nombre']) ?>" 
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-image fs-3 text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="<?= Vista::url('productos/ver/' . $relacionado['id']) ?>" class="text-decoration-none text-dark">
                                    <?= Vista::escapar($relacionado['nombre']) ?>
                                </a>
                            </h6>
                            <p class="fw-bold mb-0"><?= Vista::formatearPrecio($relacionado['precio']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('form-agregar-carrito').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= Vista::url("carrito/agregar") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            alert(data.mensaje);
            if (data.total_items) {
                document.getElementById('carrito-contador').textContent = data.total_items;
                document.getElementById('carrito-contador').style.display = 'inline-block';
            }
        } else {
            alert(data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al agregar el producto');
    });
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

