<?php
/**
 * Controlador de Administrador
 */
class AdminControlador extends Controlador {
    
    public function index() {
        // Redirigir al dashboard por defecto
        $this->redirigir('admin/dashboard');
    }
    
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
        $productos = $productoModelo->obtenerProductosAgrupados();
        
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
            
            // Cargar opciones para los dropdowns
            $marcaModelo = $this->cargarModelo('Marca');
            $tallaModelo = $this->cargarModelo('Talla');
            $colorModelo = $this->cargarModelo('Color');
            $generoModelo = $this->cargarModelo('Genero');
            
            $datos = [
                'titulo' => 'Nuevo Producto - ' . NOMBRE_SITIO,
                'categorias' => $categorias,
                'marcas' => $marcaModelo->obtenerTodos(),
                'tallas' => $tallaModelo->obtenerTodos(),
                'colores' => $colorModelo->obtenerTodos(),
                'generos' => $generoModelo->obtenerTodos()
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
            'stock' => 0, // Se maneja por tallas individuales
            'stock_minimo' => (int)($_POST['stock_minimo'] ?? 5),
            'marca_id' => !empty($_POST['marca_id']) ? (int)$_POST['marca_id'] : null,
            'talla_id' => !empty($_POST['talla_id']) ? (int)$_POST['talla_id'] : null,
            'color_id' => !empty($_POST['color_id']) ? (int)$_POST['color_id'] : null,
            'genero_id' => !empty($_POST['genero_id']) ? (int)$_POST['genero_id'] : null,
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
        
        // Crear producto sin tallas (las tallas se agregan después en "Actualizar Stock")
        $datosProducto['talla_id'] = null; // Sin talla por defecto
        $datosProducto['stock'] = 0; // Se maneja por tallas individuales
        $datosProducto['codigo_sku'] = $productoModelo->generarCodigoSKU($datosProducto['categoria_id'], null);
        
        if ($productoModelo->crear($datosProducto)) {
            $_SESSION['exito'] = 'Producto creado exitosamente. Puedes agregar tallas en "Actualizar Stock"';
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
                'stock' => isset($_POST['stock']) ? (int)$_POST['stock'] : $producto['stock'],
                'stock_minimo' => (int)($_POST['stock_minimo'] ?? 5),
                'marca_id' => !empty($_POST['marca_id']) ? (int)$_POST['marca_id'] : null,
                'talla_id' => !empty($_POST['talla_id']) ? (int)$_POST['talla_id'] : null,
                'color_id' => !empty($_POST['color_id']) ? (int)$_POST['color_id'] : null,
                'genero_id' => !empty($_POST['genero_id']) ? (int)$_POST['genero_id'] : null,
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
        
        // Cargar datos para los dropdowns
        $marcaModelo = $this->cargarModelo('Marca');
        $tallaModelo = $this->cargarModelo('Talla');
        $colorModelo = $this->cargarModelo('Color');
        $generoModelo = $this->cargarModelo('Genero');
        
        $datos = [
            'titulo' => 'Editar Producto - ' . NOMBRE_SITIO,
            'producto' => $producto,
            'categorias' => $categorias,
            'marcas' => $marcaModelo->obtenerTodos(),
            'tallas' => $tallaModelo->obtenerTodos(),
            'colores' => $colorModelo->obtenerTodos(),
            'generos' => $generoModelo->obtenerTodos()
        ];
        $this->cargarVista('admin/productos/form', $datos);
    }
    
    public function producto_eliminar($id) {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        try {
            $productoModelo = $this->cargarModelo('Producto');
            
            // Verificar que el producto existe
            $producto = $productoModelo->obtenerPorId($id);
            if (!$producto) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Producto no encontrado']);
                return;
            }
            
            // Verificar si el producto tiene pedidos asociados (todas las variantes)
            $db = BaseDatos::obtenerInstancia()->obtenerConexion();
            
            // Primero obtener el nombre del producto
            $stmt = $db->prepare("SELECT nombre FROM productos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $producto = $stmt->fetch();
            
            if (!$producto) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Producto no encontrado']);
                return;
            }
            
            // Verificar pedidos asociados a todas las variantes del producto
            $stmt = $db->prepare("
                SELECT COUNT(*) as total 
                FROM detalle_pedidos dp 
                INNER JOIN productos p ON dp.producto_id = p.id 
                WHERE p.nombre = :nombre
            ");
            $stmt->bindParam(':nombre', $producto['nombre']);
            $stmt->execute();
            $pedidosAsociados = $stmt->fetch()['total'];
            
            if ($pedidosAsociados > 0) {
                $this->enviarJson([
                    'exito' => false, 
                    'mensaje' => "No se puede eliminar el producto porque tiene $pedidosAsociados pedidos asociados. Se recomienda desactivar el producto en su lugar."
                ]);
                return;
            }
            
            // Eliminar el producto
            if ($productoModelo->eliminar($id)) {
                $this->enviarJson(['exito' => true, 'mensaje' => 'Producto eliminado correctamente']);
            } else {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Error al eliminar el producto. Verifique que no tenga dependencias.']);
            }
        } catch (Exception $e) {
            error_log('Error en producto_eliminar: ' . $e->getMessage());
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error interno: ' . $e->getMessage()]);
        }
    }
    
    // ========== GESTIÓN DE CATEGORÍAS ==========
    
    public function categorias() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $categoriaModelo = $this->cargarModelo('Categoria');
        $categorias = $categoriaModelo->obtenerConContadorProductos();
        
        $datos = [
            'titulo' => 'Gestión de Categorías - ' . NOMBRE_SITIO,
            'categorias' => $categorias
        ];
        
        $this->cargarVista('admin/categorias/lista', $datos);
    }
    
