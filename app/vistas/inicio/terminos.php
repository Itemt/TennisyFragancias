<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Encabezado -->
            <div class="text-center mb-5">
                <i class="bi bi-file-text text-primario" style="font-size: 4rem;"></i>
                <h1 class="fw-bold mt-3">Términos y Condiciones</h1>
                <p class="text-muted">Última actualización: <?= date('d/m/Y') ?></p>
            </div>

            <!-- Contenido -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">1. Aceptación de los Términos</h2>
                        <p>Bienvenido a Tennis y Fragancias. Al acceder y utilizar nuestro sitio web, aceptas estar sujeto a estos Términos y Condiciones, todas las leyes y regulaciones aplicables. Si no estás de acuerdo con alguno de estos términos, no debes utilizar este sitio.</p>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Importante:</strong> Estos términos constituyen un acuerdo legal vinculante entre tú y Tennis y Fragancias.
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">2. Definiciones</h2>
                        <ul>
                            <li><strong>"Sitio":</strong> Se refiere al sitio web de Tennis y Fragancias</li>
                            <li><strong>"Usuario":</strong> Cualquier persona que acceda y utilice el Sitio</li>
                            <li><strong>"Cliente":</strong> Usuario que realiza una compra</li>
                            <li><strong>"Productos":</strong> Artículos de calzado, fragancias y accesorios ofrecidos en venta</li>
                            <li><strong>"Nosotros/Nuestra Empresa":</strong> Tennis y Fragancias</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">3. Uso del Sitio Web</h2>
                        
                        <h3 class="h5 fw-bold mt-4 mb-3">3.1 Elegibilidad</h3>
                        <p>Para utilizar nuestro sitio y realizar compras, debes:</p>
                        <ul>
                            <li>Ser mayor de 18 años o tener el consentimiento de un tutor legal</li>
                            <li>Tener capacidad legal para celebrar contratos vinculantes</li>
                            <li>Proporcionar información verdadera, precisa y completa</li>
                            <li>Mantener actualizada tu información de cuenta</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">3.2 Cuenta de Usuario</h3>
                        <p>Al crear una cuenta, te comprometes a:</p>
                        <ul>
                            <li>Mantener la confidencialidad de tu contraseña</li>
                            <li>Ser responsable de todas las actividades bajo tu cuenta</li>
                            <li>Notificarnos inmediatamente de cualquier uso no autorizado</li>
                            <li>No compartir tu cuenta con terceros</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">3.3 Uso Prohibido</h3>
                        <p>No está permitido:</p>
                        <ul>
                            <li>Usar el sitio para fines ilegales o no autorizados</li>
                            <li>Intentar acceder a áreas no autorizadas del sistema</li>
                            <li>Transmitir virus, malware o código malicioso</li>
                            <li>Realizar scraping o recopilación automática de datos</li>
                            <li>Hacerse pasar por otra persona o entidad</li>
                            <li>Interferir con el funcionamiento del sitio</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">4. Productos y Precios</h2>
                        
                        <h3 class="h5 fw-bold mt-4 mb-3">4.1 Descripción de Productos</h3>
                        <p>Nos esforzamos por describir nuestros productos con precisión. Sin embargo:</p>
                        <ul>
                            <li>Los colores pueden variar según tu pantalla</li>
                            <li>Las imágenes son referenciales</li>
                            <li>Nos reservamos el derecho de corregir errores de descripción</li>
                            <li>La disponibilidad está sujeta a existencias</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">4.2 Precios</h3>
                        <ul>
                            <li>Todos los precios están expresados en Pesos Colombianos (COP)</li>
                            <li>Los precios incluyen IVA (cuando aplique)</li>
                            <li>Los costos de envío se calculan al finalizar la compra</li>
                            <li>Nos reservamos el derecho de modificar precios sin previo aviso</li>
                            <li>En caso de error evidente en el precio, podemos cancelar el pedido</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">4.3 Disponibilidad</h3>
                        <p>Si un producto no está disponible después de confirmar tu pedido:</p>
                        <ul>
                            <li>Te contactaremos para ofrecerte alternativas</li>
                            <li>Puedes elegir esperar o cancelar el pedido</li>
                            <li>Se realizará el reembolso completo si cancelas</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">5. Proceso de Compra</h2>
                        
                        <h3 class="h5 fw-bold mt-4 mb-3">5.1 Realización del Pedido</h3>
                        <ol>
                            <li>Selecciona los productos y agrégalos al carrito</li>
                            <li>Revisa tu pedido y procede al checkout</li>
                            <li>Proporciona información de envío y pago</li>
                            <li>Confirma y completa el pago</li>
                            <li>Recibirás un correo de confirmación</li>
                        </ol>

                        <h3 class="h5 fw-bold mt-4 mb-3">5.2 Confirmación</h3>
                        <p>La confirmación del pedido no constituye aceptación de la orden. Nos reservamos el derecho de rechazar pedidos por:</p>
                        <ul>
                            <li>Falta de disponibilidad</li>
                            <li>Error en precio o descripción</li>
                            <li>Problemas con el método de pago</li>
                            <li>Detección de fraude</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">5.3 Cancelación de Pedidos</h3>
                        <p>Puedes cancelar tu pedido antes del envío contactándonos. Una vez enviado, aplican nuestras políticas de devolución.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">6. Pago</h2>
                        
                        <h3 class="h5 fw-bold mt-4 mb-3">6.1 Métodos de Pago</h3>
                        <p>Aceptamos los siguientes métodos:</p>
                        <ul>
                            <li>Tarjetas de crédito y débito</li>
                            <li>MercadoPago</li>
                            <li>Transferencias bancarias</li>
                            <li>Pago contra entrega (según disponibilidad)</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">6.2 Seguridad del Pago</h3>
                        <ul>
                            <li>Utilizamos encriptación SSL para proteger tus datos</li>
                            <li>No almacenamos información completa de tarjetas</li>
                            <li>Los pagos son procesados por proveedores certificados</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">6.3 Facturación</h3>
                        <p>Recibirás una factura electrónica por cada compra realizada, conforme a la legislación fiscal colombiana.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">7. Propiedad Intelectual</h2>
                        <p>Todo el contenido del sitio, incluyendo textos, gráficos, logos, imágenes, software, es propiedad de Tennis y Fragancias o sus proveedores y está protegido por leyes de propiedad intelectual.</p>
                        <p><strong>No está permitido:</strong></p>
                        <ul>
                            <li>Reproducir, distribuir o modificar cualquier contenido</li>
                            <li>Usar nuestras marcas sin autorización escrita</li>
                            <li>Crear trabajos derivados del contenido del sitio</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">8. Limitación de Responsabilidad</h2>
                        <p>Tennis y Fragancias no será responsable por:</p>
                        <ul>
                            <li>Daños indirectos, incidentales o consecuentes</li>
                            <li>Pérdida de ganancias, datos o uso</li>
                            <li>Interrupciones del servicio</li>
                            <li>Errores u omisiones en el contenido</li>
                            <li>Productos no disponibles o defectuosos (más allá de reemplazo/reembolso)</li>
                        </ul>
                        <p>Nuestra responsabilidad máxima se limita al monto pagado por el producto en cuestión.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">9. Indemnización</h2>
                        <p>Aceptas indemnizar y mantener indemne a Tennis y Fragancias de cualquier reclamo, pérdida o daño derivado de:</p>
                        <ul>
                            <li>Tu uso del sitio</li>
                            <li>Violación de estos términos</li>
                            <li>Violación de derechos de terceros</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">10. Modificaciones</h2>
                        <p>Nos reservamos el derecho de modificar estos Términos y Condiciones en cualquier momento. Los cambios serán efectivos al ser publicados en el sitio. Tu uso continuado del sitio constituye aceptación de los términos modificados.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">11. Ley Aplicable y Jurisdicción</h2>
                        <p>Estos términos se rigen por las leyes de la República de Colombia. Cualquier disputa será resuelta en los tribunales competentes de Barrancabermeja, Santander, Colombia.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">12. Resolución de Disputas</h2>
                        <p>En caso de cualquier controversia:</p>
                        <ol>
                            <li>Intenta resolver el problema contactando nuestro servicio al cliente</li>
                            <li>Si no se resuelve, considera la mediación antes de litigio</li>
                            <li>Ambas partes renuncian al derecho de participar en demandas colectivas</li>
                        </ol>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold text-primario mb-3">13. Contacto</h2>
                        <p>Para preguntas sobre estos Términos y Condiciones:</p>
                        <div class="bg-light p-4 rounded mt-3">
                            <p class="mb-2"><strong>Tennis y Fragancias</strong></p>
                            <p class="mb-2"><i class="bi bi-geo-alt"></i> Barrancabermeja, Santander, Colombia</p>
                            <p class="mb-2"><i class="bi bi-envelope"></i> Email: <a href="mailto:legal@tennisyfragancias.com">legal@tennisyfragancias.com</a></p>
                            <p class="mb-0"><i class="bi bi-telephone"></i> Teléfono: +57 (7) XXX-XXXX</p>
                        </div>
                    </section>

                </div>
            </div>

            <!-- Navegación adicional -->
            <div class="mt-4 text-center">
                <p class="text-muted">También te puede interesar:</p>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="<?= Vista::url('inicio/privacidad') ?>" class="btn btn-outline-primary btn-sm">Política de Privacidad</a>
                    <a href="<?= Vista::url('inicio/devoluciones') ?>" class="btn btn-outline-primary btn-sm">Cambios y Devoluciones</a>
                    <a href="<?= Vista::url('inicio/envios') ?>" class="btn btn-outline-primary btn-sm">Envíos y Entregas</a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

