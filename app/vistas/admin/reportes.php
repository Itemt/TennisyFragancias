<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-graph-up"></i> Reportes y Estadísticas</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>

            <!-- Filtros de fecha -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-range"></i> Filtros de Fecha
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" name="fecha_desde" 
                                   value="<?= $fecha_desde ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" name="fecha_hasta" 
                                   value="<?= $fecha_hasta ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Aplicar Filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas del período -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Ventas Totales</h6>
                                    <h3 class="mb-0"><?= Vista::formatearPrecio($estadisticas['total_ventas'] ?? 0) ?></h3>
                                </div>
                                <i class="bi bi-currency-dollar fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Pedidos</h6>
                                    <h3 class="mb-0"><?= $estadisticas['total_pedidos'] ?? 0 ?></h3>
                                </div>
                                <i class="bi bi-box-seam fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Ticket Promedio</h6>
                                    <h3 class="mb-0"><?= Vista::formatearPrecio($estadisticas['ticket_promedio'] ?? 0) ?></h3>
                                </div>
                                <i class="bi bi-calculator fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Productos Vendidos</h6>
                                    <h3 class="mb-0"><?= $estadisticas['total_productos_vendidos'] ?? 0 ?></h3>
                                </div>
                                <i class="bi bi-tags fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Gráfico de ventas por mes -->
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-bar-chart"></i> Ventas por Mes - <?= date('Y') ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="ventasPorMesChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Productos más vendidos -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-trophy"></i> Top Productos
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($productos_mas_vendidos)): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($productos_mas_vendidos as $index => $producto): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary me-2"><?= $index + 1 ?></span>
                                                <div>
                                                    <h6 class="mb-0"><?= Vista::escapar($producto['nombre_producto']) ?></h6>
                                                    <small class="text-muted"><?= Vista::escapar($producto['codigo_sku']) ?></small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-success"><?= $producto['total_vendido'] ?> unidades</span>
                                                <br>
                                                <small class="text-muted"><?= Vista::formatearPrecio($producto['total_ingresos']) ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-3">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No hay datos de ventas</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de estados de pedidos -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-pie-chart"></i> Estados de Pedidos
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="estadosPedidosChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-calendar-week"></i> Resumen Semanal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Día</th>
                                            <th>Pedidos</th>
                                            <th>Ventas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                        for ($i = 0; $i < 7; $i++):
                                        ?>
                                            <tr>
                                                <td><?= $dias[$i] ?></td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?= rand(5, 25) ?>
                                                    </span>
                                                </td>
                                                <td><?= Vista::formatearPrecio(rand(500000, 2000000)) ?></td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Datos para los gráficos
const ventasPorMes = <?= json_encode($ventas_por_mes ?? []) ?>;
const estadosPedidos = <?= json_encode($estadisticas['estados_pedidos'] ?? []) ?>;

// Gráfico de ventas por mes
const ctxVentas = document.getElementById('ventasPorMesChart').getContext('2d');
new Chart(ctxVentas, {
    type: 'line',
    data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
            label: 'Ventas',
            data: ventasPorMes,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Gráfico de estados de pedidos
const ctxEstados = document.getElementById('estadosPedidosChart').getContext('2d');
new Chart(ctxEstados, {
    type: 'doughnut',
    data: {
        labels: ['Completados', 'Pendientes', 'Cancelados'],
        datasets: [{
            data: [
                estadosPedidos.completados || 0,
                estadosPedidos.pendientes || 0,
                estadosPedidos.cancelados || 0
            ],
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
