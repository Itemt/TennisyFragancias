<?php
/**
 * Controlador de Perfil de Usuario
 */
class PerfilControlador extends Controlador {
    
    public function index() {
        $this->verificarAutenticacion();
        
        $usuarioModelo = $this->cargarModelo('Usuario');
        $usuario = $usuarioModelo->obtenerPorId($_SESSION['usuario_id']);
        
        $datos = [
            'titulo' => 'Mi Perfil - ' . NOMBRE_SITIO,
            'usuario' => $usuario
        ];
        
        $this->cargarVista('perfil/index', $datos);
    }
    
    public function editar() {
        $this->verificarAutenticacion();
        
        $usuarioModelo = $this->cargarModelo('Usuario');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datosActualizar = [
                'nombre' => $this->limpiarDatos($_POST['nombre']),
                'apellido' => $this->limpiarDatos($_POST['apellido']),
                'telefono' => $this->limpiarDatos($_POST['telefono']),
                'direccion' => $this->limpiarDatos($_POST['direccion']),
                'ciudad' => $this->limpiarDatos($_POST['ciudad']),
                'departamento' => $this->limpiarDatos($_POST['departamento']),
                'codigo_postal' => $this->limpiarDatos($_POST['codigo_postal'] ?? '')
            ];
            
            if ($usuarioModelo->actualizarPerfil($_SESSION['usuario_id'], $datosActualizar)) {
                $_SESSION['usuario_nombre'] = $datosActualizar['nombre'];
                $_SESSION['usuario_apellido'] = $datosActualizar['apellido'];
                $_SESSION['exito'] = 'Perfil actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar el perfil';
            }
            
            $this->redirigir('perfil');
        } else {
            $usuario = $usuarioModelo->obtenerPorId($_SESSION['usuario_id']);
            $datos = [
                'titulo' => 'Editar Perfil - ' . NOMBRE_SITIO,
                'usuario' => $usuario
            ];
            $this->cargarVista('perfil/editar', $datos);
        }
    }
    
    public function cambiar_password() {
        $this->verificarAutenticacion();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $passwordActual = $_POST['password_actual'] ?? '';
            $passwordNuevo = $_POST['password_nuevo'] ?? '';
            $passwordConfirmar = $_POST['password_confirmar'] ?? '';
            
            $errores = [];
            
            if (empty($passwordActual) || empty($passwordNuevo)) {
                $errores[] = 'Todos los campos son obligatorios';
            }
            
            if (strlen($passwordNuevo) < 6) {
                $errores[] = 'La nueva contraseña debe tener al menos 6 caracteres';
            }
            
            if ($passwordNuevo !== $passwordConfirmar) {
                $errores[] = 'Las contraseñas nuevas no coinciden';
            }
            
            if (empty($errores)) {
                $usuarioModelo = $this->cargarModelo('Usuario');
                $usuario = $usuarioModelo->obtenerPorId($_SESSION['usuario_id']);
                
                if (password_verify($passwordActual, $usuario['password_hash'])) {
                    if ($usuarioModelo->cambiarPassword($_SESSION['usuario_id'], $passwordNuevo)) {
                        $_SESSION['exito'] = 'Contraseña actualizada correctamente';
                        $this->redirigir('perfil');
                        return;
                    } else {
                        $errores[] = 'Error al actualizar la contraseña';
                    }
                } else {
                    $errores[] = 'La contraseña actual es incorrecta';
                }
            }
            
            $datos = [
                'titulo' => 'Cambiar Contraseña - ' . NOMBRE_SITIO,
                'errores' => $errores
            ];
            $this->cargarVista('perfil/cambiar_password', $datos);
        } else {
            $datos = [
                'titulo' => 'Cambiar Contraseña - ' . NOMBRE_SITIO
            ];
            $this->cargarVista('perfil/cambiar_password', $datos);
        }
    }
}
?>

