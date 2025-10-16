<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-4">Cambiar Contraseña</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($errores)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errores as $error): ?>
                                    <li><?= Vista::escapar($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= Vista::url('perfil/cambiar_password') ?>">
                        <div class="mb-3">
                            <label class="form-label">Contraseña Actual *</label>
                            <input type="password" class="form-control" name="password_actual" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña *</label>
                            <input type="password" class="form-control" name="password_nuevo" minlength="6" required>
                            <div class="form-text">Mínimo 6 caracteres</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Confirmar Nueva Contraseña *</label>
                            <input type="password" class="form-control" name="password_confirmar" minlength="6" required>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primario">
                                <i class="bi bi-key"></i> Cambiar Contraseña
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