    /**
     * Editar categoría
     */
    public function categoriaEditar($categoriaId = null) {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if (!$categoriaId) {
            $_SESSION['error'] = 'ID de categoría no especificado';
            $this->redirigir('admin/categorias');
            return;
        }
        
        $categoriaModelo = $this->cargarModelo('Categoria');
        $categoria = $categoriaModelo->obtenerPorId($categoriaId);
        
        if (!$categoria) {
            $_SESSION['error'] = 'Categoría no encontrada';
            $this->redirigir('admin/categorias');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'imagen' => trim($_POST['imagen'] ?? '')
            ];
            
            if ($categoriaModelo->actualizar($categoriaId, $datos)) {
                $_SESSION['mensaje'] = 'Categoría actualizada correctamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'Error al actualizar la categoría';
                $_SESSION['tipo_mensaje'] = 'error';
            }
            
            $this->redirigir('admin/categorias');
            return;
        }
        
        $datos = [
            'titulo' => 'Editar Categoría - ' . NOMBRE_SITIO,
            'categoria' => $categoria
        ];
        
        $this->cargarVista('admin/categorias/editar', $datos);
    }
    
    /**
     * Crear nueva categoría
     */
    public function categoria_crear() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion']),
                'imagen' => trim($_POST['imagen'] ?? '')
            ];
            
            // Validaciones básicas
            if (empty($datos['nombre'])) {
                $_SESSION['mensaje'] = 'El nombre de la categoría es obligatorio';
                $_SESSION['tipo_mensaje'] = 'error';
            } else {
                $categoriaModelo = $this->cargarModelo('Categoria');
                
                if ($categoriaModelo->crear($datos)) {
                    $_SESSION['mensaje'] = 'Categoría creada correctamente';
                    $_SESSION['tipo_mensaje'] = 'success';
                    $this->redirigir('admin/categorias');
                    return;
                } else {
                    $_SESSION['mensaje'] = 'Error al crear la categoría';
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            }
        }
        
        $datos = [
            'titulo' => 'Nueva Categoría - ' . NOMBRE_SITIO
        ];
        
        $this->cargarVista('admin/categorias/crear', $datos);
    }
    
    /**
     * Eliminar categoría
     */
    public function categoriaEliminar() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoriaId = $_POST['categoria_id'] ?? null;
            $confirmarEliminacion = $_POST['confirmar_eliminacion'] ?? false;
            
            if ($categoriaId) {
                $categoriaModelo = $this->cargarModelo('Categoria');
                $productoModelo = $this->cargarModelo('Producto');
                
                // Obtener información de la categoría
                $categoria = $categoriaModelo->obtenerPorId($categoriaId);
                
                // Verificar si la categoría tiene productos
                if ($categoriaModelo->tieneProductos($categoriaId)) {
                    // Contar productos asociados
                    $db = BaseDatos::obtenerInstancia();
                    $pdo = $db->obtenerConexion();
                    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM productos WHERE categoria_id = ?");
                    $stmt->execute([$categoriaId]);
                    $totalProductos = $stmt->fetch()['total'];
                    
                    if (!$confirmarEliminacion) {
                        // Mostrar advertencia
                        $_SESSION['mensaje'] = "⚠️ ADVERTENCIA: Esta categoría tiene $totalProductos productos asociados. Al eliminar la categoría, TODOS estos productos también serán eliminados permanentemente. ¿Está seguro?";
                        $_SESSION['tipo_mensaje'] = 'warning';
                        $_SESSION['categoria_advertencia'] = [
                            'id' => $categoriaId,
                            'nombre' => $categoria['nombre'],
                            'total_productos' => $totalProductos
                        ];
                    } else {
                        // Eliminar productos primero, luego categoría
                        $pdo->prepare("DELETE FROM productos WHERE categoria_id = ?")->execute([$categoriaId]);
                        
                        if ($categoriaModelo->eliminar($categoriaId)) {
                            $_SESSION['mensaje'] = "Categoría y $totalProductos productos eliminados correctamente";
                            $_SESSION['tipo_mensaje'] = 'success';
                        } else {
                            $_SESSION['mensaje'] = 'Error al eliminar la categoría';
                            $_SESSION['tipo_mensaje'] = 'error';
                        }
                    }
                } else {
                    // No tiene productos, eliminar directamente
                    if ($categoriaModelo->eliminar($categoriaId)) {
                        $_SESSION['mensaje'] = 'Categoría eliminada correctamente';
                        $_SESSION['tipo_mensaje'] = 'success';
                    } else {
                        $_SESSION['mensaje'] = 'Error al eliminar la categoría';
                        $_SESSION['tipo_mensaje'] = 'error';
                    }
                }
            }
        }
        
        $this->redirigir('admin/categorias');
    }
    
    // ========== GESTIÓN DE PEDIDOS ==========
    
    public function pedidos() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $pedidoModelo = $this->cargarModelo('Pedido');
        
        // Filtros
        $filtros = [
            'estado' => $_GET['estado'] ?? '',
            'buscar' => $_GET['buscar'] ?? '',
            'pagina' => (int)($_GET['pagina'] ?? 1)
        ];
        
        // Obtener pedidos
        $pedidos = $pedidoModelo->obtenerTodos($filtros);
        
        $datos = [
            'titulo' => 'Gestión de Pedidos - ' . NOMBRE_SITIO,
            'pedidos' => $pedidos,
            'filtros' => $filtros
        ];
        
        $this->cargarVista('admin/pedidos', $datos);
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
        
        // Si no hay datos reales, generar datos de ejemplo para las gráficas
        if (empty($ventasPorMes) || array_sum($ventasPorMes) == 0) {
            $ventasPorMes = $this->generarDatosEjemploVentas();
        }
        
        // Si no hay estadísticas de estados, generar datos de ejemplo
        if (empty($estadisticas['estados_pedidos']) || array_sum($estadisticas['estados_pedidos']) == 0) {
            $estadisticas['estados_pedidos'] = [
                'completados' => rand(5, 15),
                'pendientes' => rand(2, 8),
                'cancelados' => rand(1, 3)
            ];
        }
        
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
    
    /**
     * Genera datos de ejemplo para las gráficas cuando no hay datos reales
     */
    private function generarDatosEjemploVentas() {
        $ventasEjemplo = [];
        for ($i = 0; $i < 12; $i++) {
            // Generar ventas más altas en meses recientes
            $factor = $i >= 6 ? rand(800000, 1200000) : rand(200000, 600000);
            $ventasEjemplo[] = $factor;
        }
        return $ventasEjemplo;
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
     * Crear nuevo usuario
     */
    public function crearUsuario() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        try {
            // Leer datos JSON del body
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Error al decodificar los datos JSON']);
                return;
            }
            
            // Validar campos requeridos
            $camposRequeridos = ['nombre', 'apellido', 'email', 'password', 'rol', 'estado'];
            foreach ($camposRequeridos as $campo) {
                if (empty($data[$campo])) {
                    $this->enviarJson(['exito' => false, 'mensaje' => "El campo {$campo} es requerido"]);
                    return;
                }
            }
            
            // Validar email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Email inválido']);
                return;
            }
            
            // Validar longitud de contraseña
            if (strlen($data['password']) < 6) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'La contraseña debe tener al menos 6 caracteres']);
                return;
            }
            
            // Validar rol
            $rolesValidos = [ROL_CLIENTE, ROL_EMPLEADO, ROL_ADMINISTRADOR];
            if (!in_array($data['rol'], $rolesValidos)) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Rol inválido']);
                return;
            }
            
            // Validar estado
            $estadosValidos = ['activo', 'inactivo'];
            if (!in_array($data['estado'], $estadosValidos)) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Estado inválido']);
                return;
            }
            
            $usuarioModelo = $this->cargarModelo('Usuario');
            
            // Verificar si el email ya existe
            if ($usuarioModelo->emailExiste($data['email'])) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'El email ya está registrado']);
                return;
            }
            
            // Preparar datos del usuario
            $datosUsuario = [
                'nombre' => $this->limpiarDatos($data['nombre']),
                'apellido' => $this->limpiarDatos($data['apellido']),
                'email' => $this->limpiarDatos($data['email']),
                'telefono' => $this->limpiarDatos($data['telefono'] ?? ''),
                'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
                'rol' => $data['rol'],
                'estado' => $data['estado']
            ];
            
            // Crear usuario
            $usuarioId = $usuarioModelo->crear($datosUsuario);
            
            if ($usuarioId) {
                $this->enviarJson(['exito' => true, 'mensaje' => 'Usuario creado exitosamente', 'usuario_id' => $usuarioId]);
            } else {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Error al crear el usuario']);
            }
        } catch (Exception $e) {
            error_log('Error en crearUsuario: ' . $e->getMessage());
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error interno: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Alias para crear-usuario (con guiones)
     */
    public function crear_usuario() {
        $this->crearUsuario();
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
        
        try {
            // Leer datos JSON del body
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Error al decodificar los datos JSON']);
                return;
            }
            
            $usuarioId = (int)($data['usuario_id'] ?? $_POST['usuario_id'] ?? 0);
            $nuevaPassword = $data['nueva_password'] ?? $_POST['nueva_password'] ?? '';
            $confirmarPassword = $data['confirmar_password'] ?? $_POST['confirmar_password'] ?? '';
            
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
        } catch (Exception $e) {
            error_log('Error en cambiarPassword: ' . $e->getMessage());
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error interno: ' . $e->getMessage()]);
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
        
        try {
            // Leer datos JSON del body
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Error al decodificar los datos JSON']);
                return;
            }
            
            $usuarioId = (int)($data['usuario_id'] ?? $_POST['usuario_id'] ?? 0);
            $nuevoEstado = $data['estado'] ?? $_POST['estado'] ?? '';
            
            // Validar datos
            if ($usuarioId <= 0) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'ID de usuario inválido']);
                return;
            }
            
            if ($usuarioId === (int)$_SESSION['usuario_id']) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'No puedes cambiar tu propio estado']);
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
        } catch (Exception $e) {
            error_log('Error en cambiarEstado: ' . $e->getMessage());
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error interno: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Eliminar usuario completamente
     */
    public function eliminarUsuario() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        try {
            // Leer datos JSON del body
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Error al decodificar los datos JSON']);
                return;
            }
            
            $usuarioId = (int)($data['usuario_id'] ?? $_POST['usuario_id'] ?? 0);
            
            // Validar datos
            if ($usuarioId <= 0) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'ID de usuario inválido']);
                return;
            }
            
            // No permitir eliminar el propio usuario
            if ($usuarioId === (int)$_SESSION['usuario_id']) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'No puedes eliminar tu propia cuenta']);
                return;
            }
            
            // Eliminar usuario
            $usuarioModelo = $this->cargarModelo('Usuario');
            
            if ($usuarioModelo->eliminar($usuarioId)) {
                $this->enviarJson(['exito' => true, 'mensaje' => 'Usuario eliminado exitosamente']);
            } else {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Error al eliminar el usuario']);
            }
        } catch (Exception $e) {
            error_log('Error en eliminarUsuario: ' . $e->getMessage());
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error interno: ' . $e->getMessage()]);
        }
    }
    
    
    /**
     * Vista de actualización de stock
     */
    public function actualizarStock() {
        $this->verificarRol([ROL_ADMINISTRADOR, ROL_EMPLEADO]);
        
        $productoModelo = $this->cargarModelo('Producto');
        $tallaModelo = $this->cargarModelo('Talla');
        
        // Obtener productos agrupados por nombre
        $productosAgrupados = $productoModelo->obtenerProductosAgrupados();
        
        $datos = [
            'titulo' => 'Actualizar Stock - ' . NOMBRE_SITIO,
            'productos' => $productosAgrupados,
            'tallas' => $tallaModelo->obtenerTodos()
        ];
        
        $this->cargarVista('admin/stock/actualizar', $datos);
    }
    
    /**
     * Alias para actualizar-stock (con guiones)
     */
    public function actualizar_stock() {
        $this->actualizarStock();
    }
    
    /**
     * Procesar actualización de stock
     */
    public function procesarActualizacionStock() {
        $this->verificarRol([ROL_ADMINISTRADOR, ROL_EMPLEADO]);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $productoId = (int)($_POST['producto_id'] ?? 0);
        $cantidad = (int)($_POST['cantidad'] ?? 0);
        $tipo = $_POST['tipo'] ?? 'entrada'; // entrada o salida
        $motivo = $this->limpiarDatos($_POST['motivo'] ?? '');
        
        if ($productoId <= 0 || $cantidad <= 0) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Datos inválidos']);
            return;
        }
        
        $productoModelo = $this->cargarModelo('Producto');
        $producto = $productoModelo->obtenerPorId($productoId);
        
        if (!$producto) {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Producto no encontrado']);
            return;
        }
        
        // Calcular cantidad a agregar/quitar
        $cantidadActual = $producto['stock'];
        $cantidadMovimiento = $tipo === 'entrada' ? $cantidad : -$cantidad;
        $nuevaCantidad = $cantidadActual + $cantidadMovimiento;
        
        // Actualizar stock (el método ya registra en historial)
        if ($productoModelo->actualizarStock($productoId, $cantidadMovimiento, $motivo, $_SESSION['usuario_id'] ?? null)) {
            
            $this->enviarJson([
                'exito' => true, 
                'mensaje' => 'Stock actualizado correctamente',
                'stock_anterior' => $cantidadActual,
                'stock_nuevo' => $nuevaCantidad
            ]);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Error al actualizar el stock']);
        }
    }
    
    /**
     * Obtener variantes de un producto (AJAX)
     */
    public function obtenerVariantesProducto() {
        $this->verificarRol([ROL_ADMINISTRADOR, ROL_EMPLEADO]);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Método no permitido'], 405);
            return;
        }
        
        $productoModelo = $this->cargarModelo('Producto');
        
        // Verificar si se pasa nombre o producto_id
        if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
            // Buscar por nombre
            $nombre = trim($_GET['nombre']);
            $variantes = $productoModelo->obtenerVariantesPorNombre($nombre);
            
            if (empty($variantes)) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'No se encontraron variantes para el producto: ' . $nombre]);
                return;
            }
        } elseif (isset($_GET['producto_id']) && is_numeric($_GET['producto_id'])) {
            // Buscar por ID (método original)
            $productoId = (int)$_GET['producto_id'];
            $producto = $productoModelo->obtenerPorId($productoId);
            
            if (!$producto) {
                $this->enviarJson(['exito' => false, 'mensaje' => 'Producto no encontrado']);
                return;
            }
            
            $variantes = $productoModelo->obtenerVariantesPorNombre($producto['nombre']);
        } else {
            $this->enviarJson(['exito' => false, 'mensaje' => 'Parámetro inválido. Se requiere "nombre" o "producto_id"']);
            return;
        }
        
        $this->enviarJson(['exito' => true, 'variantes' => $variantes]);
    }
    
    /**
     * Alias para obtener-variantes-producto (con guiones)
     */
    public function obtener_variantes_producto() {
        $this->obtenerVariantesProducto();
    }
    
    /**
     * Alias para procesar-actualizacion-stock (con guiones)
     */
    public function procesar_actualizacion_stock() {
        $this->procesarActualizacionStock();
    }
    
    /**
     * Historial de movimientos de stock
     */
    public function historialStock() {
        $this->verificarRol([ROL_ADMINISTRADOR, ROL_EMPLEADO]);
        
        $productoModelo = $this->cargarModelo('Producto');
        
        // Obtener filtros de la URL
        $filtros = [
            'tipo' => $_GET['tipo'] ?? '',
            'fecha_desde' => $_GET['fecha_desde'] ?? '',
            'fecha_hasta' => $_GET['fecha_hasta'] ?? '',
            'buscar' => $_GET['buscar'] ?? ''
        ];
        
        // Obtener historial de movimientos con filtros
        $historial = $this->obtenerHistorialStock($filtros);
        
        $datos = [
            'titulo' => 'Historial de Stock - ' . NOMBRE_SITIO,
            'historial' => $historial,
            'filtros' => $filtros
        ];
        
        $this->cargarVista('admin/stock/historial', $datos);
    }
    
    /**
     * Alias para historial-stock (con guiones)
     */
    public function historial_stock() {
        $this->historialStock();
    }
    
    /**
     * Registrar movimiento de stock
     */
    private function registrarMovimientoStock($productoId, $tipo, $cantidad, $motivo, $stockAnterior, $stockNuevo) {
        // Por ahora solo log, después se puede implementar una tabla de historial
        $log = [
            'fecha' => date('Y-m-d H:i:s'),
            'producto_id' => $productoId,
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'motivo' => $motivo,
            'stock_anterior' => $stockAnterior,
            'stock_nuevo' => $stockNuevo,
            'usuario_id' => $_SESSION['usuario_id']
        ];
        
        error_log("Movimiento de stock: " . json_encode($log));
    }
    
    /**
     * Obtener historial de stock
     */
    private function obtenerHistorialStock($filtros = []) {
        $historialModelo = $this->cargarModelo('HistorialStock');
        return $historialModelo->obtenerHistorial(100, $filtros);
    }
    
    /**
     * Mostrar mensajes de sesión
     */
    public function mostrarMensajes() {
        // Mostrar mensaje de éxito
        if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= Vista::escapar($_SESSION['exito']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['exito']); ?>
        <?php endif; ?>
        
        <?php // Mostrar mensaje de error
        if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?= Vista::escapar($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php // Mostrar mensaje genérico con tipo
        if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                <?= Vista::escapar($_SESSION['mensaje']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
        <?php endif;
    }
    
    /**
     * Vista completa del producto para administrador
     */
    public function productoVista($id) {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $productoModelo = $this->cargarModelo('Producto');
        $producto = $productoModelo->obtenerConVariantes($id);
        
        if (!$producto) {
            $this->redirigir('admin/productos');
            return;
        }
        
        // Obtener productos relacionados de la misma categoría
        $productosRelacionados = $productoModelo->obtenerPorCategoria($producto['categoria_id'], 4);
        
        $datos = [
            'titulo' => 'Vista Completa - ' . $producto['nombre'] . ' - ' . NOMBRE_SITIO,
            'producto' => $producto,
            'productos_relacionados' => $productosRelacionados
        ];
        
        $this->cargarVista('admin/productos/vista', $datos);
    }
    
    /**
     * Alias para producto-vista (con guiones)
     */
    public function producto_vista() {
        $this->productoVista(func_get_arg(0));
    }
    
    /**
     * Alias para producto-eliminar (con guiones)
     */
    public function producto_eliminar_alias() {
        $this->producto_eliminar(func_get_arg(0));
    }
    
    /**
     * Agregar nueva variante (talla) a un producto existente
     */
    public function producto_agregar_variante($productoId) {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        $productoModelo = $this->cargarModelo('Producto');
        $producto = $productoModelo->obtenerPorId($productoId);
        
        if (!$producto) {
            $this->redirigir('admin/productos');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => $producto['nombre'], // Mismo nombre que el producto original
                'descripcion' => $producto['descripcion'],
                'precio' => (float)($_POST['precio'] ?? $producto['precio']),
                'precio_oferta' => !empty($_POST['precio_oferta']) ? (float)$_POST['precio_oferta'] : null,
                'categoria_id' => $producto['categoria_id'],
                'marca_id' => $producto['marca_id'],
                'talla_id' => (int)($_POST['talla_id'] ?? 0),
                'color_id' => !empty($_POST['color_id']) ? (int)$_POST['color_id'] : null,
                'genero_id' => $producto['genero_id'],
                'stock' => (int)($_POST['stock'] ?? 0),
                'stock_minimo' => (int)($_POST['stock_minimo'] ?? $producto['stock_minimo']),
                'codigo_sku' => $this->limpiarDatos($_POST['codigo_sku'] ?? ''),
                'estado' => 'activo',
                'destacado' => 0,
                'imagen_principal' => $producto['imagen_principal'] // Misma imagen
            ];
            
            if ($productoModelo->crear($datos)) {
                $_SESSION['exito'] = 'Nueva variante agregada correctamente';
                $this->redirigir('admin/producto-vista/' . $productoId);
            } else {
                $_SESSION['error'] = 'Error al agregar la nueva variante';
            }
        }
        
        // Cargar datos para los dropdowns
        $categoriaModelo = $this->cargarModelo('Categoria');
        $marcaModelo = $this->cargarModelo('Marca');
        $tallaModelo = $this->cargarModelo('Talla');
        $colorModelo = $this->cargarModelo('Color');
        $generoModelo = $this->cargarModelo('Genero');
        
        $datos = [
            'titulo' => 'Agregar Nueva Variante - ' . NOMBRE_SITIO,
            'producto' => $producto,
            'categorias' => $categoriaModelo->obtenerActivas(),
            'marcas' => $marcaModelo->obtenerTodos(),
            'tallas' => $tallaModelo->obtenerTodos(),
            'colores' => $colorModelo->obtenerTodos(),
            'generos' => $generoModelo->obtenerTodos()
        ];
        
        $this->cargarVista('admin/productos/agregar-variante', $datos);
    }
    
    /**
     * Alias para producto-agregar-variante (con guiones)
     */
    public function producto_agregar_variante_alias($productoId) {
        $this->producto_agregar_variante($productoId);
    }
    
    /**
     * Crear nueva variante desde la página de stock
     */
    public function crear_variante_stock() {
        $this->verificarRol(ROL_ADMINISTRADOR);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Obtener datos del JSON
                $input = json_decode(file_get_contents('php://input'), true);
                
                if (!$input) {
                    echo json_encode(['exito' => false, 'mensaje' => 'Error al procesar los datos JSON']);
                    return;
                }
                
                $productoBaseId = $input['producto_base_id'] ?? null;
                $tallaId = $input['talla_id'] ?? null;
                
                if (!$productoBaseId || !$tallaId) {
                    echo json_encode(['exito' => false, 'mensaje' => 'Datos incompletos: producto_id=' . $productoBaseId . ', talla_id=' . $tallaId]);
                    return;
                }
                
                $productoModelo = $this->cargarModelo('Producto');
                
                // Obtener datos del producto base
                $productoBase = $productoModelo->obtenerPorId($productoBaseId);
                if (!$productoBase) {
                    echo json_encode(['exito' => false, 'mensaje' => 'Producto no encontrado con ID: ' . $productoBaseId]);
                    return;
                }
                
                // Verificar si ya existe una variante con esta talla
                $varianteExistente = $productoModelo->obtenerVariantePorTalla($productoBaseId, $tallaId);
                if ($varianteExistente) {
                    echo json_encode(['exito' => false, 'mensaje' => 'Ya existe una variante con esta talla']);
                    return;
                }
                
                // Crear nueva variante
                $datosVariante = [
                    'nombre' => $productoBase['nombre'],
                    'descripcion' => $productoBase['descripcion'],
                    'precio' => $productoBase['precio'],
                    'precio_oferta' => $productoBase['precio_oferta'],
                    'categoria_id' => $productoBase['categoria_id'],
                    'marca_id' => $productoBase['marca_id'],
                    'talla_id' => (int)$tallaId,
                    'color_id' => $productoBase['color_id'],
                    'genero_id' => $productoBase['genero_id'],
                    'stock' => 0,
                    'stock_minimo' => $productoBase['stock_minimo'],
                    'codigo_sku' => $productoModelo->generarCodigoSKU($productoBase['categoria_id'], $tallaId),
                    'estado' => 'activo',
                    'destacado' => 0,
                    'imagen_principal' => $productoBase['imagen_principal']
                ];
                
                if ($productoModelo->crear($datosVariante)) {
                    echo json_encode(['exito' => true, 'mensaje' => 'Nueva variante creada exitosamente']);
                } else {
                    echo json_encode(['exito' => false, 'mensaje' => 'Error al crear la variante en la base de datos']);
                }
            } catch (Exception $e) {
                echo json_encode(['exito' => false, 'mensaje' => 'Error interno: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Método no permitido']);
        }
    }
}
