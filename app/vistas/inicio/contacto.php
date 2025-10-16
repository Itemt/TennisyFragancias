<?php require_once VIEWS_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="mb-4">Contacto</h1>
            
            <div class="row mb-5">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-geo-alt fs-1 text-primario"></i>
                            <h5 class="mt-3">Ubicación</h5>
                            <p class="small"><?= EMPRESA_CIUDAD ?><br><?= EMPRESA_DEPARTAMENTO ?>, <?= EMPRESA_PAIS ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-telephone fs-1 text-primario"></i>
                            <h5 class="mt-3">Teléfono</h5>
                            <p class="small"><?= EMPRESA_TELEFONO ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-envelope fs-1 text-primario"></i>
                            <h5 class="mt-3">Email</h5>
                            <p class="small"><?= EMPRESA_EMAIL ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Envíanos un Mensaje</h4>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Asunto</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mensaje</label>
                            <textarea class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primario">Enviar Mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/layout/footer.php'; ?>

