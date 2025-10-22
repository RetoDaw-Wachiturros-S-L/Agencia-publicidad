<?php
namespace Agenciapublicidad\Utils;

use AgenciaPublicidad\Models\TipoPersonaEnum;

require_once __DIR__ . "/../models/TipoPersonaEnum.php";

    // Iniciar sesión una sola vez
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Función para verificar si el usuario está logueado
    function isLoggedIn(): bool {
        return !empty($_SESSION['usuario']);
    }
    
    // Función para verificar si es admin
    function isAdmin(): bool {
        return isLoggedin() && ($_SESSION['usuario']['tipo'] ?? '') === 'ADMINISTRADOR';
    }
    $currentUser = $_SESSION['usuario'] ?? null;

    // Funcion para obtener usuario actual
    function getCurrentUser(): ?array {
        if (!isLoggedIn()) {
            return null;
        }
        return [
            'id'=> $_SESSION['usuario']['id'] ?? null,
            'email' => $_SESSION['usuario']['email'] ?? null,
            'nombre' => $_SESSION['usuario']['nombre'] ?? null,
            'apellido' => $_SESSION['usuario']['apellido'] ?? null,
            'tipo' => $_SESSION['usuario']['tipo'] ?? 'COMERCIANTE',
            'login_time' => time(),
            'id_comerciante' => $_SESSION['usuario']['id_comerciante'] ?? null
        ];
    }

    // Rellenando las variables
    $isLoggedIn = isLoggedIn();
    $isAdmin = isAdmin();
    $currentUser = getCurrentUser();

?>