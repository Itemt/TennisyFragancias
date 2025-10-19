<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-clock-history"></i> Historial de Stock</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/actualizar-stock') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Actualizar Stock
                    </a>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Tipo de Movimiento</label>
                            <select class="form-select" id="filtro-tipo">
                                <option value="">Todos</option>
                                <option value="entrada" <?= ($filtros['tipo'] ?? '') === 'entrada' ? 'selected' : '' ?>>Entradas</option>
                                <option value="salida" <?= ($filtros['tipo'] ?? '') === 'salida' ? 'selected' : '' ?>>Salidas</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" id="fecha-desde" value="<?= $filtros['fecha_desde'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" id="fecha-hasta" value="<?= $filtros['fecha_hasta'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Buscar Producto</label>
                            <input type="text" class="form-control" id="buscar-producto" placeholder="Nombre o SKU..." value="<?= $filtros['buscar'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onclick="aplicarFiltros()">
                                <i class="bi bi-search"></i> Aplicar Filtros
                            </button>
                            <button class="btn btn-secondary" onclick="limpiarFiltros()">
                                <i class="bi bi-arrow-clockwise"></i> Limpiar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de historial -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-ul"></i> Movimientos de Stock
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($historial)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Producto</th>
                                        <th>SKU</th>
                                        <th>Tipo</th>
                                        <th>Cantidad</th>
                                        <th>Stock Anterior</th>
                                        <th>Stock Nuevo</th>
                                        <th>Motivo</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historial as $movimiento): ?>
                                        <tr>
                                            <td><?= isset($movimiento['fecha']) && $movimiento['fecha'] ? date('d/m/Y H:i', strtotime($movimiento['fecha'])) : 'Sin fecha' ?></td>
                                            <td><?= Vista::escapar($movimiento['producto_nombre']) ?></td>
                                            <td><code><?= Vista::escapar($movimiento['sku'] ?? 'Sin SKU') ?></code></td>
                                            <td>
                                                <span class="badge bg-<?= $movimiento['tipo'] === 'entrada' ? 'success' : 'warning' ?>">
                                                    <?= ucfirst($movimiento['tipo']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold <?= $movimiento['tipo'] === 'entrada' ? 'text-success' : 'text-danger' ?>">
                                                    <?= $movimiento['tipo'] === 'entrada' ? '+' : '-' ?><?= $movimiento['cantidad'] ?>
                                                </span>
                                            </td>
                                            <td><?= $movimiento['stock_anterior'] ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= $movimiento['stock_nuevo'] ?></span>
                                            </td>
                                            <td><?= Vista::escapar($movimiento['motivo'] ?? 'Sin motivo') ?></td>
                                            <td><?= Vista::escapar($movimiento['usuario_nombre']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <h5 class="text-muted mt-3">No hay movimientos registrados</h5>
                            <p class="text-muted">Los movimientos de stock aparecerán aquí cuando se actualicen productos.</p>
                            <a href="<?= Vista::url('admin/actualizar-stock') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Actualizar Stock
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>
</div>

<script>
function aplicarFiltros() {
    const tipo = document.getElementById('filtro-tipo').value;
    const fechaDesde = document.getElementById('fecha-desde').value;
    const fechaHasta = document.getElementById('fecha-hasta').value;
    const buscar = document.getElementById('buscar-producto').value;
    
    // Construir URL con parámetros
    const url = new URL(window.location);
    if (tipo) url.searchParams.set('tipo', tipo);
    if (fechaDesde) url.searchParams.set('fecha_desde', fechaDesde);
    if (fechaHasta) url.searchParams.set('fecha_hasta', fechaHasta);
    if (buscar) url.searchParams.set('buscar', buscar);
    
    window.location.href = url.toString();
}

function limpiarFiltros() {
    document.getElementById('filtro-tipo').value = '';
    document.getElementById('fecha-desde').value = '';
    document.getElementById('fecha-hasta').value = '';
    document.getElementById('buscar-producto').value = '';
    
    // Recargar sin parámetros
    window.location.href = window.location.pathname;
}

</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
