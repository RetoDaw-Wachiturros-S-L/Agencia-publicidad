<?php
namespace Agenciapublicidad\Utils;

use AgenciaPublicidad\Models\TipoPersonaEnum;

require_once __DIR__ . "/../models/TipoPersonaEnum.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLoggedIn = !empty($_SESSION['usuario']);
    $currentUser = $_SESSION['usuario'] ?? null;

    $isAdmin = false;

    if ($isLoggedIn) {
        $currentUser = [
            'id'=> $_SESSION['usuario']['id'] ?? null,
            'email' => $_SESSION['usuario']['email'] ?? null,
            'nombre' => $_SESSION['usuario']['nombre'] ?? null,
            'apellido' => $_SESSION['usuario']['apellido'] ?? null,
            'tipo' => $_SESSION['usuario']['tipo'] ?? TipoPersonaEnum::COMERCIANTE,
            'login_time' => time(),
            'id_comerciante' => $_SESSION['usuario']['id_comerciante'] ?? null
        ];

        $isAdmin = $currentUser['tipo'] == TipoPersonaEnum::ADMINISTRADOR;
    }

?>