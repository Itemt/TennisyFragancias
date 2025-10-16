    </main>
    
    <!-- Footer -->
    <footer class="mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="text-primario">Tennis y Fragancias</h5>
                    <p class="small">
                        Tu tienda de confianza en Barrancabermeja para los mejores tenis y fragancias.
                    </p>
                    <p class="small">
                        <i class="bi bi-geo-alt"></i> Barrancabermeja, Santander, Colombia<br>
                        <i class="bi bi-telephone"></i> <?= EMPRESA_TELEFONO ?><br>
                        <i class="bi bi-envelope"></i> <?= EMPRESA_EMAIL ?>
                    </p>
                </div>
                
                <div class="col-md-2 mb-3">
                    <h6>Enlaces</h6>
                    <ul class="list-unstyled small">
                        <li><a href="<?= Vista::url() ?>">Inicio</a></li>
                        <li><a href="<?= Vista::url('productos') ?>">Productos</a></li>
                        <li><a href="<?= Vista::url('inicio/sobre_nosotros') ?>">Sobre Nosotros</a></li>
                        <li><a href="<?= Vista::url('inicio/contacto') ?>">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-3">
                    <h6>Información</h6>
                    <ul class="list-unstyled small">
                        <li><a href="#">Política de Privacidad</a></li>
                        <li><a href="#">Términos y Condiciones</a></li>
                        <li><a href="#">Cambios y Devoluciones</a></li>
                        <li><a href="#">Envíos</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-3">
                    <h6>Síguenos</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            
            <hr class="border-secondary">
            
            <div class="row">
                <div class="col-md-12 text-center small">
                    <p class="mb-0">&copy; <?= date('Y') ?> Tennis y Fragancias. Todos los derechos reservados.</p>
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

