<?php
// Activar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Debug de Configuración</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .section { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    pre { background: #f0f0f0; padding: 10px; border-radius: 4px; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    td, th { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background-color: #4CAF50; color: white; }
</style>";

// ====== 1. VERIFICAR ARCHIVO .env ======
echo "<div class='section'>";
echo "<h2>1️⃣ Verificación del archivo .env</h2>";

$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo "<p class='success'>✅ Archivo .env encontrado en: " . $envPath . "</p>";
    
    // Mostrar permisos
    $perms = substr(sprintf('%o', fileperms($envPath)), -4);
    echo "<p>📋 Permisos del archivo: " . $perms . "</p>";
    
    // Leer contenido (ocultar contraseñas)
    echo "<h3>Contenido del archivo .env:</h3>";
    echo "<pre>";
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, 'PASS') !== false || strpos($line, 'PASSWORD') !== false) {
            $parts = explode('=', $line, 2);
            echo htmlspecialchars($parts[0]) . "=***OCULTO***\n";
        } else {
            echo htmlspecialchars($line) . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "<p class='error'>❌ Archivo .env NO encontrado en: " . $envPath . "</p>";
    echo "<p>Directorio actual: " . __DIR__ . "</p>";
}
echo "</div>";

// ====== 2. CARGAR VARIABLES DE ENTORNO ======
echo "<div class='section'>";
echo "<h2>2️⃣ Carga de Variables de Entorno</h2>";

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $loadedVars = 0;
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            putenv($line);
            $loadedVars++;
        }
    }
    echo "<p class='success'>✅ Variables cargadas: " . $loadedVars . "</p>";
} else {
    echo "<p class='error'>❌ No se pudo cargar el archivo .env</p>";
}
echo "</div>";

// ====== 3. VERIFICAR CONSTANTES DE CONFIG.PHP ======
echo "<div class='section'>";
echo "<h2>3️⃣ Verificación de config.php</h2>";

require_once __DIR__ . '/config/config.php';

echo "<table>";
echo "<tr><th>Constante</th><th>Valor</th><th>Estado</th></tr>";

$configs = [
    'HOST' => defined('HOST') ? HOST : null,
    'DB_NAME' => defined('DB_NAME') ? DB_NAME : null,
    'USER' => defined('USER') ? USER : null,
    'PASS' => defined('PASS') ? '***OCULTO***' : null,
    'BASE_URL' => defined('BASE_URL') ? BASE_URL : null,
];

foreach ($configs as $name => $value) {
    $status = !empty($value) ? "<span class='success'>✅</span>" : "<span class='error'>❌</span>";
    $displayValue = $value ?? '<span class="error">NO DEFINIDA</span>';
    echo "<tr><td>$name</td><td>$displayValue</td><td>$status</td></tr>";
}

echo "</table>";
echo "</div>";

// ====== 4. VARIABLES DE ENTORNO getenv() ======
echo "<div class='section'>";
echo "<h2>4️⃣ Variables de Entorno (getenv)</h2>";

echo "<table>";
echo "<tr><th>Variable</th><th>Valor</th></tr>";

$envVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
foreach ($envVars as $var) {
    $value = getenv($var);
    if ($var === 'DB_PASS') {
        $displayValue = $value ? '***OCULTO*** (longitud: ' . strlen($value) . ' caracteres)' : '<span class="error">NO DEFINIDA</span>';
    } else {
        $displayValue = $value ?: '<span class="error">NO DEFINIDA</span>';
    }
    echo "<tr><td>$var</td><td>$displayValue</td></tr>";
}

echo "</table>";
echo "</div>";

// ====== 5. PRUEBA DE CONEXIÓN A LA BASE DE DATOS ======
echo "<div class='section'>";
echo "<h2>5️⃣ Prueba de Conexión a la Base de Datos</h2>";

