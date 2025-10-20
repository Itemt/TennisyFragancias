<?php
// Script para limpiar datos existentes
require_once 'app/config/base_datos.php';

try {
    $bd = BaseDatos::obtenerInstancia();
    
    echo "<h2>🧹 Limpiando datos existentes...</h2>";
    
    // Limpiar datos
    $resultado = $bd->limpiarDatosExistentes();
    
    if ($resultado) {
        echo "<p style='color: green;'>✅ Limpieza completada exitosamente!</p>";
        
        // Verificar estado actual
        $conexion = $bd->obtenerConexion();
        
        $stmt = $conexion->query("SELECT COUNT(*) as total FROM pedidos");
        $pedidos = $stmt->fetch()['total'];
        echo "<p>📊 Pedidos: $pedidos</p>";
        
        $stmt = $conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'");
        $clientes = $stmt->fetch()['total'];
        echo "<p>👥 Clientes: $clientes</p>";
        
        $stmt = $conexion->query("SELECT COUNT(*) as total FROM facturas");
        $facturas = $stmt->fetch()['total'];
        echo "<p>📄 Facturas: $facturas</p>";
        
        $stmt = $conexion->query("SELECT COUNT(*) as total FROM carrito");
        $carrito = $stmt->fetch()['total'];
        echo "<p>🛒 Carrito: $carrito</p>";
        
        $stmt = $conexion->query("SELECT COUNT(*) as total FROM historial_stock");
        $historial = $stmt->fetch()['total'];
        echo "<p>📈 Historial Stock: $historial</p>";
        
        echo "<p style='color: blue; margin-top: 20px;'>✨ Ahora puedes ir al <a href='/admin/dashboard'>Dashboard</a> para generar solo 25 pedidos nuevos.</p>";
        
    } else {
        echo "<p style='color: red;'>❌ Error en la limpieza</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
