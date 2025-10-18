<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Editar Categoría</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/categorias') ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver a Categorías
                    </a>
                </div>
            </div>

            <?php $this->mostrarMensajes(); ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= Vista::url('admin/categoria-editar/' . $categoria['id']) ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre de la Categoría *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?= Vista::escapar($categoria['nombre']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label">URL de la Imagen</label>
                                    <input type="url" class="form-control" id="imagen" name="imagen" 
                                           value="<?= Vista::escapar($categoria['imagen'] ?? '') ?>"
                                           placeholder="https://ejemplo.com/imagen.jpg">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                                      placeholder="Describe la categoría..."><?= Vista::escapar($categoria['descripcion'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= Vista::url('admin/categorias') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primario">
                                <i class="bi bi-check-circle"></i> Actualizar Categoría
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
