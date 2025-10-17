<?php 
// Configuración de conexión a la base de datos
// Ajusta estos valores según tu entorno

define('HOST', 'wachiturros-do-user-18805607-0.m.db.ondigitalocean.com');
define('DB_NAME', 'marketplace');
define('USER', 'doadmin');
define('PASS', 'AVNS_T7F5ypei-vq0X2smLnX');

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