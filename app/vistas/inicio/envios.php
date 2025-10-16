<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Encabezado -->
            <div class="text-center mb-5">
                <i class="bi bi-truck text-primario" style="font-size: 4rem;"></i>
                <h1 class="fw-bold mt-3">Envíos y Entregas</h1>
                <p class="text-muted">Llevamos tus productos de forma rápida y segura</p>
            </div>

            <!-- Tarjetas de beneficios -->
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-3">
                        <i class="bi bi-box-seam text-primario" style="font-size: 2.5rem;"></i>
                        <h5 class="fw-bold mt-2">Envío Gratis</h5>
                        <p class="small mb-0">En compras superiores a $150,000</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-3">
                        <i class="bi bi-clock text-primario" style="font-size: 2.5rem;"></i>
                        <h5 class="fw-bold mt-2">Envío Rápido</h5>
                        <p class="small mb-0">2-5 días hábiles a todo Colombia</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-3">
                        <i class="bi bi-shield-check text-primario" style="font-size: 2.5rem;"></i>
                        <h5 class="fw-bold mt-2">Envío Seguro</h5>
                        <p class="small mb-0">Empaque protegido y asegurado</p>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">1. Cobertura de Envíos</h2>
                        <p>Realizamos envíos a <strong>todo el territorio colombiano</strong> a través de nuestros aliados logísticos de confianza.</p>
                        
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <h5 class="fw-bold mb-2"><i class="bi bi-geo-alt text-primario"></i> Ciudades Principales</h5>
                                    <ul class="small mb-0">
                                        <li>Bogotá</li>
                                        <li>Medellín</li>
                                        <li>Cali</li>
                                        <li>Barranquilla</li>
                                        <li>Cartagena</li>
                                        <li>Bucaramanga</li>
                                        <li>Y más...</li>
                                    </ul>
                                    <p class="small mb-0 mt-2"><strong>Tiempo estimado:</strong> 2-3 días hábiles</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <h5 class="fw-bold mb-2"><i class="bi bi-geo text-primario"></i> Municipios y Zonas Rurales</h5>
                                    <p class="small mb-2">Llegamos a la mayoría de municipios del país.</p>
                                    <p class="small mb-0"><strong>Tiempo estimado:</strong> 4-7 días hábiles</p>
                                    <p class="small text-muted mt-2">Algunos municipios pueden tener costos adicionales de envío.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">2. Costos de Envío</h2>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Monto de Compra</th>
                                        <th>Costo de Envío</th>
                                        <th>Tiempo Estimado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td><strong>Mayor a $150,000</strong></td>
                                        <td><strong class="text-success">GRATIS</strong></td>
                                        <td>2-5 días hábiles</td>
                                    </tr>
                                    <tr>
                                        <td>$100,000 - $149,999</td>
                                        <td>$12,000</td>
                                        <td>2-5 días hábiles</td>
                                    </tr>
                                    <tr>
                                        <td>$50,000 - $99,999</td>
                                        <td>$15,000</td>
                                        <td>3-6 días hábiles</td>
                                    </tr>
                                    <tr>
                                        <td>Menos de $50,000</td>
                                        <td>$18,000</td>
                                        <td>3-6 días hábiles</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle"></i> Los costos pueden variar según la ciudad de destino. El costo exacto se calcula automáticamente al finalizar tu compra.
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">3. Tiempos de Procesamiento</h2>
                        
                        <h3 class="h5 fw-bold mt-4 mb-3">3.1 Preparación del Pedido</h3>
                        <p>Una vez confirmado tu pago, nuestro proceso es el siguiente:</p>
                        <div class="bg-light p-4 rounded">
                            <ol class="mb-0">
                                <li class="mb-2"><strong>Confirmación:</strong> Inmediata (recibes correo de confirmación)</li>
                                <li class="mb-2"><strong>Alistamiento:</strong> 1-2 días hábiles</li>
                                <li class="mb-2"><strong>Despacho:</strong> Enviamos con transportadora</li>
                                <li class="mb-0"><strong>Entrega:</strong> Según tiempo estimado de envío</li>
                            </ol>
                        </div>

                        <h3 class="h5 fw-bold mt-4 mb-3">3.2 Excepciones</h3>
                        <ul>
                            <li><strong>Pedidos antes de las 2:00 PM:</strong> Se despachan el mismo día</li>
                            <li><strong>Fines de semana:</strong> Se procesan el siguiente día hábil</li>
                            <li><strong>Festivos:</strong> Puede haber demoras adicionales</li>
                            <li><strong>Alta demanda:</strong> Black Friday, Navidad (1-2 días extra)</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">4. Seguimiento de Pedido</h2>
                        
                        <p>Mantente informado en todo momento sobre el estado de tu pedido:</p>
                        
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <div class="card border-primary h-100">
                                    <div class="card-body">
                                        <h5 class="fw-bold"><i class="bi bi-envelope text-primario"></i> Por Correo Electrónico</h5>
                                        <p class="small mb-2">Recibirás notificaciones en cada etapa:</p>
                                        <ul class="small mb-0">
                                            <li>Pedido confirmado</li>
                                            <li>Pedido en preparación</li>
                                            <li>Pedido despachado (con guía)</li>
                                            <li>Pedido entregado</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-primary h-100">
                                    <div class="card-body">
                                        <h5 class="fw-bold"><i class="bi bi-person-circle text-primario"></i> En Tu Cuenta</h5>
                                        <p class="small mb-2">Accede a tu panel de usuario para:</p>
                                        <ul class="small mb-0">
                                            <li>Ver estado actual</li>
                                            <li>Rastrear con número de guía</li>
                                            <li>Descargar factura</li>
                                            <li>Historial completo</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Importante:</strong> Guarda el número de guía que te enviamos. Te permitirá rastrear tu paquete en el sitio de la transportadora.
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">5. Proceso de Entrega</h2>
                        
                        <h3 class="h5 fw-bold mt-4 mb-3">5.1 Recepción del Paquete</h3>
                        <p>Al momento de recibir tu pedido:</p>
                        <ol>
                            <li><strong>Verifica el paquete:</strong> Revisa que esté en buen estado</li>
                            <li><strong>Identifícate:</strong> Presenta cédula o documento de identidad</li>
                            <li><strong>Firma la guía:</strong> Confirma la recepción</li>
                            <li><strong>Inspecciona el contenido:</strong> Abre y verifica que todo esté correcto</li>
                        </ol>

                        <h3 class="h5 fw-bold mt-4 mb-3">5.2 ¿Nadie en Casa?</h3>
                        <p>Si no hay nadie para recibir el pedido:</p>
                        <ul>
                            <li>La transportadora dejará un aviso</li>
                            <li>Harán un segundo intento al día siguiente</li>
                            <li>Después de 3 intentos, el paquete retorna a bodega</li>
                            <li>Puedes coordinar reenvío o recoger en punto autorizado</li>
                        </ul>

                        <h3 class="h5 fw-bold mt-4 mb-3">5.3 Puntos de Recogida</h3>
                        <p>En algunas ciudades, puedes recoger tu pedido en:</p>
                        <ul>
                            <li>Oficinas de la transportadora</li>
                            <li>Puntos autorizados (tiendas aliadas)</li>
                            <li>Coordinando con el repartidor</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">6. Problemas con el Envío</h2>
                        
                        <div class="accordion" id="accordionEnvios">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio1">
                                        ¿Qué hago si mi paquete llega dañado?
                                    </button>
                                </h3>
                                <div id="envio1" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p><strong>NO firmes la guía</strong> y contacta inmediatamente a nuestro servicio al cliente. Toma fotos del paquete dañado. Gestionaremos un reenvío o reembolso sin costo adicional.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio2">
                                        Mi pedido no ha llegado en el tiempo estimado
                                    </button>
                                </h3>
                                <div id="envio2" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p>Los tiempos son estimados y pueden variar. Si han pasado más de 2 días del tiempo máximo estimado, contáctanos con tu número de orden. Rastrearemos tu pedido y te daremos una solución inmediata.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio3">
                                        ¿Puedo cambiar la dirección de envío?
                                    </button>
                                </h3>
                                <div id="envio3" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p>Sí, pero solo antes de que el pedido sea despachado. Una vez enviado, no es posible cambiar la dirección. Contáctanos lo antes posible si necesitas hacer un cambio.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#envio4">
                                        ¿Entregan en zonas rurales?
                                    </button>
                                </h3>
                                <div id="envio4" class="accordion-collapse collapse" data-bs-parent="#accordionEnvios">
                                    <div class="accordion-body">
                                        <p>Sí, llegamos a la mayoría de zonas rurales, aunque puede haber costos adicionales y tiempos de entrega más largos. Verifica la disponibilidad ingresando tu dirección al finalizar la compra.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-primario mb-3">7. Transportadoras Aliadas</h2>
                        <p>Trabajamos con las mejores empresas de logística de Colombia:</p>
                        <div class="row g-3 mt-2">
                            <div class="col-md-4 text-center">
                                <div class="p-3 bg-light rounded">
                                    <i class="bi bi-box-seam fs-1 text-primario"></i>
                                    <p class="fw-bold mb-0 mt-2">Servientrega</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3 bg-light rounded">
                                    <i class="bi bi-box-seam fs-1 text-primario"></i>
                                    <p class="fw-bold mb-0 mt-2">Coordinadora</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3 bg-light rounded">
                                    <i class="bi bi-box-seam fs-1 text-primario"></i>
                                    <p class="fw-bold mb-0 mt-2">Interrapidísimo</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold text-primario mb-3">8. Contacto para Envíos</h2>
                        <p>¿Tienes preguntas sobre tu envío?</p>
                        <div class="bg-light p-4 rounded mt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="bi bi-envelope"></i> Email:</strong></p>
                                    <p><a href="mailto:envios@tennisyfragancias.com">envios@tennisyfragancias.com</a></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="bi bi-telephone"></i> Teléfono:</strong></p>
                                    <p>+57 (7) XXX-XXXX<br>
                                    <small class="text-muted">Lunes a Viernes: 8:00 AM - 6:00 PM<br>Sábados: 9:00 AM - 1:00 PM</small></p>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>

            <!-- Navegación adicional -->
            <div class="mt-4 text-center">
                <p class="text-muted">También te puede interesar:</p>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="<?= Vista::url('inicio/devoluciones') ?>" class="btn btn-outline-primary btn-sm">Cambios y Devoluciones</a>
                    <a href="<?= Vista::url('inicio/faq') ?>" class="btn btn-outline-primary btn-sm">Preguntas Frecuentes</a>
                    <a href="<?= Vista::url('pedidos') ?>" class="btn btn-primario btn-sm">Rastrear Pedido</a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

