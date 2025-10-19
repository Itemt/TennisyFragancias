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
                        <a class="nav-link active" href="<?= Vista::url('empleado/ventas') ?>">
                            <i class="bi bi-graph-up"></i> Ventas
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
                <h1 class="h2"><i class="bi bi-cart-plus"></i> Registrar Venta Presencial</h1>
            </div>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Búsqueda de Productos -->
            <div class="card mb-4">
                <div class="card-header bg-primario text-white">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Buscar Productos</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="buscar-producto" placeholder="Buscar por nombre, SKU o categoría...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    
                    <div id="resultados-busqueda" class="row g-3">
                        <!-- Productos se cargarán aquí dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Carrito de Venta -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-warning">
                    <h5 class="mb-0 text-dark"><i class="bi bi-cart"></i> Venta Actual</h5>
                </div>
                <div class="card-body">
                    <div id="items-venta" class="mb-3">
                        <p class="text-muted text-center">No hay productos agregados</p>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong id="subtotal-venta">$0</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>IVA (19%):</span>
                        <span id="iva-venta">$0</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong class="fs-5">Total:</strong>
                        <strong class="fs-5 text-success" id="total-venta">$0</strong>
                    </div>
                    
                    <hr>
                    
                    <!-- Datos del Cliente -->
                    <h6 class="mb-3">Datos del Cliente</h6>
                    
                    <div class="mb-2">
                        <input type="text" class="form-control form-control-sm" id="cliente-nombre" placeholder="Nombre completo *" required>
                    </div>
                    
                    <div class="mb-2">
                        <input type="tel" class="form-control form-control-sm" id="cliente-telefono" placeholder="Teléfono *" required>
                    </div>
                    
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-sm" id="cliente-email" placeholder="Email (opcional)">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small">Método de Pago *</label>
                        <select class="form-select form-select-sm" id="metodo-pago">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                    
                    <button type="button" class="btn btn-success w-100" id="btn-procesar-venta">
                        <i class="bi bi-check-circle"></i> Procesar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let itemsVenta = [];

// Buscar productos
document.getElementById('buscar-producto').addEventListener('input', function() {
    const termino = this.value;
    if (termino.length < 2) return;
    
    // Aquí harías una petición AJAX para buscar productos
    // Por ahora, mostraremos los productos del catálogo
});

// Agregar producto a la venta
function agregarProducto(id, nombre, precio, stock) {
    const existente = itemsVenta.find(item => item.id === id);
    
    if (existente) {
        if (existente.cantidad < stock) {
            existente.cantidad++;
        } else {
            alert('Stock insuficiente');
            return;
        }
    } else {
        itemsVenta.push({
            id: id,
            nombre: nombre,
            precio: parseFloat(precio),
            cantidad: 1,
            stock: stock
        });
    }
    
    actualizarVistaVenta();
}

// Actualizar vista de la venta
function actualizarVistaVenta() {
    const container = document.getElementById('items-venta');
    
    if (itemsVenta.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">No hay productos agregados</p>';
        document.getElementById('subtotal-venta').textContent = '$0';
        document.getElementById('iva-venta').textContent = '$0';
        document.getElementById('total-venta').textContent = '$0';
        return;
    }
    
    let html = '';
    let subtotal = 0;
    
    itemsVenta.forEach((item, index) => {
        const itemTotal = item.precio * item.cantidad;
        subtotal += itemTotal;
        
        html += `
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <div class="flex-grow-1">
                    <small><strong>${item.nombre}</strong></small><br>
                    <small class="text-muted">${item.precio.toLocaleString('es-CO', {style: 'currency', currency: 'COP'})} x ${item.cantidad}</small>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-danger" onclick="eliminarItem(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    const iva = subtotal * 0.19;
    const total = subtotal + iva;
    
    document.getElementById('subtotal-venta').textContent = subtotal.toLocaleString('es-CO', {style: 'currency', currency: 'COP'});
    document.getElementById('iva-venta').textContent = iva.toLocaleString('es-CO', {style: 'currency', currency: 'COP'});
    document.getElementById('total-venta').textContent = total.toLocaleString('es-CO', {style: 'currency', currency: 'COP'});
}

// Eliminar item
function eliminarItem(index) {
    itemsVenta.splice(index, 1);
    actualizarVistaVenta();
}

// Procesar venta
document.getElementById('btn-procesar-venta').addEventListener('click', function() {
    const nombre = document.getElementById('cliente-nombre').value;
    const telefono = document.getElementById('cliente-telefono').value;
    const email = document.getElementById('cliente-email').value;
    const metodoPago = document.getElementById('metodo-pago').value;
    
    if (!nombre || !telefono) {
        alert('Por favor completa los datos del cliente');
        return;
    }
    
    if (itemsVenta.length === 0) {
        alert('Agrega productos a la venta');
        return;
    }
    
    const formData = new FormData();
    formData.append('cliente_nombre', nombre);
    formData.append('cliente_telefono', telefono);
    formData.append('cliente_email', email);
    formData.append('metodo_pago', metodoPago);
    formData.append('items', JSON.stringify(itemsVenta));
    
    fetch('<?= Vista::url("empleado/procesar_venta") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert('Venta registrada correctamente');
        window.location.href = data; // Redirige a la factura
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la venta');
    });
});
</script>

        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

