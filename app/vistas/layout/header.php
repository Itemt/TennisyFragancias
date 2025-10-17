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
    
    <!-- Preconnect para mejorar velocidad de carga -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Critical CSS inline - Previene FOUC -->
    <style>
        :root {
            --color-primario: #DC3545;
            --color-secundario: #000000;
            --color-terciario: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fb 100%);
            font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        main {
            flex: 1;
            opacity: 0;
            animation: fadeIn 0.3s ease-in forwards;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        /* Estilos críticos del navbar para evitar saltos */
        .navbar {
            box-shadow: 0 6px 20px rgba(0,0,0,.06);
            min-height: 56px;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
            backdrop-filter: blur(10px);
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }
        
        .navbar-nav .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .navbar-nav .nav-link.active {
            color: var(--color-primario) !important;
            background: rgba(220, 53, 69, 0.1);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        
        .navbar-brand img {
            height: 28px;
            width: auto;
            display: block;
        }
        
        .navbar-brand.text-primario {
            color: #E66982 !important;
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
        
        /* Loading state para prevenir saltos */
        .navbar-collapse {
            transition: none !important;
        }
        
        /* Estilos de botones críticos */
        .btn-primario {
            background-color: var(--color-primario);
            border-color: var(--color-primario);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primario:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: white;
        }
        
        /* Badge del carrito */
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
            transition: color 0.2s ease;
        }
        
        footer a:hover {
            color: var(--color-primario);
        }
        
        /* Estilos de productos */
        .producto-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            will-change: transform;
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
        
        /* Estilos críticos adicionales del CSS externo */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .section-title {
            position: relative;
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 3rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--color-primario);
            border-radius: 2px;
        }
        
        .btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
            text-transform: none;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .btn:active {
            transform: translateY(-1px);
        }
        
        .btn-primario {
            background: var(--gradient-primary);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }
        
        .btn-primario:hover {
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
            color: white;
        }
        
        .btn-outline-dark {
            border: 2px solid #212529;
            color: #212529;
            background: transparent;
        }
        
        .btn-outline-dark:hover {
            background: #212529;
            color: #fff;
            border-color: #212529;
            box-shadow: 0 8px 20px rgba(33, 37, 41, 0.3);
        }
        
        .btn-lg {
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            border-radius: 12px;
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 8px;
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-10px);
        }
        
        /* Estilos específicos para consistencia */
        .hero-content {
            z-index: 2;
            position: relative;
        }
        
        .hero-image {
            z-index: 1;
            position: relative;
        }
        
        .badge {
            border-radius: 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        .btn-light {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #2d3748;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        
        .btn-light:hover {
            background: white;
            color: #1a202c;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            background: transparent;
            backdrop-filter: blur(10px);
        }
        
        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            color: white;
        }
        
        /* Carousel indicators */
        .carousel-indicators {
            bottom: 20px;
        }
        
        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            background: transparent;
        }
        
        .carousel-indicators button.active {
            background: white;
            border-color: white;
        }
        
        /* Cards de productos */
        .producto-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .producto-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .card-img-top {
            transition: transform 0.3s ease;
        }
        
        .producto-card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        /* Categorías */
        .categoria-card {
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .categoria-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }
        
        /* Responsive fixes */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>
    
    <!-- Bootstrap 5 CSS con atributos de carga optimizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" media="all">
    
    <!-- Fuente moderna con display=swap para evitar bloqueo -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" media="all">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" media="all">
    
    <!-- Estilos personalizados adicionales -->
    <link rel="stylesheet" href="<?= URL_PUBLICA ?>css/styles.css" media="all" onerror="console.error('Error cargando CSS:', this.href)">
    
    <!-- Script para prevenir FOUC adicional -->
    <script>
        // Prevenir flash de contenido no estilizado
        document.documentElement.classList.add('loading');
    </script>
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secundario">
        <div class="container">
            <a class="navbar-brand text-primario" href="<?= Vista::url() ?>">
                <img src="<?= URL_PUBLICA ?>imagenes/tacones-altos.png" alt="Logo" loading="eager" style="height: 32px; width: auto;" onerror="this.src='<?= URL_PUBLICA ?>imagenes/logo.svg'; this.style.height='32px';">
                Tennis y Fragancias
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                         <a class="nav-link" href="<?= Vista::url('inicio/sobre_nosotros') ?>">Sobre Nosotros</a>
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?= Vista::escapar($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <main>