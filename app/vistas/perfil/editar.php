<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-4">Editar Perfil</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= Vista::url('perfil/editar') ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" 
                                       value="<?= Vista::escapar($usuario['nombre']) ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellido *</label>
                                <input type="text" class="form-control" name="apellido" 
                                       value="<?= Vista::escapar($usuario['apellido']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" 
                                   value="<?= Vista::escapar($usuario['telefono'] ?? '') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <textarea class="form-control" name="direccion" rows="2"><?= Vista::escapar($usuario['direccion'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" name="ciudad" 
                                       value="<?= Vista::escapar($usuario['ciudad']) ?>">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departamento</label>
                                <input type="text" class="form-control" name="departamento" 
                                       value="<?= Vista::escapar($usuario['departamento']) ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Código Postal</label>
                            <input type="text" class="form-control" name="codigo_postal" 
                                   value="<?= Vista::escapar($usuario['codigo_postal'] ?? '') ?>">
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primario">
                                <i class="bi bi-save"></i> Guardar Cambios
                            </button>
                            <a href="<?= Vista::url('perfil') ?>" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

