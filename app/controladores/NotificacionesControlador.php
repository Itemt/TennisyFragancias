<?php
/**
 * Controlador de Notificaciones
 */
class NotificacionesControlador extends Controlador {
    
    public function index() {
        $this->verificarAutenticacion();
        
        $notificacionModelo = $this->cargarModelo('Notificacion');
        $notificaciones = $notificacionModelo->obtenerPorUsuario($_SESSION['usuario_id']);
        
        $datos = [
            'titulo' => 'Notificaciones - ' . NOMBRE_SITIO,
            'notificaciones' => $notificaciones
        ];
        
        $this->cargarVista('notificaciones/index', $datos);
    }
    
    public function marcar_leida() {
        $this->verificarAutenticacion();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $notificacionId = (int)($_POST['notificacion_id'] ?? 0);
        
        $notificacionModelo = $this->cargarModelo('Notificacion');
        if ($notificacionModelo->marcarComoLeida($notificacionId)) {
            $this->enviarJson(['exito' => true, 'mensaje' => 'Notificación marcada como leída']);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al marcar notificación']);
        }
    }
    
    public function marcar_todas_leidas() {
        $this->verificarAutenticacion();
        
        $notificacionModelo = $this->cargarModelo('Notificacion');
        if ($notificacionModelo->marcarTodasLeidas($_SESSION['usuario_id'])) {
            $_SESSION['exito'] = 'Todas las notificaciones marcadas como leídas';
        } else {
            $_SESSION['error'] = 'Error al marcar notificaciones';
        }
        
        $this->redirigir('notificaciones');
    }
    
    public function contar() {
        $this->verificarAutenticacion();
        
        $notificacionModelo = $this->cargarModelo('Notificacion');
        $total = $notificacionModelo->contarNoLeidas($_SESSION['usuario_id']);
        
        $this->enviarJson(['total' => $total]);
    }
}
?>

