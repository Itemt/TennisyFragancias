<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<!-- Hero Section Moderno -->
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="container py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 hero-content slide-in-left">
                            <div class="badge bg-light text-dark mb-3 px-3 py-2">
                                <i class="bi bi-star-fill text-warning me-1"></i>
                                Lo Más Nuevo
                            </div>
                            <h1 class="hero-title mb-4">
                                Estrena estilo con <br>
                                <span class="text-white">Tennis y Fragancias</span>
                            </h1>
                            <p class="hero-subtitle mb-4">
                                Descubre nuestra colección exclusiva de calzado deportivo, casual y fragancias de alta calidad. 
                                ¡Expresa tu personalidad con cada paso!
                            </p>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="<?= Vista::url('productos') ?>" class="btn btn-light btn-lg">
                                    <i class="bi bi-shop me-2"></i>Ver Catálogo
                                </a>
                                <a href="<?= Vista::url('inicio/sobre_nosotros') ?>" class="btn btn-outline-light btn-lg">
                                    Conócenos
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center hero-image slide-in-right">
                            <div class="position-relative d-inline-block">
                                <div class="float">
                                    <img src="<?= Vista::urlPublica('imagenes/hero-image.jpg') ?>" 
                                         class="img-fluid rounded-4 shadow-lg" 
                                         style="max-height:450px; object-fit:cover; border: 5px solid rgba(255,255,255,0.2);" 
                                         onerror="this.src='https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600&h=450&fit=crop'" 
                                         alt="Tennis y Fragancias">
                                </div>
                                <div class="position-absolute top-0 start-0 translate-middle">
                                    <span class="badge bg-danger rounded-circle p-3 shadow-lg">
                                        <i class="bi bi-lightning-fill fs-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="container py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 hero-content">
                            <div class="badge bg-success mb-3 px-3 py-2">
                                <i class="bi bi-truck me-1"></i>
                                Envíos Gratis
                            </div>
                            <h1 class="hero-title mb-4">
                                Envíos rápidos <br>
                                <span class="text-white">a todo el país</span>
                            </h1>
                            <p class="hero-subtitle mb-4">
                                Compra segura con MercadoPago. Recibe tus productos en la comodidad de tu hogar 
                                con nuestro servicio de envío express.
                            </p>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="<?= Vista::url('productos') ?>" class="btn btn-light btn-lg">
                                    <i class="bi bi-bag-check me-2"></i>Comprar Ahora
                                </a>
                                <a href="<?= Vista::url('inicio/contacto') ?>" class="btn btn-outline-light btn-lg">
                                    <i class="bi bi-headset me-2"></i>Contacto
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center hero-image">
                            <div class="position-relative d-inline-block">
                                <img src="<?= Vista::urlPublica('imagenes/hero-image-2.jpg') ?>" 
                                     class="img-fluid rounded-4 shadow-lg" 
                                     style="max-height:450px; object-fit:cover; border: 5px solid rgba(255,255,255,0.2);" 
                                     onerror="this.src='https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=450&fit=crop'" 
                                     alt="Envíos Rápidos">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="container py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 hero-content">
                            <div class="badge bg-warning text-dark mb-3 px-3 py-2">
                                <i class="bi bi-percent me-1"></i>
                                Ofertas Especiales
                            </div>
                            <h1 class="hero-title mb-4">
                                Descuentos hasta <br>
                                <span class="text-white">50% OFF</span>
                            </h1>
                            <p class="hero-subtitle mb-4">
                                Aprovecha nuestras increíbles ofertas en productos seleccionados. 
                                ¡No dejes pasar esta oportunidad única!
                            </p>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="<?= Vista::url('productos') ?>" class="btn btn-light btn-lg">
                                    <i class="bi bi-tag-fill me-2"></i>Ver Ofertas
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center hero-image">
                            <div class="position-relative d-inline-block">
                                <img src="<?= Vista::urlPublica('imagenes/hero-image-3.jpg') ?>" 
                                     class="img-fluid rounded-4 shadow-lg" 
                                     style="max-height:450px; object-fit:cover; border: 5px solid rgba(255,255,255,0.2);" 
                                     onerror="this.src='https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&h=450&fit=crop'" 
                                     alt="Ofertas Especiales">
                                <div class="position-absolute top-0 end-0">
                                    <span class="badge bg-warning text-dark fs-4 px-4 py-3 shadow-lg rounded-3">
                                        -50%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</section>

