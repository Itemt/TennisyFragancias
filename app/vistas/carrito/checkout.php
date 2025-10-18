<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-4">Finalizar Compra</h1>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-primario text-white">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Información de Envío</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= Vista::url('carrito/procesar_pedido') ?>" id="form-checkout">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Dirección Completa *</label>
                            <input type="text" class="form-control" name="direccion" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ciudad *</label>
                                <input type="text" class="form-control" name="ciudad" value="Barrancabermeja" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono de Contacto *</label>
                                <input type="tel" class="form-control" name="telefono" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notas del Pedido (Opcional)</label>
                            <textarea class="form-control" name="notas" rows="3"></textarea>
                        </div>
                        
                        <hr>
                        
                        <h5 class="mb-3"><i class="bi bi-credit-card"></i> Método de Pago</h5>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_mercadopago" value="mercadopago" checked>
                                <label class="form-check-label" for="pago_mercadopago">
                                    <strong>MercadoPago</strong>
                                    <small class="d-block text-muted">Tarjeta de crédito/débito, PSE, Nequi, Daviplata</small>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header bg-secundario text-white">
                    <h5 class="mb-0"><i class="bi bi-cart-check"></i> Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($items as $item): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <small><?= Vista::escapar($item['nombre']) ?></small>
                                <small class="text-muted"> x<?= $item['cantidad'] ?></small>
                            </div>
                            <small class="fw-bold"><?= Vista::formatearPrecio($item['precio_unitario'] * $item['cantidad']) ?></small>
                        </div>
                    <?php endforeach; ?>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span><?= Vista::formatearPrecio($subtotal) ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>IVA (19%):</span>
                        <span><?= Vista::formatearPrecio($impuestos) ?></span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong class="fs-5">Total:</strong>
                        <strong class="fs-4 text-primario"><?= Vista::formatearPrecio($total) ?></strong>
                    </div>
                    
                    <button type="submit" form="form-checkout" class="btn btn-primario w-100 btn-lg">
                        <i class="bi bi-lock"></i> Confirmar Pedido
                    </button>
                    
                    <a href="<?= Vista::url('carrito') ?>" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left"></i> Volver al Carrito
                    </a>
                </div>
            </div>
            
            <div class="card bg-light">
                <div class="card-body">
                    <h6><i class="bi bi-shield-check text-success"></i> Compra Segura</h6>
                    <small class="text-muted">Tus datos están protegidos y encriptados</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

