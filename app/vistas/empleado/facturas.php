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
                        <a class="nav-link active" href="<?= Vista::url('empleado/factura') ?>">
                            <i class="bi bi-receipt"></i> Facturas
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Facturas</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.reload()">
                            <i class="bi bi-arrow-clockwise"></i> Actualizar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filtro-fecha" placeholder="Filtrar por fecha">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="filtro-numero" placeholder="Buscar por número">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtro-estado">
                        <option value="">Todos los estados</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="procesando">Procesando</option>
                        <option value="enviado">Enviado</option>
                        <option value="entregado">Entregado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" onclick="aplicarFiltros()">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </div>

            <!-- Tabla de facturas -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($facturas)): ?>
                            <?php foreach ($facturas as $factura): ?>
                                <tr>
                                    <td>
                                        <strong>#<?= $factura['numero_factura'] ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= Vista::escapar($factura['cliente_nombre'] ?? 'Cliente no registrado') ?></strong>
                                            <?php if ($factura['cliente_email']): ?>
                                                <br>
                                                <small class="text-muted"><?= Vista::escapar($factura['cliente_email']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($factura['fecha_emision'] ?? $factura['fecha_factura'] ?? 'now')) ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $factura['estado'] === 'entregado' ? 'success' : ($factura['estado'] === 'cancelado' ? 'danger' : 'warning') ?>">
                                            <?= ucfirst($factura['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= Vista::formatearPrecio($factura['total']) ?></strong>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= Vista::url('empleado/factura/' . $factura['numero_factura']) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                            <a href="<?= Vista::url('empleado/factura/' . $factura['numero_factura']) ?>?imprimir=1" 
                                               class="btn btn-sm btn-outline-secondary" target="_blank">
                                                <i class="bi bi-printer"></i> Imprimir
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-receipt fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No hay facturas disponibles</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <?php if (isset($paginacion) && $paginacion['total_paginas'] > 1): ?>
                <nav aria-label="Paginación de facturas">
                    <ul class="pagination justify-content-center">
                        <?php if ($paginacion['pagina_actual'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?= $paginacion['pagina_actual'] - 1 ?>">Anterior</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $paginacion['total_paginas']; $i++): ?>
                            <li class="page-item <?= $i === $paginacion['pagina_actual'] ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($paginacion['pagina_actual'] < $paginacion['total_paginas']): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?= $paginacion['pagina_actual'] + 1 ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </main>
    </div>
</div>

<script>
function aplicarFiltros() {
    const fecha = document.getElementById('filtro-fecha').value;
    const numero = document.getElementById('filtro-numero').value;
    const estado = document.getElementById('filtro-estado').value;
    
    let url = new URL(window.location);
    if (fecha) url.searchParams.set('fecha', fecha);
    if (numero) url.searchParams.set('numero', numero);
    if (estado) url.searchParams.set('estado', estado);
    
    window.location.href = url.toString();
}
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
