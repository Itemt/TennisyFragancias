<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <div class="card auth-card shadow-lg border-0 fade-in">
                    <div class="row g-0">
                        <!-- Panel Izquierdo - Información -->
                        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center p-5" 
                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                            <div class="text-white text-center position-relative z-2">
                                <i class="bi bi-lock-fill" style="font-size: 5rem; opacity: 0.9; margin-bottom: 1.5rem;"></i>
                                <h2 class="fw-bold mb-3">¡Bienvenido de nuevo!</h2>
                                <p class="lead mb-4" style="opacity: 0.95;">
                                    Inicia sesión para acceder a tu cuenta y disfrutar de todas nuestras funcionalidades.
                                </p>
                                <div class="d-flex flex-column gap-3 text-start" style="max-width: 350px; margin: 0 auto;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                                            <i class="bi bi-bag-check-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <strong>Compras rápidas</strong>
                                            <p class="mb-0 small" style="opacity: 0.9;">Guarda tus productos favoritos</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                                            <i class="bi bi-clock-history fs-5"></i>
                                        </div>
                                        <div>
                                            <strong>Historial de pedidos</strong>
                                            <p class="mb-0 small" style="opacity: 0.9;">Rastrea tus compras fácilmente</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                                            <i class="bi bi-percent fs-5"></i>
                                        </div>
                                        <div>
                                            <strong>Ofertas exclusivas</strong>
                                            <p class="mb-0 small" style="opacity: 0.9;">Descuentos solo para miembros</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Decoración de fondo -->
                            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                            <div style="position: absolute; bottom: -80px; left: -80px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                        </div>
                        
                        <!-- Panel Derecho - Formulario -->
                        <div class="col-lg-6">
                            <div class="p-4 p-lg-5">
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <span class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                                              style="width: 70px; height: 70px;">
                                            <i class="bi bi-person-circle text-primario" style="font-size: 2.5rem;"></i>
                                        </span>
                                    </div>
                                    <h2 class="fw-bold mb-2">Iniciar Sesión</h2>
                                    <p class="text-muted">Ingresa tus credenciales para continuar</p>
                                </div>
                                
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                                        <?= Vista::escapar($error) ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="<?= Vista::url('auth/login') ?>" class="needs-validation" novalidate>
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">
                                            <i class="bi bi-envelope me-2 text-primario"></i>Correo Electrónico
                                        </label>
                                        <input type="email" 
                                               class="form-control form-control-lg" 
                                               id="email" 
                                               name="email" 
                                               value="<?= Vista::escapar($email) ?>" 
                                               placeholder="tu@email.com"
                                               required 
                                               autofocus>
                                        <div class="invalid-feedback">
                                            Por favor ingresa un correo válido.
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">
                                            <i class="bi bi-key me-2 text-primario"></i>Contraseña
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" 
                                                   class="form-control form-control-lg" 
                                                   id="password" 
                                                   name="password" 
                                                   placeholder="••••••••"
                                                   required>
                                            <button type="button" 
                                                    class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                                    onclick="togglePassword()">
                                                <i class="bi bi-eye" id="toggleIcon"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">
                                            Por favor ingresa tu contraseña.
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember">
                                            <label class="form-check-label small" for="remember">
                                                Recordarme
                                            </label>
                                        </div>
                                        <a href="<?= Vista::url('auth/recuperar_password') ?>" 
                                           class="small text-decoration-none text-primario">
                                            ¿Olvidaste tu contraseña?
                                        </a>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primario w-100 btn-lg mb-3">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                    </button>
                                </form>
                                
                                <div class="text-center">
                                    <div class="position-relative my-4">
                                        <hr>
                                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">
                                            o
                                        </span>
                                    </div>
                                    
                                    <p class="mb-2 text-muted">¿No tienes una cuenta?</p>
                                    <a href="<?= Vista::url('auth/registro') ?>" class="btn btn-outline-dark w-100">
                                        <i class="bi bi-person-plus me-2"></i>Crear Cuenta Nueva
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}

// Bootstrap form validation
(function() {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

