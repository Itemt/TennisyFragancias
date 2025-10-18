<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('admin/dashboard') ?>">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('admin/productos') ?>">
                            <i class="bi bi-box"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= Vista::url('admin/categorias') ?>">
                            <i class="bi bi-tags"></i> Categorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('admin/usuarios') ?>">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('admin/pedidos') ?>">
                            <i class="bi bi-bag"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('admin/reportes') ?>">
                            <i class="bi bi-graph-up"></i> Reportes
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-tags"></i> Gestión de Categorías</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= Vista::url('admin/categoria_crear') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nueva Categoría
                    </a>
                </div>
            </div>

            <!-- Mensajes y alertas -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>

            <!-- Advertencia de eliminación con productos -->
            <?php if (isset($_SESSION['categoria_advertencia'])): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading">⚠️ ADVERTENCIA</h5>
                    <p><?= $_SESSION['mensaje'] ?></p>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Categoría:</strong> <?= $_SESSION['categoria_advertencia']['nombre'] ?><br>
                            <strong>Productos asociados:</strong> <?= $_SESSION['categoria_advertencia']['total_productos'] ?>
                        </div>
                        <div>
                            <form method="POST" action="<?= Vista::url('admin/categoria-eliminar') ?>" style="display: inline;">
                                <input type="hidden" name="categoria_id" value="<?= $_SESSION['categoria_advertencia']['id'] ?>">
                                <input type="hidden" name="confirmar_eliminacion" value="1">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Eliminar de todos modos
                                </button>
                            </form>
                            <button type="button" class="btn btn-secondary btn-sm ms-2" onclick="this.closest('.alert').remove()">
                                <i class="bi bi-x"></i> Cancelar
                            </button>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['categoria_advertencia']); ?>
            <?php endif; ?>

            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="buscarCategoria" placeholder="Buscar categoría...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtroEstado">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>

            <!-- Tabla de categorías -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Productos</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?= $categoria['id'] ?></td>
                                    <td>
                                        <strong><?= Vista::escapar($categoria['nombre']) ?></strong>
                                    </td>
                                    <td><?= Vista::escapar($categoria['descripcion'] ?? 'Sin descripción') ?></td>
                                    <td>
                                        <span class="badge bg-<?= $categoria['estado'] === 'activo' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($categoria['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= $categoria['cantidad_productos'] ?? 0 ?> productos
                                        </span>
                                    </td>
                                    <td><?= isset($categoria['fecha_creacion']) ? date('d/m/Y', strtotime($categoria['fecha_creacion'])) : 'N/A' ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= Vista::url('admin/categoria-editar/' . $categoria['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="eliminarCategoria(<?= $categoria['id'] ?>, '<?= Vista::escapar($categoria['nombre']) ?>')" 
                                                    title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1"></i><br>
                                    No hay categorías registradas
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <?php if (isset($paginacion) && $paginacion['total_paginas'] > 1): ?>
                <nav aria-label="Paginación de categorías">
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
function eliminarCategoria(id, nombre) {
    if (confirm(`¿Estás seguro de que deseas eliminar la categoría "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
        // Crear formulario para enviar POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= Vista::url('admin/categoria-eliminar') ?>';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'categoria_id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

// Filtros en tiempo real
document.getElementById('buscarCategoria').addEventListener('input', function() {
    const valor = this.value.toLowerCase();
    const filas = document.querySelectorAll('tbody tr');
    
    filas.forEach(fila => {
        const nombre = fila.cells[1].textContent.toLowerCase();
        const descripcion = fila.cells[2].textContent.toLowerCase();
        
        if (nombre.includes(valor) || descripcion.includes(valor)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});

document.getElementById('filtroEstado').addEventListener('change', function() {
    const estado = this.value;
    const filas = document.querySelectorAll('tbody tr');
    
    filas.forEach(fila => {
        if (!estado || fila.cells[3].textContent.toLowerCase().includes(estado)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
