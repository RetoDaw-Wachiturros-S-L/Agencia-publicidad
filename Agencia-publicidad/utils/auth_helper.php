<?php

use AgenciaPublicidad\Models\TipoPersonaEnum;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLoggedIn = !empty($_SESSION['usuario']);
    $currentUser = $_SESSION['usuario'] ?? null;

    $isAdmin = false;

    if ($isLoggedIn) {
        $currentUser = [
            'email' => $_SESSION['usuario']['email'] ?? null,
            'nombre' => $_SESSION['usuario']['nombre'] ?? null,
            'apellido' => $_SESSION['usuario']['apellido'] ?? null,
            'tipo' => $_SESSION['usuario']['tipo'] ?? null,
            'login_time' => time()
        ];

        $isAdmin = $currentUser['tipo'] == TipoPersonaEnum::ADMINISTRADOR;
    }

?>