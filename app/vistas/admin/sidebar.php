<?php
// Sidebar para el panel de administración
$currentPage = basename($_SERVER['REQUEST_URI']);
$currentSection = explode('/', $currentPage)[0] ?? '';
?>

<div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-3">
            <h6 class="text-muted">Panel Administrativo</h6>
        </div>
        
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'dashboard') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/dashboard') ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Gestión de Productos -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'productos') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/productos') ?>">
                    <i class="bi bi-box-seam"></i> Productos
                </a>
            </li>
            
            <!-- Gestión de Categorías -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'categorias') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/categorias') ?>">
                    <i class="bi bi-tags"></i> Categorías
                </a>
            </li>
            
            <!-- Gestión de Usuarios -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'usuarios') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/usuarios') ?>">
                    <i class="bi bi-people"></i> Usuarios
                </a>
            </li>
            
            <!-- Pedidos -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'pedidos') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/pedidos') ?>">
                    <i class="bi bi-receipt"></i> Pedidos
                </a>
            </li>
            
            <!-- Reportes -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'reportes') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/reportes') ?>">
                    <i class="bi bi-graph-up"></i> Reportes
                </a>
            </li>
            
            <!-- Gestión de Stock -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'actualizar-stock') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/actualizar-stock') ?>">
                    <i class="bi bi-boxes"></i> Stock
                </a>
            </li>
            
            <!-- Historial de Stock -->
            <li class="nav-item">
                <a class="nav-link <?= strpos($currentPage, 'historial-stock') !== false ? 'active' : '' ?>" 
                   href="<?= Vista::url('admin/historial-stock') ?>">
                    <i class="bi bi-clock-history"></i> Historial Stock
                </a>
            </li>
        </ul>
        
        <hr>
        
        <!-- Acciones Rápidas -->
        <div class="text-center">
            <h6 class="text-muted">Acciones Rápidas</h6>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?= Vista::url('admin/producto_nuevo') ?>">
                    <i class="bi bi-plus-circle"></i> Nuevo Producto
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Vista::url('admin/categoria_crear') ?>">
                    <i class="bi bi-tag"></i> Nueva Categoría
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= Vista::url('admin/actualizar-stock') ?>">
                    <i class="bi bi-arrow-up-circle"></i> Actualizar Stock
                </a>
            </li>
        </ul>
    </div>
</div>
