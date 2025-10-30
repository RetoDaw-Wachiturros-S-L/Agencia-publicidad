<?php 
// Configuración de conexión a la base de datos

if (file_exists(__DIR__ . '/../../.env')) {
    $lines = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            putenv($line);
        }
    }
}

define('HOST', getenv('DB_HOST'));
define('PORT', getenv('DB_PORT') ?: '3306'); // Puerto por defecto 3306
define('DB_NAME', getenv('DB_NAME'));
define('USER', getenv('DB_USER'));
define('PASS', getenv('DB_PASS'));

// Obtener la carpeta del proyecto relativo a DocumentRoot
$scriptName = $_SERVER['SCRIPT_NAME']; // /Agencia-publicidad/index.php
$docRoot = $_SERVER['DOCUMENT_ROOT'];   // /var/www/html
$basePath = str_replace('/index.php', '', $scriptName);

define('BASE_URL', $basePath);

// Opciones de PDO por defecto
if (!defined('DB_OPTIONS')) {
	define('DB_OPTIONS', [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]);
}

?>