<?php
/**
 * Controlador de Administrador
 */
class AdminControlador extends Controlador {
    
    public function dashboard() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        $productoModelo = $this->cargarModelo('Producto');
        $usuarioModelo = $this->cargarModelo('Usuario');
        
        // Obtener estadísticas
        $estadisticasPedidos = $pedidoModelo->obtenerEstadisticas();
        $estadisticasProductos = $productoModelo->obtenerEstadisticas();
        $estadisticasUsuarios = $usuarioModelo->obtenerEstadisticas();
        
        // Pedidos recientes
        $pedidosRecientes = $pedidoModelo->obtenerRecientes(10);
        
        // Productos más vendidos
        $detallePedidoModelo = $this->cargarModelo('DetallePedido');
        $productosMasVendidos = $detallePedidoModelo->obtenerMasVendidos(10);
        
        // Productos con stock bajo
        $productosStockBajo = $productoModelo->obtenerStockBajo();
        
        $datos = [
            'titulo' => 'Dashboard Administrativo - ' . NOMBRE_SITIO,
            'estadisticas_pedidos' => $estadisticasPedidos,
            'estadisticas_productos' => $estadisticasProductos,
            'estadisticas_usuarios' => $estadisticasUsuarios,
            'pedidos_recientes' => $pedidosRecientes,
            'productos_mas_vendidos' => $productosMasVendidos,
            'productos_stock_bajo' => $productosStockBajo
        ];
        
