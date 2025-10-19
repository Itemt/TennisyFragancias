<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once VIEWS_PATH . '/admin/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestión de Usuarios</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                            <i class="bi bi-person-plus"></i> Crear Usuario
                        </button>
                    </div>
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
                                                    onclick="cambiarPassword(<?= $usuario['id'] ?>, <?= htmlspecialchars(json_encode($usuario['nombre'] . ' ' . $usuario['apellido'])) ?>)">
                                                <i class="bi bi-key"></i> Cambiar Contraseña
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
                                                       onclick="eliminarUsuario(<?= $usuario['id'] ?>, <?= htmlspecialchars(json_encode($usuario['nombre'] . ' ' . $usuario['apellido'])) ?>)">
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
            <form id="formCambiarPassword" method="POST">
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

<!-- Modal para crear usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCrearUsuario" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="crear_nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="crear_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="crear_apellido" class="form-label">Apellido *</label>
                        <input type="text" class="form-control" id="crear_apellido" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="crear_email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="crear_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="crear_telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="crear_telefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="crear_password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control" id="crear_password" name="password" required>
                        <div class="form-text">La contraseña debe tener al menos 6 caracteres.</div>
                    </div>
                    <div class="mb-3">
                        <label for="crear_confirmar_password" class="form-label">Confirmar Contraseña *</label>
                        <input type="password" class="form-control" id="crear_confirmar_password" name="confirmar_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="crear_rol" class="form-label">Rol *</label>
                        <select class="form-select" id="crear_rol" name="rol" required>
                            <option value="">Seleccionar rol...</option>
                            <option value="cliente">Cliente</option>
                            <option value="empleado">Empleado</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="crear_estado" class="form-label">Estado *</label>
                        <select class="form-select" id="crear_estado" name="estado" required>
                            <option value="activo" selected>Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Crear Usuario</button>
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
        fetch('<?= Vista::url("admin/cambiar-estado") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                usuario_id: usuarioId,
                estado: nuevoEstado
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
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
            alert('Error al cambiar el estado del usuario: ' + error.message);
        });
    }
}

// Manejar envío del formulario de cambio de contraseña
document.getElementById('formCambiarPassword').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Formulario de cambio de contraseña enviado');
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    console.log('Datos del formulario:', data);
    
    if (data.nueva_password !== data.confirmar_password) {
        alert('Las contraseñas no coinciden');
        return;
    }
    
    if (data.nueva_password.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return;
    }
    
    // Deshabilitar el botón de envío para evitar múltiples envíos
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Cambiando...';
    
    const url = '<?= Vista::url("admin/cambiar-password") ?>';
    console.log('Enviando a:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta recibida:', data);
        if (data.exito) {
            alert(data.mensaje);
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalCambiarPassword'));
            if (modalInstance) {
                modalInstance.hide();
            }
            location.reload();
        } else {
            alert('Error: ' + data.mensaje);
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar la contraseña: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});

function eliminarUsuario(usuarioId, nombreUsuario) {
    if (confirm(`¿Estás seguro de que deseas eliminar al usuario "${nombreUsuario}"?\n\nEsta acción no se puede deshacer y eliminará todos los datos del usuario.`)) {
        fetch('<?= Vista::url("admin/eliminar-usuario") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                usuario_id: usuarioId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
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
            alert('Error al eliminar el usuario: ' + error.message);
        });
    }
}

// Manejar envío del formulario de crear usuario
document.getElementById('formCrearUsuario').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Formulario de crear usuario enviado');
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    console.log('Datos del formulario:', data);
    
    // Validar contraseñas
    if (data.password !== data.confirmar_password) {
        alert('Las contraseñas no coinciden');
        return;
    }
    
    if (data.password.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return;
    }
    
    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.email)) {
        alert('Por favor ingrese un email válido');
        return;
    }
    
    // Deshabilitar el botón de envío
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Creando...';
    
    const url = '<?= Vista::url("admin/crear-usuario") ?>';
    console.log('Enviando a:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta recibida:', data);
        if (data.exito) {
            alert(data.mensaje);
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalCrearUsuario'));
            if (modalInstance) {
                modalInstance.hide();
            }
            location.reload();
        } else {
            alert('Error: ' + data.mensaje);
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al crear el usuario: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>
