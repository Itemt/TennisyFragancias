<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10">
                <div class="card auth-card shadow-lg border-0 fade-in">
                    <div class="row g-0">
                        <!-- Panel Izquierdo - Formulario -->
                        <div class="col-lg-7">
                            <div class="p-4 p-lg-5">
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <span class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                                              style="width: 70px; height: 70px;">
                                            <i class="bi bi-person-plus-fill text-success" style="font-size: 2.5rem;"></i>
                                        </span>
                                    </div>
                                    <h2 class="fw-bold mb-2">Crear Cuenta</h2>
                                    <p class="text-muted">Únete a nuestra comunidad y disfruta de beneficios exclusivos</p>
                                </div>
                                
                                <?php if (!empty($errores)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <strong>Por favor corrige los siguientes errores:</strong>
                                        <ul class="mb-0 mt-2">
                                            <?php foreach ($errores as $error): ?>
                                                <li><?= Vista::escapar($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="<?= Vista::url('auth/registro') ?>" class="needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre" class="form-label fw-semibold">
                                                <i class="bi bi-person me-2 text-primario"></i>Nombre *
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   value="<?= Vista::escapar($nombre) ?>" 
                                                   placeholder="Juan"
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor ingresa tu nombre.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="apellido" class="form-label fw-semibold">
                                                <i class="bi bi-person me-2 text-primario"></i>Apellido *
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="apellido" 
                                                   name="apellido" 
                                                   value="<?= Vista::escapar($apellido) ?>" 
                                                   placeholder="Pérez"
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor ingresa tu apellido.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">
                                            <i class="bi bi-envelope me-2 text-primario"></i>Correo Electrónico *
                                        </label>
                                        <input type="email" 
                                               class="form-control" 
                                               id="email" 
                                               name="email" 
                                               value="<?= Vista::escapar($email) ?>" 
                                               placeholder="tu@email.com"
                                               required>
                                        <div class="invalid-feedback">
                                            Por favor ingresa un correo válido.
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label fw-semibold">
                                            <i class="bi bi-phone me-2 text-primario"></i>Teléfono
                                        </label>
                                        <input type="tel" 
                                               class="form-control" 
                                               id="telefono" 
                                               name="telefono" 
                                               value="<?= Vista::escapar($telefono) ?>"
                                               placeholder="+57 300 123 4567">
                                        <small class="text-muted">Opcional - para notificaciones de envío</small>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label fw-semibold">
                                                <i class="bi bi-key me-2 text-primario"></i>Contraseña *
                                            </label>
                                            <div class="position-relative">
                                                <input type="password" 
                                                       class="form-control" 
                                                       id="password" 
                                                       name="password" 
                                                       minlength="6" 
                                                       placeholder="••••••••"
                                                       required>
                                                <button type="button" 
                                                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                                        onclick="togglePasswordField('password', 'toggleIcon1')">
                                                    <i class="bi bi-eye" id="toggleIcon1"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Mínimo 6 caracteres</small>
                                            <div class="invalid-feedback">
                                                La contraseña debe tener al menos 6 caracteres.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmar" class="form-label fw-semibold">
                                                <i class="bi bi-shield-check me-2 text-primario"></i>Confirmar *
                                            </label>
                                            <div class="position-relative">
                                                <input type="password" 
                                                       class="form-control" 
                                                       id="password_confirmar" 
                                                       name="password_confirmar" 
                                                       minlength="6" 
                                                       placeholder="••••••••"
                                                       required>
                                                <button type="button" 
                                                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                                        onclick="togglePasswordField('password_confirmar', 'toggleIcon2')">
                                                    <i class="bi bi-eye" id="toggleIcon2"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback">
                                                Por favor confirma tu contraseña.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" required>
                                            <label class="form-check-label small" for="terms">
                                                Acepto los <a href="#" class="text-primario text-decoration-none">términos y condiciones</a> 
                                                y la <a href="#" class="text-primario text-decoration-none">política de privacidad</a>
                                            </label>
                                            <div class="invalid-feedback">
                                                Debes aceptar los términos y condiciones.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primario w-100 btn-lg mb-3">
                                        <i class="bi bi-check-circle me-2"></i>Crear Mi Cuenta
                                    </button>
                                </form>
                                
                                <div class="text-center">
                                    <div class="position-relative my-4">
                                        <hr>
                                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">
                                            o
                                        </span>
                                    </div>
                                    
                                    <p class="mb-2 text-muted">¿Ya tienes una cuenta?</p>
                                    <a href="<?= Vista::url('auth/login') ?>" class="btn btn-outline-dark w-100">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Panel Derecho - Información -->
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-5" 
                             style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); position: relative; overflow: hidden;">
                            <div class="text-white text-center position-relative z-2">
                                <i class="bi bi-gift-fill" style="font-size: 5rem; opacity: 0.9; margin-bottom: 1.5rem;"></i>
                                <h2 class="fw-bold mb-3">¡Únete Hoy!</h2>
                                <p class="mb-4" style="opacity: 0.95;">
                                    Crea tu cuenta gratis y accede a beneficios exclusivos
                                </p>
                                
                                <div class="text-start" style="max-width: 300px; margin: 0 auto;">
                                    <div class="d-flex align-items-start gap-3 mb-4">
                                        <div class="mt-1">
                                            <i class="bi bi-check-circle-fill fs-4"></i>
                                        </div>
                                        <div>
                                            <strong>Envío gratis</strong>
                                            <p class="mb-0 small" style="opacity: 0.9;">En tu primera compra mayor a $50.000</p>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-start gap-3 mb-4">
                                        <div class="mt-1">
                                            <i class="bi bi-check-circle-fill fs-4"></i>
                                        </div>
                                        <div>
                                            <strong>Descuentos especiales</strong>
                                            <p class="mb-0 small" style="opacity: 0.9;">Acceso a ofertas exclusivas para miembros</p>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-start gap-3 mb-4">
                                        <div class="mt-1">
                                            <i class="bi bi-check-circle-fill fs-4"></i>
                                        </div>
                                        <div>
                                            <strong>Programa de puntos</strong>
                                            <p class="mb-0 small" style="opacity: 0.9;">Gana puntos con cada compra</p>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="mt-1">
                                            <i class="bi bi-check-circle-fill fs-4"></i>
                                        </div>
                                        <div>
                                            <strong>Soporte prioritario</strong>
                                            <p class="mb-0 small" style="opacity: 0.9;">Atención rápida y personalizada</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Decoración de fondo -->
                            <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                            <div style="position: absolute; bottom: -80px; right: -80px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordField(fieldId, iconId) {
    const passwordInput = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(iconId);
    
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
            // Validar que las contraseñas coincidan
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmar');
            
            if (password.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Las contraseñas no coinciden');
            } else {
                passwordConfirm.setCustomValidity('');
            }
            
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        
        // Validación en tiempo real de contraseñas
        document.getElementById('password_confirmar').addEventListener('input', function() {
            const password = document.getElementById('password');
            if (this.value !== password.value) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });
    });
})();
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

