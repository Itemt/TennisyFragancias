<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <h1 class="mb-4">Mi Perfil</h1>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle fs-1 text-primario d-block mb-3"></i>
                    <h4><?= Vista::escapar($usuario['nombre'] . ' ' . $usuario['apellido']) ?></h4>
                    <p class="text-muted"><?= Vista::obtenerBadgeRol($usuario['rol']) ?></p>
                    <p class="small text-muted">Miembro desde <?= Vista::formatearFecha($usuario['fecha_registro']) ?></p>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= Vista::url('perfil/editar') ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-pencil"></i> Editar Perfil
                    </a>
                    <a href="<?= Vista::url('perfil/cambiar_password') ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-key"></i> Cambiar Contraseña
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primario text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Nombre Completo:</strong><br>
                            <?= Vista::escapar($usuario['nombre'] . ' ' . $usuario['apellido']) ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong><br>
                            <?= Vista::escapar($usuario['email']) ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Teléfono:</strong><br>
                            <?= Vista::escapar($usuario['telefono'] ?? 'No registrado') ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Estado:</strong><br>
                            <?php if ($usuario['estado'] === 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?= ucfirst($usuario['estado']) ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <strong>Dirección:</strong><br>
                            <?= Vista::escapar($usuario['direccion'] ?? 'No registrada') ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Ciudad:</strong><br>
                            <?= Vista::escapar($usuario['ciudad']) ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <strong>Departamento:</strong><br>
                            <?= Vista::escapar($usuario['departamento']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