<!-- Categorías -->
<?php if (!empty($categorias)): ?>
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Explora Nuestras Categorías</h2>
            <p class="text-muted mt-3">Encuentra exactamente lo que buscas</p>
        </div>
        <div class="row g-4">
            <?php foreach ($categorias as $categoria): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="<?= Vista::url('productos/categoria/' . $categoria['id']) ?>" class="text-decoration-none">
                        <div class="card h-100 text-center producto-card border-0 shadow-sm">
                            <div class="position-relative overflow-hidden">
                                <?php if ($categoria['imagen']): ?>
                                    <img src="<?= Vista::urlPublica('imagenes/categorias/' . $categoria['imagen']) ?>" 
                                         class="card-img-top" 
                                         alt="<?= Vista::escapar($categoria['nombre']) ?>" 
                                         style="height: 200px; object-fit: cover;"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="bg-gradient" style="height: 200px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="bi bi-tag fs-1 text-white"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-dark bg-opacity-75">
                                        <?= $categoria['total_productos'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-1"><?= Vista::escapar($categoria['nombre']) ?></h5>
                                <p class="text-muted small mb-2">
                                    <?= $categoria['total_productos'] ?> producto<?= $categoria['total_productos'] != 1 ? 's' : '' ?>
                                </p>
                                <span class="text-primario small fw-semibold">
                                    Ver todo <i class="bi bi-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Productos Destacados -->
<?php if (!empty($productos_destacados)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Productos Destacados</h2>
            <p class="text-muted mt-3">Lo mejor de nuestra colección</p>
        </div>
        <div class="row g-4">
            <?php foreach ($productos_destacados as $producto): ?>
                <div class="col-6 col-md-6 col-lg-3">
                    <a href="<?= Vista::url('productos/ver/' . $producto['id']) ?>" class="text-decoration-none text-dark d-block">
                    <div class="card h-100 producto-card border-0 shadow-sm position-relative">
                        <div class="position-relative overflow-hidden">
                            <?php if ($producto['imagen_principal']): ?>
                                <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= Vista::escapar($producto['nombre']) ?>" 
                                     style="height: 280px; object-fit: cover;" 
                                     loading="lazy">
                            <?php else: ?>
                                <div class="bg-gradient" style="height: 280px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="bi bi-image fs-1 text-white"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Badge de oferta -->
                            <?php if ($producto['precio_oferta']): ?>
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger px-3 py-2 shadow-sm">
                                        <?php 
                                        $descuento = round((($producto['precio'] - $producto['precio_oferta']) / $producto['precio']) * 100);
                                        echo "-{$descuento}%";
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Badge de stock -->
                            <div class="position-absolute top-0 end-0 m-3">
                                <?php if ($producto['stock'] > 0): ?>
                                    <span class="badge bg-success shadow-sm">
                                        <i class="bi bi-check-circle-fill me-1"></i>Disponible
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger shadow-sm">
                                        <i class="bi bi-x-circle-fill me-1"></i>Agotado
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Overlay con botón al hover -->
                            <div class="position-absolute bottom-0 start-0 end-0 p-3 translate-middle-y" 
                                 style="opacity: 0; transition: opacity 0.3s, transform 0.3s; transform: translateY(20px);">
                                <div class="btn btn-light w-100 shadow">
                                    <i class="bi bi-eye-fill me-2"></i>Ver Detalles
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-light text-dark small">
                                    <?= Vista::escapar($producto['categoria_nombre']) ?>
                                </span>
                            </div>
                            <h5 class="card-title fw-bold mb-3" style="min-height: 48px; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= Vista::escapar($producto['nombre']) ?>
                            </h5>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <?php if ($producto['precio_oferta']): ?>
                                        <div class="d-flex flex-column">
                                            <span class="text-primario fs-4 fw-bold">
                                                <?= Vista::formatearPrecio($producto['precio_oferta']) ?>
                                            </span>
                                            <span class="text-decoration-line-through text-muted small">
                                                <?= Vista::formatearPrecio($producto['precio']) ?>
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <span class="fs-4 fw-bold text-dark">
                                            <?= Vista::formatearPrecio($producto['precio']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="btn btn-primario btn-sm rounded-circle d-lg-none" 
                                     style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="<?= Vista::url('productos') ?>" class="btn btn-primario btn-lg px-5">
                <i class="bi bi-grid-3x3-gap me-2"></i>Ver Todo el Catálogo
            </a>
        </div>
    </div>
</section>

<style>
.producto-card:hover .position-absolute.bottom-0 {
    opacity: 1 !important;
    transform: translateY(0) !important;
}
</style>
<?php endif; ?>

<!-- Características -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-truck fs-1 text-primario"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Envíos a Todo el País</h5>
                        <p class="text-muted mb-0">
                            Entrega rápida y segura. Recibe tu pedido en la puerta de tu casa.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-shield-check fs-1 text-primario"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Compra Segura</h5>
                        <p class="text-muted mb-0">
                            Protección de datos garantizada con MercadoPago.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-arrow-clockwise fs-1 text-primario"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Cambios y Devoluciones</h5>
                        <p class="text-muted mb-0">
                            30 días para cambios. Tu satisfacción es lo primero.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-headset fs-1 text-primario"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Atención al Cliente</h5>
                        <p class="text-muted mb-0">
                            Soporte profesional siempre disponible para ti.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-10px);
}
</style>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

