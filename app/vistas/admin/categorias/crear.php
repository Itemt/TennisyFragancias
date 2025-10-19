<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-plus-circle"></i> Nueva Categoría</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/categorias') ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver a Categorías
                    </a>
                </div>
            </div>

            <!-- Mensajes y alertas -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= Vista::url('admin/categoria_crear') ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre de la Categoría *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?= Vista::escapar($_POST['nombre'] ?? '') ?>" required
                                           placeholder="Ej: Zapatos Deportivos">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label">URL de la Imagen</label>
                                    <input type="url" class="form-control" id="imagen" name="imagen" 
                                           value="<?= Vista::escapar($_POST['imagen'] ?? '') ?>"
                                           placeholder="https://ejemplo.com/imagen.jpg">
                                    <div class="form-text">Opcional: URL de una imagen representativa de la categoría</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                                      placeholder="Describe la categoría..."><?= Vista::escapar($_POST['descripcion'] ?? '') ?></textarea>
                            <div class="form-text">Opcional: Descripción detallada de la categoría</div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= Vista::url('admin/categorias') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Crear Categoría
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