try {
    $dsn = "mysql:host=" . HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    
    echo "<p>📡 DSN: <code>" . htmlspecialchars($dsn) . "</code></p>";
    echo "<p>👤 Usuario: <code>" . htmlspecialchars(USER) . "</code></p>";
    
    $pdo = new PDO($dsn, USER, PASS, DB_OPTIONS);
    
    echo "<p class='success'>✅ CONEXIÓN EXITOSA a la base de datos</p>";
    
    // Información del servidor
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "<p>🗄️ Versión de MySQL: <strong>" . htmlspecialchars($version) . "</strong></p>";
    
    // SSL/TLS Status
    $sslStatus = $pdo->query("SHOW STATUS LIKE 'Ssl_cipher'")->fetch();
    if ($sslStatus && !empty($sslStatus['Value'])) {
        echo "<p class='success'>🔒 SSL/TLS ACTIVO - Cifrado: " . htmlspecialchars($sslStatus['Value']) . "</p>";
    } else {
        echo "<p class='warning'>⚠️ SSL/TLS NO DETECTADO (conexión sin cifrar)</p>";
    }
    
    // Variables SSL
    echo "<h3>Información SSL/TLS:</h3>";
    $sslVars = $pdo->query("SHOW STATUS LIKE 'Ssl%'")->fetchAll();
    echo "<table>";
    echo "<tr><th>Variable</th><th>Valor</th></tr>";
    foreach ($sslVars as $var) {
        echo "<tr><td>" . htmlspecialchars($var['Variable_name']) . "</td><td>" . htmlspecialchars($var['Value']) . "</td></tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ ERROR DE CONEXIÓN:</p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p><strong>Código de error:</strong> " . $e->getCode() . "</p>";
}

echo "</div>";

// ====== 6. INFORMACIÓN DEL SISTEMA ======
echo "<div class='section'>";
echo "<h2>6️⃣ Información del Sistema</h2>";

echo "<table>";
echo "<tr><td>PHP Version</td><td>" . phpversion() . "</td></tr>";
echo "<tr><td>Sistema Operativo</td><td>" . PHP_OS . "</td></tr>";
echo "<tr><td>Document Root</td><td>" . $_SERVER['DOCUMENT_ROOT'] . "</td></tr>";
echo "<tr><td>Script Name</td><td>" . $_SERVER['SCRIPT_NAME'] . "</td></tr>";
echo "<tr><td>Current Directory</td><td>" . __DIR__ . "</td></tr>";
echo "<tr><td>PDO MySQL Driver</td><td>" . (extension_loaded('pdo_mysql') ? '<span class="success">✅ Instalado</span>' : '<span class="error">❌ NO Instalado</span>') . "</td></tr>";
echo "</table>";

echo "</div>";

// ====== 7. RECOMENDACIONES ======
echo "<div class='section'>";
echo "<h2>7️⃣ Recomendaciones de Seguridad</h2>";

echo "<ul>";

// Verificar permisos .env
if (file_exists($envPath)) {
    $perms = substr(sprintf('%o', fileperms($envPath)), -4);
    if ($perms !== '0600') {
        echo "<li class='warning'>⚠️ Cambiar permisos de .env a 0600: <code>chmod 0600 .env</code></li>";
    } else {
        echo "<li class='success'>✅ Permisos de .env correctos (0600)</li>";
    }
}

// Verificar .gitignore
if (file_exists(__DIR__ . '/.gitignore')) {
    $gitignore = file_get_contents(__DIR__ . '/.gitignore');
    if (strpos($gitignore, '.env') === false) {
        echo "<li class='error'>❌ Añadir .env al archivo .gitignore</li>";
    } else {
        echo "<li class='success'>✅ .env está en .gitignore</li>";
    }
} else {
    echo "<li class='warning'>⚠️ Crear archivo .gitignore y añadir .env</li>";
}

// Verificar que debug.php no esté en producción
echo "<li class='error'>❌ <strong>IMPORTANTE:</strong> Eliminar debug.php en producción</li>";

echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p style='text-align: center; color: #666;'>🔒 Recuerda eliminar este archivo después de verificar la configuración</p>";
?>