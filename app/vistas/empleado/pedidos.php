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
                        <a class="nav-link active" href="<?= Vista::url('empleado/pedidos') ?>">
                            <i class="bi bi-bag"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('empleado/ventas') ?>">
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
                <h1 class="h2">Gestión de Pedidos</h1>
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
                    <input type="date" class="form-control" id="filtro-fecha" placeholder="Filtrar por fecha">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="filtro-cliente" placeholder="Buscar por cliente">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" onclick="aplicarFiltros()">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </div>

            <!-- Tabla de pedidos -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Método Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos)): ?>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td>#<?= $pedido['id'] ?></td>
                                    <td>
                                        <div>
                                            <strong><?= Vista::escapar($pedido['cliente_nombre']) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= Vista::escapar($pedido['cliente_email']) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $pedido['estado'] === 'entregado' ? 'success' : ($pedido['estado'] === 'cancelado' ? 'danger' : 'warning') ?>">
                                            <?= ucfirst($pedido['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= Vista::formatearPrecio($pedido['total']) ?></strong>
                                    </td>
                                    <td>
                                        <?= Vista::escapar($pedido['metodo_pago_nombre'] ?? 'No especificado') ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= Vista::url('empleado/pedidos/ver/' . $pedido['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" 
                                                    data-bs-toggle="dropdown">
                                                <i class="bi bi-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       onclick="cambiarEstado(<?= $pedido['id'] ?>, 'procesando')">
                                                        <i class="bi bi-play-circle"></i> Procesar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       onclick="cambiarEstado(<?= $pedido['id'] ?>, 'enviado')">
                                                        <i class="bi bi-truck"></i> Marcar como Enviado
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       onclick="cambiarEstado(<?= $pedido['id'] ?>, 'entregado')">
                                                        <i class="bi bi-check-circle"></i> Marcar como Entregado
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" 
                                                       onclick="cambiarEstado(<?= $pedido['id'] ?>, 'cancelado')">
                                                        <i class="bi bi-x-circle"></i> Cancelar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No hay pedidos disponibles</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <?php if (isset($paginacion) && $paginacion['total_paginas'] > 1): ?>
                <nav aria-label="Paginación de pedidos">
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
    const estado = document.getElementById('filtro-estado').value;
    const fecha = document.getElementById('filtro-fecha').value;
    const cliente = document.getElementById('filtro-cliente').value;
    
    let url = new URL(window.location);
    if (estado) url.searchParams.set('estado', estado);
    if (fecha) url.searchParams.set('fecha', fecha);
    if (cliente) url.searchParams.set('cliente', cliente);
    
    window.location.href = url.toString();
}

function cambiarEstado(pedidoId, nuevoEstado) {
    if (confirm(`¿Estás seguro de cambiar el estado del pedido #${pedidoId} a "${nuevoEstado}"?`)) {
        fetch('<?= Vista::url("empleado/pedidos/cambiar-estado") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                pedido_id: pedidoId,
                estado: nuevoEstado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                alert(data.mensaje);
                location.reload();
            } else {
                alert('Error: ' + data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado del pedido');
        });
    }
}
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
