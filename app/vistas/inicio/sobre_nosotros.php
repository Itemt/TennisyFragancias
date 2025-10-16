<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<section class="py-5">
    <div class="container">
        <!-- Hero Section -->
        <div class="row align-items-center g-4 mb-5">
            <div class="col-lg-6 text-center">
                <img class="img-fluid rounded shadow d-block mx-auto" 
                     src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=900&h=600&fit=crop" 
                     onerror="this.src='<?= Vista::urlPublica('imagenes/tacones-altos.png') ?>'" 
                     alt="Sobre Nosotros" 
                     style="max-height: 360px; object-fit: cover;">
            </div>
            <div class="col-lg-6">
                <h1 class="fw-bold mb-4">Sobre Tennis y Fragancias</h1>
                <p class="lead">Somos una empresa colombiana dedicada a ofrecer los mejores productos de calidad en calzado deportivo y fragancias, con la mejor relación calidad-precio del mercado.</p>
                <p>Ubicados en Barrancabermeja, Santander, nos especializamos en brindar una experiencia de compra excepcional, tanto en nuestra tienda física como en línea.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="<?= Vista::url('productos') ?>" class="btn btn-primario">
                        <i class="bi bi-bag-check"></i> Ver Productos
                    </a>
                    <a href="<?= Vista::url('inicio/contacto') ?>" class="btn btn-outline-dark">
                        <i class="bi bi-envelope"></i> Contáctanos
                    </a>
                </div>
            </div>
        </div>

        <!-- Valores -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="p-4 bg-light rounded h-100 text-center">
                    <i class="bi bi-truck fs-1 text-primario mb-3"></i>
                    <h5 class="fw-bold">Envíos Rápidos</h5>
                    <p class="small mb-0">Llegamos a todo el país con logística confiable y segura.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-light rounded h-100 text-center">
                    <i class="bi bi-shield-check fs-1 text-primario mb-3"></i>
                    <h5 class="fw-bold">Compra Segura</h5>
                    <p class="small mb-0">Pagos protegidos y datos siempre seguros con encriptación.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-light rounded h-100 text-center">
                    <i class="bi bi-emoji-smile fs-1 text-primario mb-3"></i>
                    <h5 class="fw-bold">Atención Cercana</h5>
                    <p class="small mb-0">Equipo listo para ayudarte en todo momento con dedicación.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-light rounded h-100 text-center">
                    <i class="bi bi-recycle fs-1 text-primario mb-3"></i>
                    <h5 class="fw-bold">Cambios Fáciles</h5>
                    <p class="small mb-0">Política clara de cambios y devoluciones sin complicaciones.</p>
                </div>
            </div>
        </div>

        <!-- Misión, Visión, Valores -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-bullseye fs-2 text-primario me-3"></i>
                            <h3 class="fw-bold mb-0">Misión</h3>
                        </div>
                        <p class="mb-0">Ofrecer productos de excelente calidad a precios accesibles, brindando una experiencia de compra satisfactoria y construyendo relaciones duraderas con nuestros clientes.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-eye fs-2 text-primario me-3"></i>
                            <h3 class="fw-bold mb-0">Visión</h3>
                        </div>
                        <p class="mb-0">Ser la tienda líder en Colombia en calzado deportivo y fragancias, reconocidos por nuestra calidad, servicio y compromiso con la satisfacción del cliente.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-heart fs-2 text-primario me-3"></i>
                            <h3 class="fw-bold mb-0">Valores</h3>
                        </div>
                        <ul class="mb-0 ps-3">
                            <li>Calidad en cada producto</li>
                            <li>Honestidad y transparencia</li>
                            <li>Compromiso con el cliente</li>
                            <li>Innovación constante</li>
                            <li>Responsabilidad social</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enlaces útiles -->
        <div class="bg-light rounded p-4">
            <h3 class="fw-bold mb-4 text-center">Información Importante</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="<?= Vista::url('inicio/privacidad') ?>" class="d-flex align-items-center p-3 bg-white rounded text-decoration-none text-dark hover-shadow">
                        <i class="bi bi-shield-lock fs-3 text-primario me-3"></i>
                        <div>
                            <h5 class="mb-0">Política de Privacidad</h5>
                            <small class="text-muted">Cómo protegemos tus datos</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="<?= Vista::url('inicio/terminos') ?>" class="d-flex align-items-center p-3 bg-white rounded text-decoration-none text-dark hover-shadow">
                        <i class="bi bi-file-text fs-3 text-primario me-3"></i>
                        <div>
                            <h5 class="mb-0">Términos y Condiciones</h5>
                            <small class="text-muted">Condiciones de uso del sitio</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= Vista::url('inicio/devoluciones') ?>" class="d-flex align-items-center p-3 bg-white rounded text-decoration-none text-dark hover-shadow">
                        <i class="bi bi-arrow-left-right fs-3 text-primario me-3"></i>
                        <div>
                            <h5 class="mb-0 small">Cambios y Devoluciones</h5>
                            <small class="text-muted">Política de devoluciones</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= Vista::url('inicio/envios') ?>" class="d-flex align-items-center p-3 bg-white rounded text-decoration-none text-dark hover-shadow">
                        <i class="bi bi-box-seam fs-3 text-primario me-3"></i>
                        <div>
                            <h5 class="mb-0 small">Envíos y Entregas</h5>
                            <small class="text-muted">Información de envíos</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= Vista::url('inicio/faq') ?>" class="d-flex align-items-center p-3 bg-white rounded text-decoration-none text-dark hover-shadow">
                        <i class="bi bi-question-circle fs-3 text-primario me-3"></i>
                        <div>
                            <h5 class="mb-0 small">Preguntas Frecuentes</h5>
                            <small class="text-muted">Resuelve tus dudas</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}
</style>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

