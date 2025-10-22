<?php
// Ahora declarar el namespace para las funciones
namespace Agenciapublicidad\Utils;

use AgenciaPublicidad\Models\TipoPersonaEnum;

// Iniciar sesión UNA SOLA VEZ antes de todo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir variables GLOBALES para las vistas (ANTES del namespace)
$GLOBALS['currentUser'] = $_SESSION['usuario'] ?? null;
$GLOBALS['isLoggedIn'] = !empty($_SESSION['usuario']);
$GLOBALS['isAdmin'] = $GLOBALS['isLoggedIn'] && ($_SESSION['usuario']['tipo'] ?? '') === 'ADMINISTRADOR';

require_once __DIR__ . "/../models/TipoPersonaEnum.php";

// Funciones para usar en controladores (con namespace)
function isLoggedIn(): bool {
    return !empty($_SESSION['usuario']);
}

function isAdmin(): bool {
    return isLoggedIn() && ($_SESSION['usuario']['tipo'] ?? '') === 'ADMINISTRADOR';
}

function getCurrentUser(): ?array {
    if (!isLoggedIn()) {
        return null;
    }
    return $_SESSION['usuario'];
}
?>