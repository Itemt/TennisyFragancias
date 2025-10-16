<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 8rem;"></i>
            <h1 class="display-1 fw-bold">404</h1>
            <h2 class="mb-4">Página no encontrada</h2>
            <p class="lead mb-4">Lo sentimos, la página que buscas no existe o ha sido movida.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="<?= Vista::url() ?>" class="btn btn-primario">
                    <i class="bi bi-house"></i> Volver al Inicio
                </a>
                <a href="<?= Vista::url('productos') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-shop"></i> Ver Productos
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

