<?php
if (!defined('ACCESSED_VIA_ROUTER')) {
    http_response_code(403);
    require_once __DIR__ . '/../errors/403.php';
    exit;
}

require_once __DIR__ . '/../../utils/auth_helper.php';

// Extraer variables globales al scope local
$currentUser = $GLOBALS['currentUser'] ?? null;
$isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
$isAdmin = $GLOBALS['isAdmin'] ?? false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/auth.css">
</head>
<body>
    
    <main class="auth-main">
        <h1>Iniciar sesión</h1>

        <?php
        // Si hay algún mensaje de error lo mostramos:
        if(isset($mensaje_error)) :?>
            <p class="mensaje-error"><?= $mensaje_error ?></p>
        <?php endif; ?>

        <div id="form-container">
            <form action="index.php?controller=AuthController&accion=iniciarSesion" method="post" id="login">
            <input type="email" id="email" name="email" required placeholder="Email*">
            <span class="error"></span>

            <input type="password" id="contrasena" name="contrasena" required placeholder="Contraseña*">
            <span class="error"></span>

            <input type="submit" value="Enviar" id="btn-login">
            </form>
        </div>

        
        <script src="<?= BASE_URL ?>/js/validaciones.js"></script>
        <script src="<?= BASE_URL ?>/js/login.js"></script>
        <script src="<?= BASE_URL ?>/js/index.js"></script>
        <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>

    </main>
</body>
</html>