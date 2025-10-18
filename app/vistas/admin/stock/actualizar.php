<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-box-arrow-in-up"></i> Actualizar Stock</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/historial-stock') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-clock-history"></i> Ver Historial
                    </a>
                </div>
            </div>

            <!-- Formulario de actualización -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-plus-circle"></i> Agregar Stock
                    </h5>
                </div>
                <div class="card-body">
                    <form id="formActualizarStock">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Seleccionar Producto *</label>
                                <select class="form-select" id="producto_id" name="producto_id" required>
                                    <option value="">Buscar y seleccionar producto...</option>
                                    <?php if (!empty($productos)): ?>
                                        <?php foreach ($productos as $producto): ?>
                                            <option value="<?= $producto['id'] ?>" 
                                                    data-stock="<?= $producto['stock'] ?>"
                                                    data-sku="<?= Vista::escapar($producto['codigo_sku']) ?>"
                                                    data-talla="<?= Vista::escapar($producto['talla_nombre'] ?? 'Sin talla') ?>">
                                                <?= Vista::escapar($producto['nombre']) ?> 
                                                (<?= Vista::escapar($producto['codigo_sku']) ?>)
                                                <?php if ($producto['talla_nombre']): ?>
                                                    - Talla: <?= Vista::escapar($producto['talla_nombre']) ?>
                                                <?php endif; ?>
                                                - Stock: <?= $producto['stock'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tipo de Movimiento *</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="entrada">Entrada (+)</option>
                                    <option value="salida">Salida (-)</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cantidad *</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                       min="1" required placeholder="0">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Motivo</label>
                                <input type="text" class="form-control" id="motivo" name="motivo" 
                                       placeholder="Ej: Compra de proveedor, Devolución, Ajuste de inventario...">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stock Actual</label>
                                <input type="text" class="form-control" id="stock_actual" readonly 
                                       placeholder="Selecciona un producto">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Actualizar Stock
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información del producto seleccionado -->
            <div class="card" id="info-producto" style="display: none;">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i> Información del Producto
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>SKU:</strong>
                            <span id="info-sku">-</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Talla:</strong>
                            <span id="info-talla">-</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Stock Actual:</strong>
                            <span id="info-stock" class="badge bg-info">-</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Nuevo Stock:</strong>
                            <span id="info-nuevo-stock" class="badge bg-success">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Actualizar información del producto al seleccionar
document.getElementById('producto_id').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const stockActual = option.getAttribute('data-stock');
    const sku = option.getAttribute('data-sku');
    const talla = option.getAttribute('data-talla');
    
    if (this.value) {
        document.getElementById('stock_actual').value = stockActual;
        document.getElementById('info-sku').textContent = sku;
        document.getElementById('info-talla').textContent = talla;
        document.getElementById('info-stock').textContent = stockActual;
        document.getElementById('info-producto').style.display = 'block';
        
        // Calcular nuevo stock
        calcularNuevoStock();
    } else {
        document.getElementById('info-producto').style.display = 'none';
        document.getElementById('stock_actual').value = '';
    }
});

// Calcular nuevo stock al cambiar cantidad o tipo
document.getElementById('cantidad').addEventListener('input', calcularNuevoStock);
document.getElementById('tipo').addEventListener('change', calcularNuevoStock);

function calcularNuevoStock() {
    const stockActual = parseInt(document.getElementById('stock_actual').value) || 0;
    const cantidad = parseInt(document.getElementById('cantidad').value) || 0;
    const tipo = document.getElementById('tipo').value;
    
    let nuevoStock = stockActual;
    if (tipo === 'entrada') {
        nuevoStock = stockActual + cantidad;
    } else if (tipo === 'salida') {
        nuevoStock = Math.max(0, stockActual - cantidad);
    }
    
    document.getElementById('info-nuevo-stock').textContent = nuevoStock;
    
    // Cambiar color según el tipo
    const badge = document.getElementById('info-nuevo-stock');
    if (tipo === 'entrada') {
        badge.className = 'badge bg-success';
    } else {
        badge.className = nuevoStock < stockActual ? 'badge bg-warning' : 'badge bg-danger';
    }
}

// Enviar formulario
document.getElementById('formActualizarStock').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= Vista::url("admin/procesar-actualizacion-stock") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            alert(data.mensaje);
            
            // Actualizar stock en la interfaz
            const stockActual = document.getElementById('stock_actual');
            stockActual.value = data.stock_nuevo;
            document.getElementById('info-stock').textContent = data.stock_nuevo;
            
            // Limpiar formulario
            limpiarFormulario();
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el stock');
    });
});

function limpiarFormulario() {
    document.getElementById('formActualizarStock').reset();
    document.getElementById('info-producto').style.display = 'none';
    document.getElementById('stock_actual').value = '';
}

// Búsqueda en tiempo real
document.getElementById('producto_id').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const options = this.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') return; // No filtrar la opción vacía
        
        const text = option.textContent.toLowerCase();
        if (text.includes(filter)) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    });
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
