<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= isset($producto) ? 'Editar Producto' : 'Nuevo Producto' ?></h1>
        <a href="<?= Vista::url('admin/productos') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
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
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stock *</label>
                                <input type="number" class="form-control" name="stock" 
                                       value="<?= isset($producto) ? $producto['stock'] : 0 ?>" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stock Mínimo</label>
                                <input type="number" class="form-control" name="stock_minimo" 
                                       value="<?= isset($producto) ? $producto['stock_minimo'] : 5 ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="estado">
                                    <option value="activo" <?= (isset($producto) && $producto['estado'] == 'activo') ? 'selected' : '' ?>>Activo</option>
                                    <option value="inactivo" <?= (isset($producto) && $producto['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                                    <option value="agotado" <?= (isset($producto) && $producto['estado'] == 'agotado') ? 'selected' : '' ?>>Agotado</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Marca</label>
                                <input type="text" class="form-control" name="marca" 
                                       value="<?= isset($producto) ? Vista::escapar($producto['marca']) : '' ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Talla</label>
                                <input type="text" class="form-control" name="talla" 
                                       value="<?= isset($producto) ? Vista::escapar($producto['talla']) : '' ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" class="form-control" name="color" 
                                       value="<?= isset($producto) ? Vista::escapar($producto['color']) : '' ?>">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Género</label>
                                <select class="form-select" name="genero">
                                    <option value="unisex" <?= (isset($producto) && $producto['genero'] == 'unisex') ? 'selected' : '' ?>>Unisex</option>
                                    <option value="hombre" <?= (isset($producto) && $producto['genero'] == 'hombre') ? 'selected' : '' ?>>Hombre</option>
                                    <option value="mujer" <?= (isset($producto) && $producto['genero'] == 'mujer') ? 'selected' : '' ?>>Mujer</option>
                                    <option value="niño" <?= (isset($producto) && $producto['genero'] == 'niño') ? 'selected' : '' ?>>Niño</option>
                                    <option value="niña" <?= (isset($producto) && $producto['genero'] == 'niña') ? 'selected' : '' ?>>Niña</option>
                                </select>
                            </div>
                            
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

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

