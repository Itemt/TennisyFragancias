<?php
/**
 * Clase Vista - Helper para vistas
 */
class Vista {
    
    /**
     * Formatear precio en pesos colombianos
     */
    public static function formatearPrecio($precio) {
        return '$' . number_format($precio, 0, ',', '.');
    }
    
    /**
     * Formatear fecha
     */
    public static function formatearFecha($fecha) {
        $timestamp = strtotime($fecha);
        return date('d/m/Y', $timestamp);
    }
    
    /**
     * Formatear fecha y hora
     */
    public static function formatearFechaHora($fecha) {
        $timestamp = strtotime($fecha);
        return date('d/m/Y H:i', $timestamp);
    }
    
    /**
     * Obtener badge de estado de pedido
     */
    public static function obtenerBadgeEstado($estado) {
        $badges = [
            'pendiente' => '<span class="badge bg-warning text-dark">Pendiente</span>',
            'enviado' => '<span class="badge bg-info">Enviado</span>',
            'entregado' => '<span class="badge bg-success">Entregado</span>',
            'cancelado' => '<span class="badge bg-danger">Cancelado</span>'
        ];
        
        return $badges[$estado] ?? '<span class="badge bg-secondary">Desconocido</span>';
    }
    
    /**
     * Obtener badge de rol de usuario
     */
    public static function obtenerBadgeRol($rol) {
        $badges = [
            'administrador' => '<span class="badge bg-danger">Administrador</span>',
            'empleado' => '<span class="badge bg-primary">Empleado</span>',
            'cliente' => '<span class="badge bg-success">Cliente</span>'
        ];
        
        return $badges[$rol] ?? '<span class="badge bg-secondary">Desconocido</span>';
    }
    
    /**
     * Escapar HTML
     */
    public static function escapar($texto) {
        if ($texto === null || $texto === '') {
            return '';
        }
        return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Generar URL
     */
    public static function url($ruta = '') {
        return URL_BASE . $ruta;
    }
    
    /**
     * Generar URL pública
     */
    public static function urlPublica($ruta = '') {
        return URL_PUBLICA . $ruta;
    }
}
