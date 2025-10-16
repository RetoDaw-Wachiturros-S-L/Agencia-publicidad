<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }

    $isLoggedIn = !empty($_SESSION['usuario']);
    $currentUser = $_SESSION['usuario'] ?? null;

    $isAdmin = false;

    if ($isLoggedIn) {
        $currentUser = [
            'email' => $usuarioData['email'] ?? null,
            'nombre' => $usuarioData['nombre'] ?? null,
            'apellido' => $usuarioData['apellido'] ?? null,
            'tipo' => $usuarioData['tipo_usuario'] ?? null,
            'login_time' => time()
        ];

        $isAdmin = ($currentUser['tipo'] === 'ADMINISTRADOR');
    }

?>