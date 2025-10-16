<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-bell"></i> Notificaciones</h1>
        <?php if (!empty($notificaciones)): ?>
            <a href="<?= Vista::url('notificaciones/marcar_todas_leidas') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-check-all"></i> Marcar todas como leídas
            </a>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($notificaciones)): ?>
        <div class="list-group">
            <?php foreach ($notificaciones as $notificacion): ?>
                <div class="list-group-item <?= $notificacion['leida'] ? '' : 'list-group-item-primary' ?>">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">
                            <?php if ($notificacion['tipo'] === 'pedido'): ?>
                                <i class="bi bi-box-seam text-info"></i>
                            <?php elseif ($notificacion['tipo'] === 'producto'): ?>
                                <i class="bi bi-tag text-success"></i>
                            <?php elseif ($notificacion['tipo'] === 'sistema'): ?>
                                <i class="bi bi-gear text-warning"></i>
                            <?php else: ?>
                                <i class="bi bi-megaphone text-danger"></i>
                            <?php endif; ?>
                            <?= Vista::escapar($notificacion['titulo']) ?>
                        </h6>
                        <small><?= Vista::formatearFechaHora($notificacion['fecha_creacion']) ?></small>
                    </div>
                    <p class="mb-1"><?= Vista::escapar($notificacion['mensaje']) ?></p>
                    <div class="d-flex gap-2">
                        <?php if ($notificacion['enlace']): ?>
                            <a href="<?= Vista::url($notificacion['enlace']) ?>" class="btn btn-sm btn-outline-primary">
                                Ver Detalles
                            </a>
                        <?php endif; ?>
                        <?php if (!$notificacion['leida']): ?>
                            <button onclick="marcarLeida(<?= $notificacion['id'] ?>)" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-check"></i> Marcar como leída
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-bell-slash fs-1 d-block mb-3"></i>
            <h4>No tienes notificaciones</h4>
            <p>Aquí aparecerán las actualizaciones importantes</p>
        </div>
    <?php endif; ?>
</div>

<script>
function marcarLeida(notificacionId) {
    const formData = new FormData();
    formData.append('notificacion_id', notificacionId);
    
    fetch('<?= Vista::url("notificaciones/marcar_leida") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            location.reload();
        }
    });
}
</script>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

