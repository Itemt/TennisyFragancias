<?php
/**
 * Controlador de Autenticación
 */
class AuthControlador extends Controlador {
    
    public function login() {
        // Si ya está autenticado, redirigir según rol
        if (isset($_SESSION['usuario_id'])) {
            $this->redirigirSegunRol($_SESSION['usuario_rol']);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->procesarLogin();
        } else {
            $datos = [
                'titulo' => 'Iniciar Sesión - ' . NOMBRE_SITIO,
                'email' => '',
                'error' => ''
            ];
            $this->cargarVista('auth/login', $datos);
        }
    }
    
    private function procesarLogin() {
        $email = $this->limpiarDatos($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validar datos
        if (empty($email) || empty($password)) {
            $datos = [
                'titulo' => 'Iniciar Sesión - ' . NOMBRE_SITIO,
                'email' => $email,
                'error' => 'Por favor complete todos los campos'
            ];
            $this->cargarVista('auth/login', $datos);
            return;
        }
        
        // Verificar credenciales
        $usuarioModelo = $this->cargarModelo('Usuario');
        $usuario = $usuarioModelo->autenticar($email, $password);
        
        if ($usuario) {
            // Iniciar sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_apellido'] = $usuario['apellido'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            $_SESSION['ultima_actividad'] = time();
            
            // Redirigir según rol
            $this->redirigirSegunRol($usuario['rol']);
        } else {
            $datos = [
                'titulo' => 'Iniciar Sesión - ' . NOMBRE_SITIO,
                'email' => $email,
                'error' => 'Credenciales incorrectas o cuenta inactiva'
            ];
            $this->cargarVista('auth/login', $datos);
        }
    }
    
    public function registro() {
        // Si ya está autenticado, redirigir
        if (isset($_SESSION['usuario_id'])) {
            $this->redirigirSegunRol($_SESSION['usuario_rol']);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->procesarRegistro();
        } else {
            $datos = [
                'titulo' => 'Registro - ' . NOMBRE_SITIO,
                'nombre' => '',
                'apellido' => '',
                'email' => '',
                'telefono' => '',
                'errores' => []
            ];
            $this->cargarVista('auth/registro', $datos);
        }
    }
    
    private function procesarRegistro() {
        $nombre = $this->limpiarDatos($_POST['nombre'] ?? '');
        $apellido = $this->limpiarDatos($_POST['apellido'] ?? '');
        $email = $this->limpiarDatos($_POST['email'] ?? '');
        $telefono = $this->limpiarDatos($_POST['telefono'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirmar = $_POST['password_confirmar'] ?? '';
        
        $errores = [];
        
        // Validaciones
        if (empty($nombre)) $errores[] = 'El nombre es obligatorio';
        if (empty($apellido)) $errores[] = 'El apellido es obligatorio';
        if (empty($email)) $errores[] = 'El email es obligatorio';
        if (!$this->validarEmail($email)) $errores[] = 'El email no es válido';
        if (empty($password)) $errores[] = 'La contraseña es obligatoria';
        if (strlen($password) < 6) $errores[] = 'La contraseña debe tener al menos 6 caracteres';
        if ($password !== $password_confirmar) $errores[] = 'Las contraseñas no coinciden';
        
        // Verificar si el email ya existe
        $usuarioModelo = $this->cargarModelo('Usuario');
        if ($usuarioModelo->emailExiste($email)) {
            $errores[] = 'El email ya está registrado';
        }
        
        if (!empty($errores)) {
            $datos = [
                'titulo' => 'Registro - ' . NOMBRE_SITIO,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'email' => $email,
                'telefono' => $telefono,
                'errores' => $errores
            ];
            $this->cargarVista('auth/registro', $datos);
            return;
        }
        
        // Registrar usuario
        $datosUsuario = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'telefono' => $telefono,
            'password' => $password,
            'rol' => ROL_CLIENTE
        ];
        
        if ($usuarioModelo->registrar($datosUsuario)) {
            // Auto-login después del registro
            $usuario = $usuarioModelo->obtenerPorEmail($email);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_apellido'] = $usuario['apellido'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            $_SESSION['ultima_actividad'] = time();
            
            $this->redirigir('productos');
        } else {
            $errores[] = 'Error al registrar el usuario. Intente nuevamente.';
            $datos = [
                'titulo' => 'Registro - ' . NOMBRE_SITIO,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'email' => $email,
                'telefono' => $telefono,
                'errores' => $errores
            ];
            $this->cargarVista('auth/registro', $datos);
        }
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        $this->redirigir('');
    }
    
    public function recuperar_password() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->limpiarDatos($_POST['email'] ?? '');
            
            if (empty($email) || !$this->validarEmail($email)) {
                $datos = [
                    'titulo' => 'Recuperar Contraseña - ' . NOMBRE_SITIO,
                    'error' => 'Por favor ingrese un email válido'
                ];
                $this->cargarVista('auth/recuperar_password', $datos);
                return;
            }
            
            $usuarioModelo = $this->cargarModelo('Usuario');
            $usuario = $usuarioModelo->obtenerPorEmail($email);
            
            if ($usuario) {
                $token = $usuarioModelo->generarTokenRecuperacion($email);
                // Aquí se enviaría el email con el token
                // Por ahora solo mostramos mensaje de éxito
            }
            
            // Siempre mostramos el mismo mensaje por seguridad
            $datos = [
                'titulo' => 'Recuperar Contraseña - ' . NOMBRE_SITIO,
                'exito' => 'Si el email existe, recibirás instrucciones para recuperar tu contraseña'
            ];
            $this->cargarVista('auth/recuperar_password', $datos);
        } else {
            $datos = [
                'titulo' => 'Recuperar Contraseña - ' . NOMBRE_SITIO
            ];
            $this->cargarVista('auth/recuperar_password', $datos);
        }
    }
    
    private function redirigirSegunRol($rol) {
        switch ($rol) {
            case ROL_ADMINISTRADOR:
                $this->redirigir('admin/dashboard');
                break;
            case ROL_EMPLEADO:
                $this->redirigir('empleado/panel');
                break;
            case ROL_CLIENTE:
            default:
                $this->redirigir('productos');
                break;
        }
    }
}
?>

