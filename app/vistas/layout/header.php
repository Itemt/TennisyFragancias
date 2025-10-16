<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Tennis y Fragancias' ?></title>
    
    <!-- Favicon & App Icons -->
    <link rel="icon" href="<?= URL_PUBLICA ?>imagenes/tacones-altos.png" type="image/png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= URL_PUBLICA ?>imagenes/tacones-altos.png">
    <link rel="shortcut icon" href="<?= URL_PUBLICA ?>imagenes/tacones-altos.png" type="image/png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?= URL_PUBLICA ?>css/styles.css">
    <style>
        :root {
            --color-primario: #DC3545;
            --color-secundario: #000000;
            --color-terciario: #FFFFFF;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fb 100%);
            font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
        }
        
        main {
            flex: 1;
        }
        
        .bg-primario {
            background-color: var(--color-primario) !important;
        }
        
        .bg-secundario {
            background-color: var(--color-secundario) !important;
        }
        
        .text-primario {
            color: var(--color-primario) !important;
        }
        
        .btn-primario {
            background-color: var(--color-primario);
            border-color: var(--color-primario);
            color: white;
        }
        
        .btn-primario:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: white;
        }
        
        .navbar-brand { font-weight: bold; font-size: 1.25rem; display: flex; align-items: center; gap: .5rem; }
        .navbar-brand img { height: 28px; width: auto; display: block; }
         /* Color de marca acorde al ícono (rosa) */
         .navbar-brand.text-primario { color: #E66982 !important; }
        .navbar { box-shadow: 0 6px 20px rgba(0,0,0,.06); }
        
        .producto-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .precio-oferta {
            color: var(--color-primario);
            font-weight: bold;
        }
        
        .precio-original {
            text-decoration: line-through;
            color: #6c757d;
        }
        
        .badge-carrito {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--color-primario);
        }
        
        footer {
            background-color: var(--color-secundario);
            color: white;
            margin-top: auto;
        }
        
        footer a {
            color: white;
            text-decoration: none;
        }
        
        footer a:hover {
            color: var(--color-primario);
        }
    </style>
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secundario">
        <div class="container">
            <a class="navbar-brand text-primario" href="<?= Vista::url() ?>">
                <img src="<?= URL_PUBLICA ?>imagenes/tacones-altos.png" alt="Logo">
                Tennis y Fragancias
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url() ?>">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('productos') ?>">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Vista::url('inicio/contacto') ?>">Contacto</a>
                    </li>
                    
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <!-- Usuario autenticado -->
                        <?php if ($_SESSION['usuario_rol'] === ROL_ADMINISTRADOR): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Vista::url('admin/dashboard') ?>">
                                    <i class="bi bi-speedometer2"></i> Admin
                                </a>
                            </li>
                        <?php elseif ($_SESSION['usuario_rol'] === ROL_EMPLEADO): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Vista::url('empleado/panel') ?>">
                                    <i class="bi bi-briefcase"></i> Panel
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item position-relative">
                                <a class="nav-link" href="<?= Vista::url('carrito') ?>">
                                    <i class="bi bi-cart3"></i> Carrito
                                    <span class="badge badge-carrito rounded-pill" id="carrito-contador">0</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Vista::url('pedidos') ?>">
                                    <i class="bi bi-box-seam"></i> Mis Pedidos
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?= Vista::escapar($_SESSION['usuario_nombre']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= Vista::url('perfil') ?>">Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= Vista::url('auth/logout') ?>">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Usuario no autenticado -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Vista::url('auth/login') ?>">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primario btn-sm ms-2" href="<?= Vista::url('auth/registro') ?>">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Mensajes de alerta -->
    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-check-circle"></i> <?= Vista::escapar($_SESSION['exito']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?= Vista::escapar($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <main>

