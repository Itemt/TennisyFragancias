<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('empleado/panel') ?>">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('empleado/pedidos') ?>">
                            <i class="bi bi-bag"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('empleado/ventas') ?>">
                            <i class="bi bi-graph-up"></i> Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= Vista::url('empleado/venta-presencial') ?>">
                            <i class="bi bi-cash-register"></i> Venta Presencial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('empleado/factura') ?>">
                            <i class="bi bi-receipt"></i> Facturas
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Venta Presencial</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" onclick="finalizarVenta()" id="btnFinalizarVenta" disabled>
                        <i class="bi bi-check-circle"></i> Finalizar Venta
                    </button>
                </div>
            </div>

            <!-- Resumen de la venta -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Productos Seleccionados</h5>
                        </div>
                        <div class="card-body">
                            <div id="productosSeleccionados">
                                <p class="text-muted text-center py-3">
                                    <i class="bi bi-cart fs-1"></i><br>
                                    No hay productos seleccionados
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Resumen de Venta</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="subtotal">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Descuento:</span>
                                <span id="descuento">$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong id="total">$0.00</strong>
                            </div>
                            <div class="mt-3">
                                <label for="descuentoInput" class="form-label">Descuento (%)</label>
                                <input type="number" class="form-control" id="descuentoInput" min="0" max="100" value="0" onchange="calcularTotal()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros de productos -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <select class="form-select" id="filtro-categoria">
                        <option value="">Todas las categorías</option>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>"><?= Vista::escapar($categoria['nombre']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtro-marca">
                        <option value="">Todas las marcas</option>
                        <?php if (!empty($marcas)): ?>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?= $marca['id'] ?>"><?= Vista::escapar($marca['nombre']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtro-talla">
                        <option value="">Todas las tallas</option>
                        <?php if (!empty($tallas)): ?>
                            <?php foreach ($tallas as $talla): ?>
                                <option value="<?= $talla['id'] ?>"><?= Vista::escapar($talla['nombre']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="filtro-buscar" placeholder="Buscar producto...">
                </div>
            </div>

            <!-- Lista de productos -->
            <div class="row" id="productosContainer">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-4 col-lg-3 mb-4 producto-card" 
                             data-categoria="<?= $producto['categoria_id'] ?>"
                             data-marca="<?= $producto['marca_id'] ?>"
                             data-talla="<?= $producto['talla_id'] ?>"
                             data-nombre="<?= strtolower(Vista::escapar($producto['nombre'])) ?>">
                            <div class="card h-100">
                                <?php if ($producto['imagen_principal']): ?>
                                    <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                                         class="card-img-top" alt="<?= Vista::escapar($producto['nombre']) ?>" 
                                         style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="bi bi-image fs-1 text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h6 class="card-title"><?= Vista::escapar($producto['nombre']) ?></h6>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <?= Vista::escapar($producto['marca_nombre']) ?> - 
                                            Talla <?= Vista::escapar($producto['talla_nombre']) ?>
                                        </small>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if ($producto['precio_oferta'] && $producto['precio_oferta'] < $producto['precio']): ?>
                                                <span class="text-decoration-line-through text-muted">
                                                    <?= Vista::formatearPrecio($producto['precio']) ?>
                                                </span>
                                                <br>
                                                <strong class="text-success"><?= Vista::formatearPrecio($producto['precio_oferta']) ?></strong>
                                            <?php else: ?>
                                                <strong><?= Vista::formatearPrecio($producto['precio']) ?></strong>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <span class="badge bg-<?= $producto['stock'] > 0 ? 'success' : 'danger' ?>">
                                                Stock: <?= $producto['stock'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <?php if ($producto['stock'] > 0): ?>
                                        <div class="mt-3">
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(<?= $producto['id'] ?>, -1)">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" class="form-control text-center" 
                                                       id="cantidad_<?= $producto['id'] ?>" 
                                                       value="0" min="0" max="<?= $producto['stock'] ?>"
                                                       onchange="actualizarCantidad(<?= $producto['id'] ?>)">
                                                <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(<?= $producto['id'] ?>, 1)">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-3">
                                            <button class="btn btn-outline-danger w-100" disabled>
                                                <i class="bi bi-x-circle"></i> Sin Stock
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-box fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No hay productos disponibles</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script>
let productosSeleccionados = {};

// Aplicar filtros
function aplicarFiltros() {
    const categoria = document.getElementById('filtro-categoria').value;
    const marca = document.getElementById('filtro-marca').value;
    const talla = document.getElementById('filtro-talla').value;
    const buscar = document.getElementById('filtro-buscar').value.toLowerCase();
    
    const productos = document.querySelectorAll('.producto-card');
    
    productos.forEach(producto => {
        let mostrar = true;
        
        if (categoria && producto.dataset.categoria !== categoria) {
            mostrar = false;
        }
        
        if (marca && producto.dataset.marca !== marca) {
            mostrar = false;
        }
        
        if (talla && producto.dataset.talla !== talla) {
            mostrar = false;
        }
        
        if (buscar && !producto.dataset.nombre.includes(buscar)) {
            mostrar = false;
        }
        
        producto.style.display = mostrar ? 'block' : 'none';
    });
}

// Cambiar cantidad
function cambiarCantidad(productoId, cambio) {
    const input = document.getElementById('cantidad_' + productoId);
    const nuevaCantidad = parseInt(input.value) + cambio;
    
    if (nuevaCantidad >= 0) {
        input.value = nuevaCantidad;
        actualizarCantidad(productoId);
    }
}

// Actualizar cantidad
function actualizarCantidad(productoId) {
    const input = document.getElementById('cantidad_' + productoId);
    const cantidad = parseInt(input.value) || 0;
    
    if (cantidad > 0) {
        productosSeleccionados[productoId] = cantidad;
    } else {
        delete productosSeleccionados[productoId];
    }
    
    actualizarResumen();
}

// Actualizar resumen
function actualizarResumen() {
    const container = document.getElementById('productosSeleccionados');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    const btnFinalizar = document.getElementById('btnFinalizarVenta');
    
    if (Object.keys(productosSeleccionados).length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-3"><i class="bi bi-cart fs-1"></i><br>No hay productos seleccionados</p>';
        subtotalElement.textContent = '$0.00';
        totalElement.textContent = '$0.00';
        btnFinalizar.disabled = true;
        return;
    }
    
    // Construir HTML de productos seleccionados
    let html = '';
    let subtotal = 0;
    
    Object.keys(productosSeleccionados).forEach(productoId => {
        const cantidad = productosSeleccionados[productoId];
        const producto = document.querySelector(`[data-producto-id="${productoId}"]`);
        
        if (producto) {
            const precio = parseFloat(producto.dataset.precio);
            const total = precio * cantidad;
            subtotal += total;
            
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>${producto.dataset.nombre}</strong><br>
                        <small class="text-muted">Cantidad: ${cantidad}</small>
                    </div>
                    <div class="text-end">
                        <strong>$${total.toFixed(2)}</strong>
                    </div>
                </div>
            `;
        }
    });
    
    container.innerHTML = html;
    subtotalElement.textContent = '$' + subtotal.toFixed(2);
    calcularTotal();
    btnFinalizar.disabled = false;
}

// Calcular total con descuento
function calcularTotal() {
    const subtotal = parseFloat(document.getElementById('subtotal').textContent.replace('$', '')) || 0;
    const descuentoPorcentaje = parseFloat(document.getElementById('descuentoInput').value) || 0;
    const descuento = (subtotal * descuentoPorcentaje) / 100;
    const total = subtotal - descuento;
    
    document.getElementById('descuento').textContent = '$' + descuento.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
}

// Finalizar venta
function finalizarVenta() {
    if (Object.keys(productosSeleccionados).length === 0) {
        alert('No hay productos seleccionados');
        return;
    }
    
    const total = parseFloat(document.getElementById('total').textContent.replace('$', ''));
    const descuento = parseFloat(document.getElementById('descuentoInput').value);
    
    if (confirm(`¿Finalizar venta por $${total.toFixed(2)}?`)) {
        // Aquí se enviaría la venta al servidor
        fetch('<?= Vista::url("empleado/venta-presencial/procesar") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                productos: productosSeleccionados,
                descuento: descuento,
                total: total
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                alert('Venta procesada exitosamente');
                location.reload();
            } else {
                alert('Error: ' + data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la venta');
        });
    }
}

// Event listeners para filtros
document.getElementById('filtro-categoria').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-marca').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-talla').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-buscar').addEventListener('input', aplicarFiltros);
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
