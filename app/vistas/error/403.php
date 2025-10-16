<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <i class="bi bi-shield-x text-danger" style="font-size: 8rem;"></i>
            <h1 class="display-1 fw-bold">403</h1>
            <h2 class="mb-4">Acceso Denegado</h2>
            <p class="lead mb-4">No tienes permisos para acceder a esta sección.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="<?= Vista::url() ?>" class="btn btn-primario">
                    <i class="bi bi-house"></i> Volver al Inicio
                </a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Atrás
                    </a>
                <?php else: ?>
                    <a href="<?= Vista::url('auth/login') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-person"></i> Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

