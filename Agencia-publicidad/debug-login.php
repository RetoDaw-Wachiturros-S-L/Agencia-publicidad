<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_login.log');

echo "<h1>🔍 Debug de Login</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .section { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    pre { background: #f0f0f0; padding: 10px; border-radius: 4px; overflow-x: auto; max-height: 400px; }
    table { width: 100%; border-collapse: collapse; }
    td, th { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background-color: #4CAF50; color: white; }
    .trace { font-size: 12px; }
</style>";

// ====== 1. INFORMACIÓN DE LA PETICIÓN ======
echo "<div class='section'>";
echo "<h2>1️⃣ Información de la Petición</h2>";
echo "<table>";
echo "<tr><td>Método</td><td>" . ($_SERVER['REQUEST_METHOD'] ?? 'N/A') . "</td></tr>";
echo "<tr><td>Query String</td><td>" . ($_SERVER['QUERY_STRING'] ?? 'N/A') . "</td></tr>";
echo "<tr><td>Request URI</td><td>" . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "</td></tr>";
echo "</table>";
echo "</div>";

// Variable global para la conexión
$conn = null;

// ====== 2. CARGAR DEPENDENCIAS ======
echo "<div class='section'>";
echo "<h2>2️⃣ Cargando Dependencias</h2>";

try {
    echo "<p>📦 Cargando config.php...</p>";
    require_once __DIR__ . '/config/config.php';
    echo "<p class='success'>✅ config.php cargado</p>";
    
    echo "<p>📦 Cargando modelos...</p>";
    require_once __DIR__ . '/models/UsuarioRegistrado.php';
    echo "<p class='success'>✅ UsuarioRegistrado.php</p>";
    
    require_once __DIR__ . '/models/TipoPersonaEnum.php';
    echo "<p class='success'>✅ TipoPersonaEnum.php</p>";
    
    require_once __DIR__ . '/models/dataBase/DBFunctions.php';
    echo "<p class='success'>✅ DBFunctions.php</p>";
    
    require_once __DIR__ . '/models/dataBase/DBUser.php';
    echo "<p class='success'>✅ DBUser.php</p>";
    
    require_once __DIR__ . '/models/Comerciante.php';
    echo "<p class='success'>✅ Comerciante.php</p>";
    
    echo "<p class='success'>✅ Todos los modelos cargados correctamente</p>";
    
} catch (Throwable $e) {
    echo "<p class='error'>❌ Error al cargar dependencias: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . " (línea " . $e->getLine() . ")</p>";
    echo "<pre class='trace'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
echo "</div>";

// ====== 3. VERIFICAR CONEXIÓN A BASE DE DATOS ======
echo "<div class='section'>";
echo "<h2>3️⃣ Verificar Conexión a Base de Datos</h2>";

try {
    require_once __DIR__ . '/models/dataBase/DBCon.php';
    
    // La conexión se hace a través de DBCon::getConnection() (método estático)
    $conn = \AgenciaPublicidad\Models\DataBase\DBCon::getConnection();
    echo "<p class='success'>✅ Conexión a BD establecida con DBCon::getConnection()</p>";
    
    // Probar consulta simple
    $stmt = $conn->query("SELECT VERSION() as version");
    $version = $stmt->fetch();
    echo "<p>🗄️ MySQL Version: <strong>" . htmlspecialchars($version['version']) . "</strong></p>";
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ Error de conexión PDO:</p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p>Código: " . $e->getCode() . "</p>";
    echo "<pre class='trace'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
} catch (Throwable $e) {
    echo "<p class='error'>❌ Error general:</p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . " (línea " . $e->getLine() . ")</p>";
    echo "<pre class='trace'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
echo "</div>";

// ====== 4. SIMULAR LOGIN ======
echo "<div class='section'>";
echo "<h2>4️⃣ Simular Proceso de Login</h2>";

// Formulario de prueba
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ?>
    <form method="POST" action="">
        <table>
            <tr>
                <td><label>Email:</label></td>
                <td><input type="email" name="email" value="test@test.com" required style="padding: 5px; width: 250px;"></td>
            </tr>
            <tr>
                <td><label>Contraseña:</label></td>
                <td><input type="password" name="contrasena" value="123456" required style="padding: 5px; width: 250px;"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px;">
                        🔍 Probar Login
                    </button>
                </td>
            </tr>
        </table>
    </form>
    <?php
} else {
    // Procesar login de prueba
    echo "<h3>📝 Datos recibidos:</h3>";
    echo "<table>";
    echo "<tr><td>Email</td><td>" . htmlspecialchars($_POST['email'] ?? '') . "</td></tr>";
    echo "<tr><td>Contraseña</td><td>***OCULTA*** (longitud: " . strlen($_POST['contrasena'] ?? '') . ")</td></tr>";
    echo "</table>";
    
    try {
        $email = $_POST['email'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';
        
        echo "<h3>🔄 Intentando autenticar...</h3>";
        
        $dbUser = new \AgenciaPublicidad\Models\DBUser();
        echo "<p class='success'>✅ DBUser instanciado</p>";
        
        // Intentar login
        echo "<p>🔍 Llamando a comprobarUsuario()...</p>";
        $usuario = $dbUser->comprobarUsuario($email, $contrasena);
        
        if (!empty($usuario)) {
            echo "<p class='success'>✅ USUARIO ENCONTRADO</p>";
            echo "<table>";
            echo "<tr><td>ID</td><td>" . $usuario->getIdUsuario() . "</td></tr>";
            echo "<tr><td>Nombre</td><td>" . htmlspecialchars($usuario->getNombre()) . "</td></tr>";
            echo "<tr><td>Apellido</td><td>" . htmlspecialchars($usuario->getApellido() ?? 'N/A') . "</td></tr>";
            echo "<tr><td>Email</td><td>" . htmlspecialchars($usuario->getEmail()) . "</td></tr>";
            echo "<tr><td>Tipo</td><td>" . $usuario->getTipo()->value . "</td></tr>";
            echo "</table>";
            
            // Si es comerciante, obtener datos
            if ($usuario->getTipo()->value === 'COMERCIANTE') {
                echo "<h3>🏢 Intentando obtener datos de comerciante...</h3>";
                
                try {
                    $comerciante = $dbUser->usuarioComerciante($usuario);
                    
                    if ($comerciante !== null && $comerciante->getIdComerciante() !== null) {
                        echo "<p class='success'>✅ COMERCIANTE ENCONTRADO</p>";
                        echo "<table>";
                        echo "<tr><td>ID Comerciante</td><td>" . $comerciante->getIdComerciante() . "</td></tr>";
                        echo "<tr><td>Nombre Comercio</td><td>" . htmlspecialchars($comerciante->getNombreComercio() ?? 'N/A') . "</td></tr>";
                        echo "<tr><td>Rubro</td><td>" . htmlspecialchars($comerciante->getRubro() ?? 'N/A') . "</td></tr>";
                        echo "</table>";
                    } else {
                        echo "<p class='warning'>⚠️ Usuario es comerciante pero no se encontraron datos adicionales</p>";
                        echo "<p>Tipo de retorno: " . gettype($comerciante) . "</p>";
                        if ($comerciante !== null) {
                            echo "<p>Clase: " . get_class($comerciante) . "</p>";
                        }
                    }
                } catch (Throwable $e) {
                    echo "<p class='error'>❌ Error al obtener datos de comerciante:</p>";
                    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
                    echo "<p><strong>Archivo:</strong> " . $e->getFile() . " (línea " . $e->getLine() . ")</p>";
                    echo "<pre class='trace'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
                }
            }
            
        } else {
            echo "<p class='warning'>⚠️ Usuario no encontrado o contraseña incorrecta</p>";
            
            // Verificar si el usuario existe en la BD
            if ($conn) {
                echo "<h3>🔍 Verificando si el email existe en la BD:</h3>";
                $stmt = $conn->prepare("SELECT id_usuario, email, tipo FROM usuarios WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user) {
                    echo "<p class='warning'>⚠️ El usuario existe pero la contraseña es incorrecta</p>";
                    echo "<table>";
                    echo "<tr><td>ID</td><td>" . $user['id_usuario'] . "</td></tr>";
                    echo "<tr><td>Email</td><td>" . htmlspecialchars($user['email']) . "</td></tr>";
                    echo "<tr><td>Tipo</td><td>" . htmlspecialchars($user['tipo']) . "</td></tr>";
                    echo "</table>";
                } else {
                    echo "<p class='error'>❌ El email no existe en la base de datos</p>";
                }
            }
        }
        
    } catch (PDOException $e) {
        echo "<p class='error'>❌ Error PDO durante login:</p>";
        echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
        echo "<p><strong>Código:</strong> " . $e->getCode() . "</p>";
        echo "<p><strong>Archivo:</strong> " . $e->getFile() . " (línea " . $e->getLine() . ")</p>";
        echo "<h4>Stack Trace:</h4>";
        echo "<pre class='trace'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } catch (Throwable $e) {
        echo "<p class='error'>❌ Error general durante login:</p>";
        echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
        echo "<p><strong>Tipo:</strong> " . get_class($e) . "</p>";
        echo "<p><strong>Archivo:</strong> " . $e->getFile() . " (línea " . $e->getLine() . ")</p>";
        echo "<h4>Stack Trace:</h4>";
        echo "<pre class='trace'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
}

echo "</div>";

// ====== 5. VERIFICAR ESTRUCTURA DE TABLAS ======
echo "<div class='section'>";
echo "<h2>5️⃣ Estructura de Tablas</h2>";

try {
    if ($conn !== null) {
        // Tabla usuarios
        echo "<h3>Tabla: usuarios</h3>";
        $stmt = $conn->query("DESCRIBE usuarios");
        $columns = $stmt->fetchAll();
        echo "<table>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($col['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Contar usuarios
        $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
        $total = $stmt->fetch();
        echo "<p>Total usuarios: <strong>" . $total['total'] . "</strong></p>";
        
        // Tabla comerciantes
        echo "<h3>Tabla: comerciantes</h3>";
        $stmt = $conn->query("DESCRIBE comerciantes");
        $columns = $stmt->fetchAll();
        echo "<table>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($col['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Contar comerciantes
        $stmt = $conn->query("SELECT COUNT(*) as total FROM comerciantes");
        $total = $stmt->fetch();
        echo "<p>Total comerciantes: <strong>" . $total['total'] . "</strong></p>";
        
    } else {
        echo "<p class='error'>❌ No hay conexión a la base de datos</p>";
    }
} catch (Throwable $e) {
    echo "<p class='error'>❌ Error al verificar estructura: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre class='trace'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo "</div>";

// ====== 6. LOG DE ERRORES ======
echo "<div class='section'>";
echo "<h2>6️⃣ Log de Errores</h2>";

$logFile = __DIR__ . '/error_login.log';
if (file_exists($logFile)) {
    echo "<h3>Contenido del log:</h3>";
    $logContent = file_get_contents($logFile);
    if (!empty($logContent)) {
        echo "<pre>" . htmlspecialchars($logContent) . "</pre>";
    } else {
        echo "<p class='success'>✅ El log está vacío (no hay errores)</p>";
    }
} else {
    echo "<p class='warning'>⚠️ No hay archivo de log todavía</p>";
}

echo "</div>";

echo "<hr>";
echo "<p style='text-align: center; color: red; font-weight: bold;'>⚠️ ELIMINAR ESTE ARCHIVO EN PRODUCCIÓN</p>";
?>