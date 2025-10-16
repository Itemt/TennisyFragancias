    </main>
    
    <!-- Footer Moderno -->
    <footer class="mt-5 pt-5 pb-4">
        <div class="container">
            <div class="row g-4 mb-4">
                <!-- Información Principal -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-primario mb-3">
                        <i class="bi bi-bag-heart-fill me-2"></i>Tennis y Fragancias
                    </h5>
                    <p class="mb-3" style="opacity: 0.9; line-height: 1.7;">
                        Tu tienda de confianza en Barrancabermeja para los mejores tenis y fragancias. 
                        Calidad garantizada y atención personalizada.
                    </p>
                    <div class="mb-2">
                        <i class="bi bi-geo-alt-fill text-primario me-2"></i>
                        <span>Barrancabermeja, Santander, Colombia</span>
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-telephone-fill text-primario me-2"></i>
                        <a href="tel:<?= EMPRESA_TELEFONO ?>" class="text-decoration-none"><?= EMPRESA_TELEFONO ?></a>
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-envelope-fill text-primario me-2"></i>
                        <a href="mailto:<?= EMPRESA_EMAIL ?>" class="text-decoration-none"><?= EMPRESA_EMAIL ?></a>
                    </div>
                </div>
                
                <!-- Enlaces Rápidos -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Enlaces Rápidos</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= Vista::url() ?>">
                                <i class="bi bi-chevron-right me-1"></i>Inicio
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= Vista::url('productos') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Productos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= Vista::url('inicio/sobre_nosotros') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Sobre Nosotros
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= Vista::url('inicio/contacto') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Contacto
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Información Legal -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Información</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= Vista::url('inicio/privacidad') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Política de Privacidad
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= Vista::url('inicio/terminos') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Términos y Condiciones
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= Vista::url('inicio/devoluciones') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Cambios y Devoluciones
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= Vista::url('inicio/envios') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Envíos y Entregas
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= Vista::url('inicio/faq') ?>">
                                <i class="bi bi-chevron-right me-1"></i>Preguntas Frecuentes
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Redes Sociales y Newsletter -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Síguenos</h6>
                    <p class="mb-3" style="opacity: 0.9;">
                        Mantente al día con nuestras últimas ofertas y novedades
                    </p>
                    <div class="social-links d-flex gap-2 mb-4">
                        <a href="#" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="#" title="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </div>
                    
                    <!-- Newsletter simple -->
                    <div class="newsletter-box">
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" placeholder="Tu email" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                            <button class="btn btn-primario btn-sm" type="button">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr style="border-color: rgba(255,255,255,0.2); margin: 2rem 0 1.5rem;">
            
            <!-- Copyright y Pagos -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0" style="opacity: 0.8;">
                        &copy; <?= date('Y') ?> <strong>Tennis y Fragancias</strong>. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small style="opacity: 0.8;">
                        <i class="bi bi-credit-card me-2"></i>
                        Pagos seguros con 
                        <strong class="text-primario">MercadoPago</strong>
                    </small>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para contador de carrito -->
    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_rol'] === ROL_CLIENTE): ?>
    <script>
        // Actualizar contador del carrito
        function actualizarContadorCarrito() {
            fetch('<?= Vista::url("carrito/contar") ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.total > 0) {
                        document.getElementById('carrito-contador').textContent = data.total;
                        document.getElementById('carrito-contador').style.display = 'inline-block';
                    } else {
                        document.getElementById('carrito-contador').style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        
        // Actualizar al cargar la página
        document.addEventListener('DOMContentLoaded', actualizarContadorCarrito);
    </script>
    <?php endif; ?>
    
    <script>
        // Auto-cerrar alertas después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>

