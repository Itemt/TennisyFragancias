<?php
/**
 * Script de Respaldo de Base de Datos - Tennis y Fragancias
 * 
 * Este script permite crear respaldos automáticos de la base de datos
 * y restaurarlos fácilmente.
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar configuración
//prueba
require_once __DIR__ . '/../app/config/ConfiguracionPortable.php';
ConfiguracionPortable::cargar();

class BackupDatabase {
    private $pdo;
    private $dbName;
    
    public function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PUERTO . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
            $this->pdo = new PDO($dsn, DB_USUARIO, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbName = DB_NOMBRE;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    /**
     * Crear respaldo de la base de datos
     */
    public function crearRespaldo($nombreArchivo = null) {
        if (!$nombreArchivo) {
            $nombreArchivo = 'backup_' . $this->dbName . '_' . date('Y-m-d_H-i-s') . '.sql';
        }
        
        $rutaCompleta = __DIR__ . '/backups/' . $nombreArchivo;
        
        // Crear directorio si no existe
        if (!is_dir(__DIR__ . '/backups/')) {
            mkdir(__DIR__ . '/backups/', 0755, true);
        }
        
        // Obtener estructura de tablas
        $tablas = $this->obtenerTablas();
        
        $sql = "-- =============================================\n";
        $sql .= "-- Respaldo de Base de Datos: {$this->dbName}\n";
        $sql .= "-- Fecha: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Generado por: Tennis y Zapatos Backup System\n";
        $sql .= "-- =============================================\n\n";
        
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
        
        // Crear base de datos
        $sql .= "CREATE DATABASE IF NOT EXISTS `{$this->dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $sql .= "USE `{$this->dbName}`;\n\n";
        
        // Exportar cada tabla
        foreach ($tablas as $tabla) {
            $sql .= $this->exportarTabla($tabla);
        }
        
        $sql .= "\nSET FOREIGN_KEY_CHECKS=1;\n";
        
        // Guardar archivo
        if (file_put_contents($rutaCompleta, $sql)) {
            return [
                'exito' => true,
                'archivo' => $nombreArchivo,
                'ruta' => $rutaCompleta,
                'tamaño' => filesize($rutaCompleta)
            ];
        } else {
            return [
                'exito' => false,
                'error' => 'No se pudo crear el archivo de respaldo'
            ];
        }
    }
    
    /**
     * Restaurar base de datos desde respaldo
     */
    public function restaurarRespaldo($archivo) {
        $rutaArchivo = __DIR__ . '/backups/' . $archivo;
        
        if (!file_exists($rutaArchivo)) {
            return [
                'exito' => false,
                'error' => 'Archivo de respaldo no encontrado'
            ];
        }
        
        try {
            // Preparar base: deshabilitar FK y limpiar tablas actuales para evitar duplicados de PK
            $this->pdo->exec('SET FOREIGN_KEY_CHECKS=0');
            $tablasActuales = $this->obtenerTablas();
            foreach ($tablasActuales as $tabla) {
                try {
                    $this->pdo->exec("TRUNCATE TABLE `{$tabla}`");
                } catch (PDOException $e) {
                    // Si la tabla no se puede truncar (vistas u otros objetos), continuar
                }
            }
            $this->pdo->exec('SET FOREIGN_KEY_CHECKS=1');
            
            $sql = file_get_contents($rutaArchivo);
            
            // Dividir en comandos
            $comandos = explode(';', $sql);
            
            $ejecutados = 0;
            foreach ($comandos as $comando) {
                $comando = trim($comando);
                if (!empty($comando) && !preg_match('/^--/', $comando)) {
                    $this->pdo->exec($comando);
                    $ejecutados++;
                }
            }
            
            return [
                'exito' => true,
                'comandos_ejecutados' => $ejecutados
            ];
            
        } catch (PDOException $e) {
            return [
                'exito' => false,
                'error' => 'Error al restaurar: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Obtener lista de respaldos disponibles
     */
    public function obtenerRespaldos() {
        $directorio = __DIR__ . '/backups/';
        
        if (!is_dir($directorio)) {
            return [];
        }
        
        $archivos = glob($directorio . '*.sql');
        $respaldos = [];
        
        foreach ($archivos as $archivo) {
            $respaldos[] = [
                'nombre' => basename($archivo),
                'fecha' => date('Y-m-d H:i:s', filemtime($archivo)),
                'tamaño' => filesize($archivo),
                'ruta' => $archivo
            ];
        }
        
        // Ordenar por fecha (más reciente primero)
        usort($respaldos, function($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });
        
        return $respaldos;
    }
    
    /**
     * Obtener lista de tablas
     */
    private function obtenerTablas() {
        $stmt = $this->pdo->query("SHOW TABLES");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Exportar una tabla específica
     */
    private function exportarTabla($tabla) {
        $sql = "-- =============================================\n";
        $sql .= "-- Estructura de tabla: $tabla\n";
        $sql .= "-- =============================================\n";
        
        // Obtener estructura de la tabla
        $stmt = $this->pdo->query("SHOW CREATE TABLE `$tabla`");
        $createTable = $stmt->fetch(PDO::FETCH_ASSOC);
        $sql .= $createTable['Create Table'] . ";\n\n";
        
        // Obtener datos de la tabla
        $stmt = $this->pdo->query("SELECT * FROM `$tabla`");
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($filas)) {
            $sql .= "-- Datos de la tabla: $tabla\n";
            
            foreach ($filas as $fila) {
                $valores = [];
                foreach ($fila as $valor) {
                    if ($valor === null) {
                        $valores[] = 'NULL';
                    } else {
                        $valores[] = "'" . addslashes($valor) . "'";
                    }
                }
                
                $sql .= "INSERT INTO `$tabla` VALUES (" . implode(', ', $valores) . ");\n";
            }
            $sql .= "\n";
        }
        
        return $sql;
    }
}

// Interfaz web para el respaldo
if (isset($_GET['accion'])) {
    $backup = new BackupDatabase();
    
    switch ($_GET['accion']) {
        case 'crear':
            $resultado = $backup->crearRespaldo();
            echo json_encode($resultado);
            break;
            
        case 'restaurar':
            if (isset($_POST['archivo'])) {
                $resultado = $backup->restaurarRespaldo($_POST['archivo']);
                echo json_encode($resultado);
            }
            break;
            
        case 'listar':
            $respaldos = $backup->obtenerRespaldos();
            echo json_encode($respaldos);
            break;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respaldo de Base de Datos - Tennis y Fragancias</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #DC3545;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .btn {
            background: #DC3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #c82333;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
        }
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background: #e0a800;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗄️ Respaldo de Base de Datos</h1>
            <p>Sistema de respaldo y restauración para Tennis y Zapatos</p>
        </div>
        
        <div class="content">
            <div class="alert alert-info">
                <strong>💡 Información:</strong> Este sistema te permite crear respaldos automáticos de tu base de datos y restaurarlos cuando sea necesario. 
                Los respaldos se guardan en la carpeta <code>database/backups/</code>.
            </div>
            
            <h3>📦 Crear Nuevo Respaldo</h3>
            <button class="btn" onclick="crearRespaldo()">Crear Respaldo Ahora</button>
            
            <h3>📋 Respaldos Disponibles</h3>
            <div id="listaRespaldos">
                <p>Cargando respaldos...</p>
            </div>
            
            <h3>🔄 Restaurar Respaldo</h3>
            <div class="alert alert-danger">
                <strong>⚠️ Advertencia:</strong> Restaurar un respaldo reemplazará todos los datos actuales. 
                Asegúrate de crear un respaldo actual antes de restaurar.
            </div>
            
            <div id="formularioRestaurar" style="display: none;">
                <form id="formRestaurar">
                    <select id="archivoRestaurar" name="archivo" required>
                        <option value="">Seleccionar archivo...</option>
                    </select>
                    <button type="submit" class="btn btn-warning">Restaurar Respaldo</button>
                </form>
            </div>
            
            <div id="resultado"></div>
            
            <div style="margin-top: 30px; text-align: center;">
                <a href="../index.php" class="btn btn-success">🏠 Volver al Sistema</a>
            </div>
        </div>
    </div>

    <script>
        // Cargar lista de respaldos al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarRespaldos();
        });
        
        function cargarRespaldos() {
            fetch('?accion=listar')
                .then(response => response.json())
                .then(data => {
                    mostrarRespaldos(data);
                })
                .catch(error => {
                    document.getElementById('listaRespaldos').innerHTML = 
                        '<div class="alert alert-danger">Error al cargar respaldos: ' + error + '</div>';
                });
        }
        
        function mostrarRespaldos(respaldos) {
            if (respaldos.length === 0) {
                document.getElementById('listaRespaldos').innerHTML = 
                    '<div class="alert alert-info">No hay respaldos disponibles.</div>';
                return;
            }
            
            let html = '<table class="table">';
            html += '<thead><tr><th>Archivo</th><th>Fecha</th><th>Tamaño</th><th>Acciones</th></tr></thead>';
            html += '<tbody>';
            
            respaldos.forEach(respaldo => {
                const fecha = new Date(respaldo.fecha).toLocaleString();
                const tamaño = (respaldo.tamaño / 1024).toFixed(2) + ' KB';
                
                html += '<tr>';
                html += '<td>' + respaldo.nombre + '</td>';
                html += '<td>' + fecha + '</td>';
                html += '<td>' + tamaño + '</td>';
                html += '<td>';
                html += '<button class="btn btn-warning" onclick="seleccionarRestaurar(\'' + respaldo.nombre + '\')">Restaurar</button>';
                html += '</td>';
                html += '</tr>';
            });
            
            html += '</tbody></table>';
            document.getElementById('listaRespaldos').innerHTML = html;
            
            // Llenar select de restaurar
            let select = document.getElementById('archivoRestaurar');
            select.innerHTML = '<option value="">Seleccionar archivo...</option>';
            respaldos.forEach(respaldo => {
                const fechaOption = new Date(respaldo.fecha).toLocaleString();
                let option = document.createElement('option');
                option.value = respaldo.nombre;
                option.textContent = respaldo.nombre + ' (' + fechaOption + ')';
                select.appendChild(option);
            });
        }
        
        function crearRespaldo() {
            document.getElementById('resultado').innerHTML = 
                '<div class="alert alert-info">Creando respaldo...</div>';
            
            fetch('?accion=crear')
                .then(response => response.json())
                .then(data => {
                    if (data.exito) {
                        document.getElementById('resultado').innerHTML = 
                            '<div class="alert alert-success">✅ Respaldo creado exitosamente: ' + data.archivo + '</div>';
                        cargarRespaldos(); // Recargar lista
                    } else {
                        document.getElementById('resultado').innerHTML = 
                            '<div class="alert alert-danger">❌ Error: ' + data.error + '</div>';
                    }
                })
                .catch(error => {
                    document.getElementById('resultado').innerHTML = 
                        '<div class="alert alert-danger">❌ Error: ' + error + '</div>';
                });
        }
        
        function seleccionarRestaurar(archivo) {
            document.getElementById('archivoRestaurar').value = archivo;
            document.getElementById('formularioRestaurar').style.display = 'block';
        }
        
        document.getElementById('formRestaurar').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const archivo = document.getElementById('archivoRestaurar').value;
            
            if (!confirm('¿Estás seguro de que quieres restaurar este respaldo? Esto reemplazará todos los datos actuales.')) {
                return;
            }
            
            document.getElementById('resultado').innerHTML = 
                '<div class="alert alert-info">Restaurando respaldo...</div>';
            
            const formData = new FormData();
            formData.append('archivo', archivo);
            
            fetch('?accion=restaurar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.exito) {
                    document.getElementById('resultado').innerHTML = 
                        '<div class="alert alert-success">✅ Respaldo restaurado exitosamente. Comandos ejecutados: ' + data.comandos_ejecutados + '</div>';
                } else {
                    document.getElementById('resultado').innerHTML = 
                        '<div class="alert alert-danger">❌ Error: ' + data.error + '</div>';
                }
            })
            .catch(error => {
                document.getElementById('resultado').innerHTML = 
                    '<div class="alert alert-danger">❌ Error: ' + error + '</div>';
            });
        });
    </script>
</body>
</html>
