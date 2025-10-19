<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>
        
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?= isset($producto) ? 'Editar Producto' : 'Nuevo Producto' ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/productos') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto *</label>
                            <input type="text" class="form-control" name="nombre" 
                                   value="<?= isset($producto) ? Vista::escapar($producto['nombre']) : '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4"><?= isset($producto) ? Vista::escapar($producto['descripcion']) : '' ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Precio *</label>
                                <input type="number" class="form-control" name="precio" step="0.01" 
                                       value="<?= isset($producto) ? $producto['precio'] : '' ?>" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Precio Oferta</label>
                                <input type="number" class="form-control" name="precio_oferta" step="0.01" 
                                       value="<?= isset($producto) ? $producto['precio_oferta'] : '' ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Categoría *</label>
                                <select class="form-select" name="categoria_id" required>
                                    <option value="">Seleccionar...</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>" 
                                                <?= (isset($producto) && $producto['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                                            <?= Vista::escapar($categoria['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="estado">
                                    <option value="activo" <?= (isset($producto) && $producto['estado'] == 'activo') ? 'selected' : '' ?>>Activo</option>
                                    <option value="inactivo" <?= (isset($producto) && $producto['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                                    <option value="agotado" <?= (isset($producto) && $producto['estado'] == 'agotado') ? 'selected' : '' ?>>Agotado</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Marca</label>
                                <select class="form-select" name="marca_id">
                                    <option value="">Seleccionar marca...</option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?= $marca['id'] ?>" 
                                                <?= (isset($producto) && $producto['marca_id'] == $marca['id']) ? 'selected' : '' ?>>
                                            <?= Vista::escapar($marca['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Color</label>
                                <select class="form-select" name="color_id">
                                    <option value="">Seleccionar color...</option>
                                    <?php if (isset($colores)): ?>
                                        <?php foreach ($colores as $color): ?>
                                            <option value="<?= $color['id'] ?>" 
                                                    <?= (isset($producto) && $producto['color_id'] == $color['id']) ? 'selected' : '' ?>>
                                                <?= Vista::escapar($color['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Género</label>
                                <select class="form-select" name="genero_id">
                                    <option value="">Seleccionar género...</option>
                                    <?php if (isset($generos)): ?>
                                        <?php foreach ($generos as $genero): ?>
                                            <option value="<?= $genero['id'] ?>" 
                                                    <?= (isset($producto) && $producto['genero_id'] == $genero['id']) ? 'selected' : '' ?>>
                                                <?= Vista::escapar($genero['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Nota sobre gestión de tallas -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Gestión de Tallas:</strong> Para agregar o modificar tallas y stock, utiliza la sección 
                            <a href="<?= Vista::url('admin/stock') ?>" class="alert-link">"Actualizar Stock"</a> 
                            después de guardar el producto.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="destacado" id="destacado" 
                                           <?= (isset($producto) && $producto['destacado']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="destacado">
                                        Producto Destacado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Imagen Principal</label>
                            <?php if (isset($producto) && $producto['imagen_principal']): ?>
                                <div class="mb-2">
                                    <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                                         class="img-fluid rounded" alt="Imagen actual">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" name="imagen" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                            <div class="form-text">Formatos permitidos: JPG, PNG, GIF, WEBP (máx. 5MB)</div>
                        </div>
                        
                        <?php if (isset($producto)): ?>
                            <div class="alert alert-info">
                                <small><strong>SKU:</strong> <?= Vista::escapar($producto['codigo_sku']) ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primario">
                        <i class="bi bi-save"></i> <?= isset($producto) ? 'Actualizar' : 'Crear' ?> Producto
                    </button>
                    <a href="<?= Vista::url('admin/productos') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// JavaScript para validaciones básicas del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    // Validaciones básicas del formulario
    const nombre = document.querySelector('input[name="nombre"]').value.trim();
    const precio = document.querySelector('input[name="precio"]').value;
    
    if (!nombre) {
        e.preventDefault();
        alert('El nombre del producto es obligatorio.');
        return false;
    }
    
    if (!precio || parseFloat(precio) <= 0) {
        e.preventDefault();
        alert('El precio debe ser mayor a 0.');
        return false;
    }
});
</script>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

