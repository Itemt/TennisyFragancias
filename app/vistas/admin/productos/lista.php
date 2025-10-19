<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>
        
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-box-seam"></i> Gestión de Productos</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/producto_nuevo') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nuevo Producto
                    </a>
                </div>
            </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock Total</th>
                            <th>Tallas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($producto['imagen_principal']): ?>
                                            <img src="<?= Vista::urlPublica('imagenes/productos/' . $producto['imagen_principal']) ?>" 
                                                 alt="<?= Vista::escapar($producto['nombre']) ?>" 
                                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                                 class="me-3 rounded">
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= Vista::escapar($producto['nombre']) ?></strong>
                                            <?php if ($producto['marca_nombre']): ?>
                                                <br><small class="text-muted"><?= Vista::escapar($producto['marca_nombre']) ?></small>
                                            <?php endif; ?>
                                            <br><small class="text-muted">SKU: <?= Vista::escapar($producto['codigo_sku']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= Vista::escapar($producto['categoria_nombre']) ?></td>
                                <td>
                                    <strong><?= Vista::formatearPrecio($producto['precio']) ?></strong>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <span class="badge bg-primary fs-6"><?= $producto['stock_total'] ?></span>
                                        <br><small class="text-muted">Total unidades</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <span class="badge bg-info"><?= $producto['total_variantes'] ?> tallas</span>
                                        <br><small class="text-muted">Variantes</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success">Activo</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="verDetallesProducto(<?= $producto['id'] ?>, <?= json_encode($producto['nombre']) ?>)"
                                                title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="<?= Vista::url('admin/producto_editar/' . $producto['id']) ?>" 
                                           class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="eliminarProducto(<?= $producto['id'] ?>, <?= json_encode($producto['nombre']) ?>)"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </main>
    </div>
</div>

<!-- Modal para ver detalles del producto -->
<div class="modal fade" id="modalDetallesProducto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle"></i> <span id="nombre-producto-modal">-</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Indicador de carga -->
                <div id="loading-indicator" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando detalles del producto...</p>
                </div>
                
                <!-- Contenido del modal -->
                <div id="modal-content">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Stock Total:</strong>
                            <span id="stock-total-modal" class="badge bg-primary fs-6 ms-2">-</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Total de Tallas:</strong>
                            <span id="total-tallas-modal" class="badge bg-info ms-2">-</span>
                        </div>
                    </div>
                    
                    <h6>Detalle por Tallas:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Talla</th>
                                    <th>SKU</th>
                                    <th class="text-end">Stock</th>
                                    <th class="text-end">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-tallas-modal">
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-editar-producto">
                    <i class="bi bi-pencil"></i> Editar Producto
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let productoActualId = null;

function verDetallesProducto(productoId, nombreProducto) {
    console.log('verDetallesProducto llamado:', productoId, nombreProducto);
    productoActualId = productoId;
    
    const nombreModal = document.getElementById('nombre-producto-modal');
    const loadingIndicator = document.getElementById('loading-indicator');
    const modalContent = document.getElementById('modal-content');
    
    if (!nombreModal || !loadingIndicator || !modalContent) {
        console.error('No se encontraron los elementos del modal');
        alert('Error: No se pudo cargar el modal');
        return;
    }
    
    nombreModal.textContent = nombreProducto;
    
    // Mostrar indicador de carga
    loadingIndicator.style.display = 'block';
    modalContent.style.display = 'none';
    
    // Mostrar modal inmediatamente
    const modalElement = document.getElementById('modalDetallesProducto');
    if (!modalElement) {
        console.error('No se encontró el elemento modalDetallesProducto');
        alert('Error: No se encontró el modal');
        return;
    }
    
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
    
    // Cargar variantes del producto por nombre
    const url = '<?= Vista::url("admin/obtener-variantes-producto") ?>?nombre=' + encodeURIComponent(nombreProducto);
    console.log('Fetching:', url);
    
    fetch(url)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Error de red: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Data recibida:', data);
            // Ocultar indicador de carga
            loadingIndicator.style.display = 'none';
            modalContent.style.display = 'block';
            
            if (data.exito && data.variantes) {
                mostrarDetallesProducto(data.variantes);
            } else {
                console.error('Error en respuesta:', data);
                alert('Error al cargar los detalles del producto: ' + (data.mensaje || 'Error desconocido'));
            }
        })
        .catch(error => {
            // Ocultar indicador de carga
            loadingIndicator.style.display = 'none';
            modalContent.style.display = 'block';
            
            console.error('Error en fetch:', error);
            alert('Error al cargar los detalles: ' + error.message);
        });
}

function mostrarDetallesProducto(variantes) {
    // Calcular totales
    const stockTotal = variantes.reduce((sum, v) => sum + parseInt(v.stock), 0);
    const totalTallas = variantes.length;
    
    // Actualizar información general
    document.getElementById('stock-total-modal').textContent = stockTotal;
    document.getElementById('total-tallas-modal').textContent = totalTallas;
    
    // Llenar tabla de tallas
    const tablaTallas = document.getElementById('tabla-tallas-modal');
    tablaTallas.innerHTML = '';
    
    variantes.forEach(variante => {
        const tr = document.createElement('tr');
        const estadoStock = variante.stock > 0 ? 
            `<span class="badge bg-success">En Stock</span>` : 
            `<span class="badge bg-danger">Agotado</span>`;
        
        tr.innerHTML = `
            <td><strong>${variante.talla_nombre || 'Sin talla'}</strong></td>
            <td><code>${variante.codigo_sku}</code></td>
            <td class="text-end">
                <span class="badge ${variante.stock > 0 ? 'bg-success' : 'bg-danger'}">
                    ${variante.stock}
                </span>
            </td>
            <td class="text-end">${estadoStock}</td>
        `;
        tablaTallas.appendChild(tr);
    });
}

function eliminarProducto(productoId, nombreProducto) {
    if (confirm(`¿Estás seguro de eliminar el producto "${nombreProducto}"?\n\nEsto eliminará TODAS las variantes (todas las tallas) del producto.`)) {
        // Aquí puedes implementar la eliminación
        alert('Función de eliminación en desarrollo');
    }
}

// Configurar botón de editar en el modal
document.getElementById('btn-editar-producto').addEventListener('click', function() {
    if (productoActualId) {
        window.location.href = '<?= Vista::url("admin/producto_editar/") ?>' + productoActualId;
    }
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

