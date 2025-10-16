<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Encabezado -->
            <div class="text-center mb-5">
                <i class="bi bi-question-circle text-primario" style="font-size: 4rem;"></i>
                <h1 class="fw-bold mt-3">Preguntas Frecuentes</h1>
                <p class="text-muted">Encuentra respuestas a las dudas más comunes</p>
            </div>

            <!-- Buscador -->
            <div class="mb-5">
                <div class="input-group input-group-lg">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="faqSearch" placeholder="Buscar en preguntas frecuentes...">
                </div>
            </div>

            <!-- Categorías -->
            <div class="row g-3 mb-5">
                <div class="col-md-3">
                    <a href="#compras" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card">
                            <i class="bi bi-cart3 text-primario fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Compras</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#envios" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card">
                            <i class="bi bi-truck text-primario fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Envíos</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#pagos" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card">
                            <i class="bi bi-credit-card text-primario fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Pagos</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#productos" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100 hover-card">
                            <i class="bi bi-box-seam text-primario fs-1"></i>
                            <h6 class="fw-bold mt-2 mb-0">Productos</h6>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Preguntas por categoría -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- COMPRAS -->
                    <section id="compras" class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-4">
                            <i class="bi bi-cart3"></i> Compras
                        </h2>
                        
                        <div class="accordion" id="accordionCompras">
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#compra1">
                                        ¿Cómo puedo hacer una compra en Tennis y Fragancias?
                                    </button>
                                </h3>
                                <div id="compra1" class="accordion-collapse collapse show" data-bs-parent="#accordionCompras">
                                    <div class="accordion-body">
                                        <p>Es muy sencillo:</p>
                                        <ol>
                                            <li>Navega por nuestro catálogo y selecciona los productos que desees</li>
                                            <li>Haz clic en "Agregar al carrito"</li>
                                            <li>Revisa tu carrito y procede al checkout</li>
                                            <li>Ingresa tus datos de envío y pago</li>
                                            <li>Confirma tu pedido y ¡listo!</li>
                                        </ol>
                                        <p class="mb-0">Recibirás un correo de confirmación con los detalles de tu compra.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#compra2">
                                        ¿Necesito crear una cuenta para comprar?
                                    </button>
                                </h3>
                                <div id="compra2" class="accordion-collapse collapse" data-bs-parent="#accordionCompras">
                                    <div class="accordion-body">
                                        <p>Sí, es necesario crear una cuenta para realizar compras. Los beneficios incluyen:</p>
                                        <ul>
                                            <li>Seguimiento de tus pedidos</li>
                                            <li>Historial de compras</li>
                                            <li>Direcciones guardadas</li>
                                            <li>Proceso de compra más rápido</li>
                                            <li>Ofertas exclusivas</li>
                                        </ul>
                                        <p class="mb-0">El registro es rápido, gratuito y seguro.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#compra3">
                                        ¿Puedo cancelar o modificar mi pedido?
                                    </button>
                                </h3>
                                <div id="compra3" class="accordion-collapse collapse" data-bs-parent="#accordionCompras">
                                    <div class="accordion-body">
                                        <p>Sí, pero solo antes de que el pedido sea despachado:</p>
                                        <ul>
                                            <li><strong>Para cancelar:</strong> Contáctanos inmediatamente indicando tu número de orden</li>
                                            <li><strong>Para modificar:</strong> Si es cambio de dirección o productos, hazlo antes del despacho</li>
                                        </ul>
                                        <p class="mb-0">Una vez enviado, aplican nuestras políticas de cambios y devoluciones.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#compra4">
                                        ¿Cómo sé si mi pedido fue confirmado?
                                    </button>
                                </h3>
                                <div id="compra4" class="accordion-collapse collapse" data-bs-parent="#accordionCompras">
                                    <div class="accordion-body">
                                        <p>Recibirás dos confirmaciones:</p>
                                        <ol>
                                            <li><strong>Confirmación inmediata:</strong> En pantalla al finalizar la compra</li>
                                            <li><strong>Email de confirmación:</strong> Con todos los detalles del pedido (revisa spam si no lo ves)</li>
                                        </ol>
                                        <p class="mb-0">También puedes verificar en tu cuenta, en la sección "Mis Pedidos".</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- ENVÍOS -->
                    <section id="envios" class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-4">
                            <i class="bi bi-truck"></i> Envíos
                        </h2>
                        
                        <div class="accordion" id="accordionEnvios">
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio1">
                                        ¿Cuánto tarda en llegar mi pedido?
                                    </button>
                                </h3>
                                <div id="envio1" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p>Los tiempos de entrega varían según tu ubicación:</p>
                                        <ul>
                                            <li><strong>Ciudades principales:</strong> 2-3 días hábiles</li>
                                            <li><strong>Otras ciudades:</strong> 3-5 días hábiles</li>
                                            <li><strong>Municipios y zonas rurales:</strong> 4-7 días hábiles</li>
                                        </ul>
                                        <p class="mb-0">Más 1-2 días de procesamiento del pedido. Ver más en <a href="<?= Vista::url('inicio/envios') ?>">Envíos y Entregas</a>.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio2">
                                        ¿Cuánto cuesta el envío?
                                    </button>
                                </h3>
                                <div id="envio2" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p><strong>¡Envío gratis en compras mayores a $150,000!</strong></p>
                                        <p>Para montos menores:</p>
                                        <ul>
                                            <li>$100,000 - $149,999: $12,000</li>
                                            <li>$50,000 - $99,999: $15,000</li>
                                            <li>Menos de $50,000: $18,000</li>
                                        </ul>
                                        <p class="mb-0">El costo exacto se calcula según tu ciudad al finalizar la compra.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio3">
                                        ¿Cómo puedo rastrear mi pedido?
                                    </button>
                                </h3>
                                <div id="envio3" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p>Tienes dos opciones:</p>
                                        <ol>
                                            <li><strong>En tu cuenta:</strong> Ingresa a "Mis Pedidos" y verás el estado actualizado</li>
                                            <li><strong>Con número de guía:</strong> Te lo enviamos por correo cuando despachamos. Úsalo en el sitio de la transportadora</li>
                                        </ol>
                                        <p class="mb-0">También recibirás notificaciones por email en cada etapa del envío.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio4">
                                        ¿Entregan a domicilio o debo recoger el paquete?
                                    </button>
                                </h3>
                                <div id="envio4" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p>Por defecto, entregamos a domicilio en la dirección que proporcionaste.</p>
                                        <p>Sin embargo, en algunas ciudades también puedes:</p>
                                        <ul>
                                            <li>Recoger en oficinas de la transportadora</li>
                                            <li>Coordinar entrega en punto autorizado</li>
                                        </ul>
                                        <p class="mb-0">Si no hay nadie para recibir, la transportadora dejará un aviso e intentará nuevamente al día siguiente.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- PAGOS -->
                    <section id="pagos" class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-4">
                            <i class="bi bi-credit-card"></i> Pagos y Facturación
                        </h2>
                        
                        <div class="accordion" id="accordionPagos">
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pago1">
                                        ¿Qué métodos de pago aceptan?
                                    </button>
                                </h3>
                                <div id="pago1" class="accordion-collapse collapse" data-bs-parent="#accordionPagos">
                                    <div class="accordion-body">
                                        <p>Aceptamos los siguientes métodos:</p>
                                        <ul>
                                            <li><strong>Tarjetas:</strong> Crédito y débito (Visa, Mastercard, American Express)</li>
                                            <li><strong>MercadoPago:</strong> Todos los métodos disponibles en la plataforma</li>
                                            <li><strong>Transferencia bancaria:</strong> Debes enviarnos el comprobante</li>
                                            <li><strong>Pago contra entrega:</strong> En algunas ciudades (sujeto a disponibilidad)</li>
                                        </ul>
                                        <p class="mb-0">Todos los pagos son procesados de forma segura con encriptación SSL.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pago2">
                                        ¿Es seguro pagar en su sitio?
                                    </button>
                                </h3>
                                <div id="pago2" class="accordion-collapse collapse" data-bs-parent="#accordionPagos">
                                    <div class="accordion-body">
                                        <p><strong>¡Totalmente seguro!</strong> Implementamos las siguientes medidas:</p>
                                        <ul>
                                            <li>Encriptación SSL/TLS en todas las transacciones</li>
                                            <li>No almacenamos datos completos de tarjetas</li>
                                            <li>Procesadores de pago certificados (PCI DSS)</li>
                                            <li>Protección contra fraude</li>
                                        </ul>
                                        <p class="mb-0">Ver más en nuestra <a href="<?= Vista::url('inicio/privacidad') ?>">Política de Privacidad</a>.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pago3">
                                        ¿Cuándo se cobra el pago?
                                    </button>
                                </h3>
                                <div id="pago3" class="accordion-collapse collapse" data-bs-parent="#accordionPagos">
                                    <div class="accordion-body">
                                        <p>Depende del método de pago:</p>
                                        <ul>
                                            <li><strong>Tarjetas y MercadoPago:</strong> Inmediatamente al confirmar el pedido</li>
                                            <li><strong>Transferencia:</strong> Debes realizarla y enviarnos el comprobante. Despachamos al confirmar el pago</li>
                                            <li><strong>Contra entrega:</strong> Al recibir el producto</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pago4">
                                        ¿Emiten factura?
                                    </button>
                                </h3>
                                <div id="pago4" class="accordion-collapse collapse" data-bs-parent="#accordionPagos">
                                    <div class="accordion-body">
                                        <p>Sí, emitimos factura electrónica para todas las compras, conforme a la legislación colombiana.</p>
                                        <p>La recibirás por correo electrónico y también estará disponible para descarga en tu cuenta.</p>
                                        <p class="mb-0">Si necesitas datos específicos para la facturación, indícalo al momento de la compra.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- PRODUCTOS -->
                    <section id="productos" class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-4">
                            <i class="bi bi-box-seam"></i> Productos
                        </h2>
                        
                        <div class="accordion" id="accordionProductos">
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prod1">
                                        ¿Los productos son originales?
                                    </button>
                                </h3>
                                <div id="prod1" class="accordion-collapse collapse" data-bs-parent="#accordionProductos">
                                    <div class="accordion-body">
                                        <p><strong>¡100% originales y auténticos!</strong></p>
                                        <p>Todos nuestros productos provienen de:</p>
                                        <ul>
                                            <li>Distribuidores autorizados</li>
                                            <li>Importadores oficiales</li>
                                            <li>Marcas reconocidas</li>
                                        </ul>
                                        <p class="mb-0">Garantizamos la autenticidad de cada producto que vendemos.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prod2">
                                        ¿Tienen garantía los productos?
                                    </button>
                                </h3>
                                <div id="prod2" class="accordion-collapse collapse" data-bs-parent="#accordionProductos">
                                    <div class="accordion-body">
                                        <p>Sí, todos nuestros productos tienen garantía:</p>
                                        <ul>
                                            <li><strong>Calzado:</strong> 3 meses contra defectos de fabricación</li>
                                            <li><strong>Fragancias:</strong> Garantía de autenticidad</li>
                                            <li><strong>Accesorios:</strong> 30 días</li>
                                        </ul>
                                        <p class="mb-0">Ver más en <a href="<?= Vista::url('inicio/devoluciones') ?>">Cambios y Devoluciones</a>.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prod3">
                                        ¿Cómo sé qué talla elegir?
                                    </button>
                                </h3>
                                <div id="prod3" class="accordion-collapse collapse" data-bs-parent="#accordionProductos">
                                    <div class="accordion-body">
                                        <p>Cada producto incluye información de tallas. Te recomendamos:</p>
                                        <ul>
                                            <li>Medir tu pie y comparar con la guía de tallas</li>
                                            <li>Leer los comentarios de otros compradores</li>
                                            <li>Si estás entre dos tallas, elige la mayor</li>
                                        </ul>
                                        <p class="mb-0">Si te equivocas, puedes cambiar la talla sin problema. Ver <a href="<?= Vista::url('inicio/devoluciones') ?>">política de cambios</a>.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prod4">
                                        ¿Puedo devolver un producto si no me gusta?
                                    </button>
                                </h3>
                                <div id="prod4" class="accordion-collapse collapse" data-bs-parent="#accordionProductos">
                                    <div class="accordion-body">
                                        <p>Sí, tienes <strong>30 días</strong> para cambios y devoluciones, siempre que:</p>
                                        <ul>
                                            <li>El producto esté sin uso</li>
                                            <li>Conserve su empaque y etiquetas</li>
                                            <li>Tengas el comprobante de compra</li>
                                        </ul>
                                        <p class="mb-0">Excepciones: Fragancias abiertas, productos en liquidación o personalizados. Ver más en <a href="<?= Vista::url('inicio/devoluciones') ?>">Cambios y Devoluciones</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- CUENTA Y SEGURIDAD -->
                    <section id="cuenta" class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-4">
                            <i class="bi bi-person-circle"></i> Cuenta y Seguridad
                        </h2>
                        
                        <div class="accordion" id="accordionCuenta">
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cuenta1">
                                        ¿Cómo recupero mi contraseña?
                                    </button>
                                </h3>
                                <div id="cuenta1" class="accordion-collapse collapse" data-bs-parent="#accordionCuenta">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Ve a la página de <a href="<?= Vista::url('auth/login') ?>">inicio de sesión</a></li>
                                            <li>Haz clic en "¿Olvidaste tu contraseña?"</li>
                                            <li>Ingresa tu correo electrónico</li>
                                            <li>Recibirás un enlace para restablecer tu contraseña</li>
                                            <li>Crea una nueva contraseña segura</li>
                                        </ol>
                                        <p class="mb-0">Si no recibes el correo, revisa tu carpeta de spam.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cuenta2">
                                        ¿Cómo actualizo mis datos personales?
                                    </button>
                                </h3>
                                <div id="cuenta2" class="accordion-collapse collapse" data-bs-parent="#accordionCuenta">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Inicia sesión en tu cuenta</li>
                                            <li>Ve a <a href="<?= Vista::url('perfil') ?>">Mi Perfil</a></li>
                                            <li>Haz clic en "Editar Perfil"</li>
                                            <li>Actualiza los datos que necesites</li>
                                            <li>Guarda los cambios</li>
                                        </ol>
                                        <p class="mb-0">Puedes actualizar tu nombre, dirección, teléfono y otros datos en cualquier momento.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item faq-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cuenta3">
                                        ¿Qué hacen con mis datos personales?
                                    </button>
                                </h3>
                                <div id="cuenta3" class="accordion-collapse collapse" data-bs-parent="#accordionCuenta">
                                    <div class="accordion-body">
                                        <p>Protegemos y respetamos tu privacidad:</p>
                                        <ul>
                                            <li>Solo usamos tus datos para procesar pedidos y mejorar tu experiencia</li>
                                            <li>No vendemos ni compartimos tu información con terceros</li>
                                            <li>Implementamos medidas de seguridad robustas</li>
                                            <li>Cumplimos con la legislación colombiana de protección de datos</li>
                                        </ul>
                                        <p class="mb-0">Lee más en nuestra <a href="<?= Vista::url('inicio/privacidad') ?>">Política de Privacidad</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Contacto -->
                    <section class="text-center">
                        <div class="bg-light p-4 rounded">
                            <h3 class="fw-bold mb-3">¿No encontraste lo que buscabas?</h3>
                            <p class="mb-3">Nuestro equipo está listo para ayudarte</p>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <a href="<?= Vista::url('inicio/contacto') ?>" class="btn btn-primario">
                                    <i class="bi bi-envelope"></i> Contáctanos
                                </a>
                                <a href="tel:+57" class="btn btn-outline-dark">
                                    <i class="bi bi-telephone"></i> Llamar Ahora
                                </a>
                            </div>
                        </div>
                    </section>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
    cursor: pointer;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
}
.faq-item {
    border: none;
    margin-bottom: 1rem;
}
.faq-item .accordion-button {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
}
.faq-item .accordion-button:not(.collapsed) {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}
.faq-item .accordion-body {
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 0.5rem 0.5rem;
}
</style>

<script>
// Buscador de FAQs
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

