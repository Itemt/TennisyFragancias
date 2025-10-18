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
                        <a class="nav-link active" href="<?= Vista::url('admin/usuarios') ?>">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('admin/pedidos') ?>">
                            <i class="bi bi-bag"></i> Pedidos
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestión de Usuarios</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword">
                        <i class="bi bi-key"></i> Cambiar Contraseña
                    </button>
                </div>
            </div>

            <!-- Filtros -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <select class="form-select" id="filtro-rol">
                        <option value="">Todos los roles</option>
                        <option value="administrador">Administrador</option>
                        <option value="empleado">Empleado</option>
                        <option value="cliente">Cliente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtro-estado">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="suspendido">Suspendido</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="filtro-buscar" placeholder="Buscar por nombre o email">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" onclick="aplicarFiltros()">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Última Conexión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td>#<?= $usuario['id'] ?></td>
                                    <td>
                                        <div>
                                            <strong><?= Vista::escapar($usuario['nombre'] . ' ' . $usuario['apellido']) ?></strong>
                                            <?php if ($usuario['telefono']): ?>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="bi bi-telephone"></i> <?= Vista::escapar($usuario['telefono']) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="mailto:<?= Vista::escapar($usuario['email']) ?>" class="text-decoration-none">
                                            <?= Vista::escapar($usuario['email']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $usuario['rol'] === 'administrador' ? 'danger' : ($usuario['rol'] === 'empleado' ? 'warning' : 'info') ?>">
                                            <?= ucfirst($usuario['rol']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $usuario['estado'] === 'activo' ? 'success' : ($usuario['estado'] === 'suspendido' ? 'danger' : 'secondary') ?>">
                                            <?= ucfirst($usuario['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($usuario['ultima_conexion']): ?>
                                            <?= date('d/m/Y H:i', strtotime($usuario['ultima_conexion'])) ?>
                                        <?php else: ?>
                                            <span class="text-muted">Nunca</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="cambiarPassword(<?= $usuario['id'] ?>, '<?= Vista::escapar($usuario['nombre'] . ' ' . $usuario['apellido']) ?>')">
                                                <i class="bi bi-key"></i> Cambiar Password
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" 
                                                    data-bs-toggle="dropdown">
                                                <i class="bi bi-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       onclick="cambiarEstado(<?= $usuario['id'] ?>, 'activo')">
                                                        <i class="bi bi-check-circle"></i> Activar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       onclick="cambiarEstado(<?= $usuario['id'] ?>, 'inactivo')">
                                                        <i class="bi bi-pause-circle"></i> Desactivar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" 
                                                       onclick="eliminarUsuario(<?= $usuario['id'] ?>, '<?= Vista::escapar($usuario['nombre'] . ' ' . $usuario['apellido']) ?>')">
                                                        <i class="bi bi-trash"></i> Eliminar
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
                                    <i class="bi bi-people fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No hay usuarios disponibles</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <?php if (isset($paginacion) && $paginacion['total_paginas'] > 1): ?>
                <nav aria-label="Paginación de usuarios">
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

<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="modalCambiarPassword" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCambiarPassword">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="usuario_id" class="form-label">Usuario</label>
                        <select class="form-select" id="usuario_id" name="usuario_id" required>
                            <option value="">Seleccionar usuario</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['id'] ?>">
                                    <?= Vista::escapar($usuario['nombre'] . ' ' . $usuario['apellido'] . ' (' . $usuario['email'] . ')') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nueva_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="nueva_password" name="nueva_password" required>
                        <div class="form-text">La contraseña debe tener al menos 6 caracteres.</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function aplicarFiltros() {
    const rol = document.getElementById('filtro-rol').value;
    const estado = document.getElementById('filtro-estado').value;
    const buscar = document.getElementById('filtro-buscar').value;
    
    let url = new URL(window.location);
    if (rol) url.searchParams.set('rol', rol);
    if (estado) url.searchParams.set('estado', estado);
    if (buscar) url.searchParams.set('buscar', buscar);
    
    window.location.href = url.toString();
}

function cambiarPassword(usuarioId, nombreUsuario) {
    // Establecer el usuario seleccionado
    const selectUsuario = document.getElementById('usuario_id');
    selectUsuario.value = usuarioId;
    
    // Limpiar campos de contraseña
    document.getElementById('nueva_password').value = '';
    document.getElementById('confirmar_password').value = '';
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('modalCambiarPassword'));
    modal.show();
}

function cambiarEstado(usuarioId, nuevoEstado) {
    if (confirm(`¿Estás seguro de cambiar el estado del usuario a "${nuevoEstado}"?`)) {
        fetch('<?= Vista::url("admin/usuarios/cambiar-estado") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                usuario_id: usuarioId,
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
            alert('Error al cambiar el estado del usuario');
        });
    }
}

// Manejar envío del formulario de cambio de contraseña
document.getElementById('formCambiarPassword').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    if (data.nueva_password !== data.confirmar_password) {
        alert('Las contraseñas no coinciden');
        return;
    }
    
    if (data.nueva_password.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return;
    }
    
    fetch('<?= Vista::url("admin/usuarios/cambiar-password") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            alert(data.mensaje);
            bootstrap.Modal.getInstance(document.getElementById('modalCambiarPassword')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar la contraseña');
    });
});

function eliminarUsuario(usuarioId, nombreUsuario) {
    if (confirm(`¿Estás seguro de que deseas eliminar al usuario "${nombreUsuario}"?\n\nEsta acción no se puede deshacer y eliminará todos los datos del usuario.`)) {
        fetch('<?= Vista::url("admin/usuarios/eliminar") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                usuario_id: usuarioId
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
            alert('Error al eliminar el usuario');
        });
    }
}
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
