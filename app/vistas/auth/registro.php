<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Crear Cuenta</h2>
                    
                    <?php if (!empty($errores)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errores as $error): ?>
                                    <li><?= Vista::escapar($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= Vista::url('auth/registro') ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?= Vista::escapar($nombre) ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                       value="<?= Vista::escapar($apellido) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= Vista::escapar($email) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" 
                                   value="<?= Vista::escapar($telefono) ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   minlength="6" required>
                            <div class="form-text">Mínimo 6 caracteres</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmar" class="form-label">Confirmar Contraseña *</label>
                            <input type="password" class="form-control" id="password_confirmar" 
                                   name="password_confirmar" minlength="6" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primario w-100">Registrarse</button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">¿Ya tienes cuenta?</p>
                        <a href="<?= Vista::url('auth/login') ?>" class="btn btn-outline-dark w-100 mt-2">Iniciar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

