<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> <?= Vista::escapar($error) ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= Vista::url('auth/login') ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= Vista::escapar($email) ?>" required autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <a href="<?= Vista::url('auth/recuperar_password') ?>" class="small">¿Olvidaste tu contraseña?</a>
                        </div>
                        
                        <button type="submit" class="btn btn-primario w-100">Iniciar Sesión</button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">¿No tienes cuenta?</p>
                        <a href="<?= Vista::url('auth/registro') ?>" class="btn btn-outline-dark w-100 mt-2">Crear Cuenta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

