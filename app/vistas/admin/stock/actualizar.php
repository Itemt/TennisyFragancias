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
                        <i class="bi bi-plus-circle"></i> Actualizar Stock por Talla
                    </h5>
                </div>
                <div class="card-body">
                    <form id="formActualizarStock">
                        <!-- Paso 1: Seleccionar Producto -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label"><strong>1. Seleccionar Producto *</strong></label>
                                <select class="form-select" id="producto_base_id" required>
                                    <option value="">Buscar y seleccionar producto...</option>
                                    <?php if (!empty($productos)): ?>
                                        <?php foreach ($productos as $producto): ?>
                                            <option value="<?= $producto['id'] ?>" 
                                                    data-nombre="<?= Vista::escapar($producto['nombre']) ?>"
                                                    data-stock-total="<?= $producto['stock_total'] ?>"
                                                    data-variantes="<?= $producto['total_variantes'] ?>">
                                                <?= Vista::escapar($producto['nombre']) ?>
                                                <?php if ($producto['marca_nombre']): ?>
                                                    - <?= Vista::escapar($producto['marca_nombre']) ?>
                                                <?php endif; ?>
                                                (<?= $producto['total_variantes'] ?> tallas, Stock total: <?= $producto['stock_total'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="form-text">Selecciona el producto al que deseas actualizar el stock</div>
                            </div>
                        </div>

                        <!-- Paso 2: Seleccionar Talla (se muestra dinámicamente) -->
                        <div id="seccion-tallas" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>2. Seleccionar Talla *</strong></label>
                                    <select class="form-select" id="producto_id" name="producto_id" required>
                                        <option value="">Selecciona una talla...</option>
                                    </select>
                                    <div class="form-text">Selecciona la talla específica a actualizar</div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label"><strong>Stock Actual</strong></label>
                                    <input type="text" class="form-control" id="stock_actual" readonly 
                                           placeholder="-">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label"><strong>Nuevo Stock</strong></label>
                                    <input type="text" class="form-control" id="nuevo_stock" readonly 
                                           placeholder="-">
                                </div>
                            </div>

                            <!-- Paso 3: Configurar Movimiento -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"><strong>3. Tipo de Movimiento *</strong></label>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="entrada">➕ Entrada (Agregar)</option>
                                        <option value="salida">➖ Salida (Quitar)</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"><strong>4. Cantidad *</strong></label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                           min="1" required placeholder="0">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"><strong>Motivo</strong></label>
                                    <input type="text" class="form-control" id="motivo" name="motivo" 
                                           placeholder="Ej: Compra, Devolución...">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle"></i> Actualizar Stock
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-lg" onclick="limpiarFormulario()">
                                        <i class="bi bi-arrow-clockwise"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información de Variantes -->
            <div class="card" id="info-variantes" style="display: none;">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i> <span id="nombre-producto">-</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Talla</th>
                                    <th>SKU</th>
                                    <th class="text-end">Stock Actual</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-variantes">
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
let variantesActuales = [];

// Al seleccionar un producto base, cargar sus variantes
document.getElementById('producto_base_id').addEventListener('change', function() {
    const productoId = this.value;
    const nombreProducto = this.options[this.selectedIndex].getAttribute('data-nombre');
    
    if (!productoId) {
        document.getElementById('seccion-tallas').style.display = 'none';
        document.getElementById('info-variantes').style.display = 'none';
        return;
    }
    
    // Cargar variantes del producto
    fetch('<?= Vista::url("admin/obtener-variantes-producto") ?>?producto_id=' + productoId)
        .then(response => response.json())
        .then(data => {
            if (data.exito && data.variantes) {
                variantesActuales = data.variantes;
                mostrarVariantes(data.variantes, nombreProducto);
                document.getElementById('seccion-tallas').style.display = 'block';
            } else {
                alert('Error al cargar las variantes del producto');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar las variantes');
        });
});

function mostrarVariantes(variantes, nombreProducto) {
    // Actualizar selector de tallas
    const selectTalla = document.getElementById('producto_id');
    selectTalla.innerHTML = '<option value="">Selecciona una talla...</option>';
    
    variantes.forEach(variante => {
        const option = document.createElement('option');
        option.value = variante.id;
        option.setAttribute('data-stock', variante.stock);
        option.setAttribute('data-sku', variante.codigo_sku);
        option.textContent = `${variante.talla_nombre || 'Sin talla'}: ${variante.stock}`;
        selectTalla.appendChild(option);
    });
    
    // Actualizar tabla de información
    document.getElementById('nombre-producto').textContent = nombreProducto;
    const tablaVariantes = document.getElementById('tabla-variantes');
    tablaVariantes.innerHTML = '';
    
    variantes.forEach(variante => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><strong>${variante.talla_nombre || 'Sin talla'}</strong></td>
            <td><code>${variante.codigo_sku}</code></td>
            <td class="text-end">
                <span class="badge ${variante.stock > 0 ? 'bg-success' : 'bg-danger'}">
                    ${variante.talla_nombre || 'Sin talla'}: ${variante.stock}
                </span>
            </td>
        `;
        tablaVariantes.appendChild(tr);
    });
    
    document.getElementById('info-variantes').style.display = 'block';
}

// Al seleccionar una talla, actualizar stock actual
document.getElementById('producto_id').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const stock = option.getAttribute('data-stock');
    
    if (this.value) {
        document.getElementById('stock_actual').value = stock;
        calcularNuevoStock();
    } else {
        document.getElementById('stock_actual').value = '';
        document.getElementById('nuevo_stock').value = '';
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
    
    document.getElementById('nuevo_stock').value = nuevoStock;
}

// Enviar formulario
document.getElementById('formActualizarStock').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Actualizando...';
    
    fetch('<?= Vista::url("admin/procesar-actualizacion-stock") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            alert('✅ ' + data.mensaje);
            
            // Recargar variantes para actualizar la información
            const productoBaseId = document.getElementById('producto_base_id').value;
            if (productoBaseId) {
                document.getElementById('producto_base_id').dispatchEvent(new Event('change'));
            }
            
            // Limpiar solo los campos de movimiento
            document.getElementById('producto_id').value = '';
            document.getElementById('cantidad').value = '';
            document.getElementById('motivo').value = '';
            document.getElementById('stock_actual').value = '';
            document.getElementById('nuevo_stock').value = '';
        } else {
            alert('❌ Error: ' + data.mensaje);
        }
        
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al actualizar el stock');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

function limpiarFormulario() {
    document.getElementById('formActualizarStock').reset();
    document.getElementById('seccion-tallas').style.display = 'none';
    document.getElementById('info-variantes').style.display = 'none';
    document.getElementById('stock_actual').value = '';
    document.getElementById('nuevo_stock').value = '';
    variantesActuales = [];
}
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