        $this->cargarVista('admin/dashboard', $datos);
    }
    
    // ========== GESTIÓN DE PRODUCTOS ==========
    
    public function productos() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $productoModelo = $this->cargarModelo('Producto');
        $productos = $productoModelo->obtenerTodos();
        
        $datos = [
            'titulo' => 'Gestión de Productos - ' . NOMBRE_SITIO,
            'productos' => $productos
        ];
        
        $this->cargarVista('admin/productos/lista', $datos);
    }
    
    public function producto_nuevo() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $categoriaModelo = $this->cargarModelo('Categoria');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->procesarNuevoProducto();
        } else {
            $categorias = $categoriaModelo->obtenerActivas();
            $datos = [
                'titulo' => 'Nuevo Producto - ' . NOMBRE_SITIO,
                'categorias' => $categorias
            ];
            $this->cargarVista('admin/productos/form', $datos);
        }
    }
    
    private function procesarNuevoProducto() {
        $productoModelo = $this->cargarModelo('Producto');
        
        $datosProducto = [
            'nombre' => $this->limpiarDatos($_POST['nombre']),
            'descripcion' => $this->limpiarDatos($_POST['descripcion']),
            'precio' => (float)$_POST['precio'],
            'precio_oferta' => !empty($_POST['precio_oferta']) ? (float)$_POST['precio_oferta'] : null,
            'categoria_id' => (int)$_POST['categoria_id'],
            'stock' => (int)$_POST['stock'],
            'stock_minimo' => (int)($_POST['stock_minimo'] ?? 5),
            'marca' => $this->limpiarDatos($_POST['marca']),
            'talla' => $this->limpiarDatos($_POST['talla'] ?? ''),
            'color' => $this->limpiarDatos($_POST['color'] ?? ''),
            'genero' => $this->limpiarDatos($_POST['genero']),
            'destacado' => isset($_POST['destacado']) ? 1 : 0,
            'estado' => 'activo'
        ];
        
        // Generar SKU
        $datosProducto['codigo_sku'] = $productoModelo->generarCodigoSKU($datosProducto['categoria_id']);
        
        // Manejar imagen
        if (!empty($_FILES['imagen']['name'])) {
            $resultado = $this->subirImagen($_FILES['imagen']);
            if ($resultado['exito']) {
                $datosProducto['imagen_principal'] = $resultado['nombre_archivo'];
            } else {
                $_SESSION['error'] = $resultado['mensaje'];
                $this->redirigir('admin/producto_nuevo');
                return;
            }
        }
        
        if ($productoModelo->crear($datosProducto)) {
            $_SESSION['exito'] = 'Producto creado correctamente';
            $this->redirigir('admin/productos');
        } else {
            $_SESSION['error'] = 'Error al crear el producto';
            $this->redirigir('admin/producto_nuevo');
        }
    }
    
    public function producto_editar($id) {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $productoModelo = $this->cargarModelo('Producto');
        $categoriaModelo = $this->cargarModelo('Categoria');
        
        $producto = $productoModelo->obtenerPorId($id);
        
        if (!$producto) {
            $this->redirigir('admin/productos');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datosActualizar = [
                'nombre' => $this->limpiarDatos($_POST['nombre']),
                'descripcion' => $this->limpiarDatos($_POST['descripcion']),
                'precio' => (float)$_POST['precio'],
                'precio_oferta' => !empty($_POST['precio_oferta']) ? (float)$_POST['precio_oferta'] : null,
                'categoria_id' => (int)$_POST['categoria_id'],
                'stock' => (int)$_POST['stock'],
                'stock_minimo' => (int)($_POST['stock_minimo'] ?? 5),
                'marca' => $this->limpiarDatos($_POST['marca']),
                'talla' => $this->limpiarDatos($_POST['talla'] ?? ''),
                'color' => $this->limpiarDatos($_POST['color'] ?? ''),
                'genero' => $this->limpiarDatos($_POST['genero']),
                'destacado' => isset($_POST['destacado']) ? 1 : 0,
                'estado' => $this->limpiarDatos($_POST['estado'])
            ];
            
            // Manejar nueva imagen
            if (!empty($_FILES['imagen']['name'])) {
                $resultado = $this->subirImagen($_FILES['imagen']);
                if ($resultado['exito']) {
                    $datosActualizar['imagen_principal'] = $resultado['nombre_archivo'];
                } else {
                    $_SESSION['error'] = $resultado['mensaje'];
                    // No redirigir, mostrar error en la misma página
                }
            }
            
            if (!isset($_SESSION['error'])) {
                if ($productoModelo->actualizar($id, $datosActualizar)) {
                    $_SESSION['exito'] = 'Producto actualizado correctamente';
                    $this->redirigir('admin/productos');
                } else {
                    $_SESSION['error'] = 'Error al actualizar el producto';
                }
            }
        }
        
        $categorias = $categoriaModelo->obtenerActivas();
        $datos = [
            'titulo' => 'Editar Producto - ' . NOMBRE_SITIO,
            'producto' => $producto,
            'categorias' => $categorias
        ];
        $this->cargarVista('admin/productos/form', $datos);
    }
    
    public function producto_eliminar($id) {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $productoModelo = $this->cargarModelo('Producto');
        if ($productoModelo->eliminar($id)) {
            $_SESSION['exito'] = 'Producto eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el producto';
        }
        $this->redirigir('admin/productos');
    }
    
    // ========== GESTIÓN DE CATEGORÍAS ==========
    
    public function categorias() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $categoriaModelo = $this->cargarModelo('Categoria');
        $categorias = $categoriaModelo->obtenerTodos();
        
        $datos = [
            'titulo' => 'Gestión de Categorías - ' . NOMBRE_SITIO,
            'categorias' => $categorias
        ];
        
        $this->cargarVista('admin/categorias/lista', $datos);
    }
    
    // ========== GESTIÓN DE USUARIOS ==========
    
    
    public function usuario_cambiar_rol() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $usuarioId = (int)($_POST['usuario_id'] ?? 0);
        $rolNuevo = $this->limpiarDatos($_POST['rol'] ?? '');
        
        if ($usuarioId === (int)$_SESSION['usuario_id']) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'No puedes cambiar tu propio rol']);
            return;
        }
        
        $usuarioModelo = $this->cargarModelo('Usuario');
        if ($usuarioModelo->actualizar($usuarioId, ['rol' => $rolNuevo])) {
            $this->enviarJson(['exito' => true, 'mensaje' => 'Rol actualizado']);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al actualizar']);
        }
    }
    
    // ========== REPORTES ==========
    
    public function reportes() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        $detallePedidoModelo = $this->cargarModelo('DetallePedido');
        
        // Filtros de fecha
        $fechaDesde = $_GET['fecha_desde'] ?? date('Y-m-01');
        $fechaHasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
        
        // Estadísticas del período
        $estadisticas = $pedidoModelo->obtenerEstadisticas($fechaDesde, $fechaHasta);
        
        // Ventas por mes del año actual
        $ventasPorMes = $pedidoModelo->obtenerVentasPorMes(date('Y'));
        
        // Productos más vendidos
        $productosMasVendidos = $detallePedidoModelo->obtenerMasVendidos(20, $fechaDesde, $fechaHasta);
        
        $datos = [
            'titulo' => 'Reportes - ' . NOMBRE_SITIO,
            'estadisticas' => $estadisticas,
            'ventas_por_mes' => $ventasPorMes,
            'productos_mas_vendidos' => $productosMasVendidos,
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta
        ];
        
        $this->cargarVista('admin/reportes', $datos);
    }
    
    // ========== FUNCIONES AUXILIARES ==========
    
    private function subirImagen($archivo) {
        $directorioDestino = PUBLIC_PATH . '/imagenes/productos/';
        
        // Crear directorio si no existe
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);
        }
        
        // Validar si hay errores en la subida
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return [
                'exito' => false,
                'mensaje' => 'Error al subir el archivo. Por favor, intente nuevamente.'
            ];
        }
        
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $nombreArchivo = 'prod_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
        $rutaCompleta = $directorioDestino . $nombreArchivo;
        
        // Validar tipo de archivo
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($extension, $tiposPermitidos)) {
            return [
                'exito' => false,
                'mensaje' => 'Tipo de imagen no soportado. Los formatos permitidos son: JPEG, PNG, GIF y WEBP.'
            ];
        }
        
        // Validar tipo MIME real del archivo (seguridad adicional)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $archivo['tmp_name']);
        finfo_close($finfo);
        
        $mimePermitidos = [
            'image/jpeg',
            'image/jpg', 
            'image/png',
            'image/gif',
            'image/webp'
        ];
        
        if (!in_array($mimeType, $mimePermitidos)) {
            return [
                'exito' => false,
                'mensaje' => 'El archivo no es una imagen válida. Los formatos permitidos son: JPEG, PNG, GIF y WEBP.'
            ];
        }
        
        // Validar tamaño
        if ($archivo['size'] > TAMANO_MAXIMO_IMAGEN) {
            $tamanoMaxMB = TAMANO_MAXIMO_IMAGEN / 1024 / 1024;
            return [
                'exito' => false,
                'mensaje' => "La imagen es demasiado grande. El tamaño máximo permitido es {$tamanoMaxMB}MB."
            ];
        }
        
        // Intentar mover el archivo
        if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
            return [
                'exito' => true,
                'nombre_archivo' => $nombreArchivo
            ];
        }
        
        return [
            'exito' => false,
            'mensaje' => 'Error al guardar la imagen. Verifique los permisos del directorio.'
        ];
    }
    
    /**
     * Gestión de usuarios
     */
    public function usuarios() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $usuarioModelo = $this->cargarModelo('Usuario');
        
        // Filtros
        $filtros = [
            'rol' => $_GET['rol'] ?? '',
            'estado' => $_GET['estado'] ?? '',
            'buscar' => $_GET['buscar'] ?? '',
            'pagina' => (int)($_GET['pagina'] ?? 1)
        ];
        
        // Obtener usuarios
        $usuarios = $usuarioModelo->obtenerTodos($filtros);
        
        // Calcular paginación
        $totalUsuarios = $usuarioModelo->contarUsuarios($filtros);
        $usuariosPorPagina = 20;
        $totalPaginas = ceil($totalUsuarios / $usuariosPorPagina);
        
        $paginacion = [
            'pagina_actual' => $filtros['pagina'],
            'total_paginas' => $totalPaginas,
            'total_registros' => $totalUsuarios
        ];
        
        $datos = [
            'titulo' => 'Gestión de Usuarios - ' . NOMBRE_SITIO,
            'usuarios' => $usuarios,
            'paginacion' => $paginacion,
            'filtros' => $filtros
        ];
        
        $this->cargarVista('admin/usuarios', $datos);
    }
    
    /**
     * Cambiar contraseña de usuario
     */
    public function cambiarPassword() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $usuarioId = (int)($_POST['usuario_id'] ?? 0);
        $nuevaPassword = $_POST['nueva_password'] ?? '';
        $confirmarPassword = $_POST['confirmar_password'] ?? '';
        
        // Validar datos
        if ($usuarioId <= 0) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'ID de usuario inválido']);
            return;
        }
        
        if (empty($nuevaPassword) || strlen($nuevaPassword) < 6) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'La contraseña debe tener al menos 6 caracteres']);
            return;
        }
        
        if ($nuevaPassword !== $confirmarPassword) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Las contraseñas no coinciden']);
            return;
        }
        
        // Cambiar contraseña
        $usuarioModelo = $this->cargarModelo('Usuario');
        $passwordHash = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        
        if ($usuarioModelo->actualizarPassword($usuarioId, $passwordHash)) {
            $this->enviarJson(['exito' => true, 'mensaje' => 'Contraseña cambiada exitosamente']);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al cambiar la contraseña']);
        }
    }
    
    /**
     * Cambiar estado de usuario
     */
    public function cambiarEstado() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $usuarioId = (int)($_POST['usuario_id'] ?? 0);
        $nuevoEstado = $_POST['estado'] ?? '';
        
        // Validar datos
        if ($usuarioId <= 0) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'ID de usuario inválido']);
            return;
        }
        
        $estadosValidos = ['activo', 'inactivo', 'suspendido'];
        if (!in_array($nuevoEstado, $estadosValidos)) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Estado inválido']);
            return;
        }
        
        // Cambiar estado
        $usuarioModelo = $this->cargarModelo('Usuario');
        
        if ($usuarioModelo->actualizarEstado($usuarioId, $nuevoEstado)) {
            $this->enviarJson(['exito' => true, 'mensaje' => 'Estado del usuario actualizado exitosamente']);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al actualizar el estado del usuario']);
        }
    }
}
