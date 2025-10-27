<?php
if (!defined('ACCESSED_VIA_ROUTER')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesion</title>
    <link rel="stylesheet" href="css/themes.css">
    <link rel="stylesheet" href="css/auth.css">
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

        
        <script src="js/validaciones.js"></script>
        <script src="js/login.js"></script>
        <script src="js/theme-switcher.js" defer></script>

    </main>
</body>
</html>