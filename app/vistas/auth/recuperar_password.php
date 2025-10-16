<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Recuperar Contraseña</h2>
                    
                    <?php if (isset($exito)): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> <?= Vista::escapar($exito) ?>
                        </div>
                        <div class="text-center">
                            <a href="<?= Vista::url('auth/login') ?>" class="btn btn-primario">Volver al Login</a>
                        </div>
                    <?php else: ?>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle"></i> <?= Vista::escapar($error) ?>
                            </div>
                        <?php endif; ?>
                        
                        <p class="text-muted">Ingresa tu email y te enviaremos instrucciones para recuperar tu contraseña.</p>
                        
                        <form method="POST" action="<?= Vista::url('auth/recuperar_password') ?>">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primario w-100">Enviar Instrucciones</button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <a href="<?= Vista::url('auth/login') ?>">Volver al Login</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

