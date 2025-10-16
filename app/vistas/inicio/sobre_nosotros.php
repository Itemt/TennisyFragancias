<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <img class="img-fluid rounded shadow" src="<?= Vista::urlPublica('imagenes/about.jpg') ?>" onerror="this.src='https://via.placeholder.com/720x420?text=Tennis+y+Fragancias'" alt="Sobre Nosotros">
            </div>
            <div class="col-lg-6">
                <h1 class="fw-bold">Nuestra Historia</h1>
                <p class="lead">Tennis y Fragancias nace con la misión de llevar productos de calidad a precios justos, con una experiencia de compra simple y segura.</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded h-100">
                            <h5 class="text-primario mb-1"><i class="bi bi-truck"></i> Envíos Rápidos</h5>
                            <p class="small mb-0">Llegamos a todo el país con logística confiable.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded h-100">
                            <h5 class="text-primario mb-1"><i class="bi bi-shield-check"></i> Compra Segura</h5>
                            <p class="small mb-0">Pagos protegidos y datos siempre seguros.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded h-100">
                            <h5 class="text-primario mb-1"><i class="bi bi-emoji-smile"></i> Atención Cercana</h5>
                            <p class="small mb-0">Equipo listo para ayudarte en todo momento.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded h-100">
                            <h5 class="text-primario mb-1"><i class="bi bi-recycle"></i> Cambios Fáciles</h5>
                            <p class="small mb-0">Política clara de cambios y devoluciones.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

