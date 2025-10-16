<?php
    //Comprobar session
    require_once __DIR__ . '/../utils/sesion.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <h1>🎨 Bienvenido a Nuestra Agencia de Publicidad</h1>
        <p>Esta es la página principal de la agencia.</p>
        <nav>
        <a href='index.php?controller=OutController&accion=store'>📝 Registro de Usuario</a><br>
        <a href='index.php?controller=MainController&accion=about'>ℹ️ Sobre Nosotros</a><br>
        <a href='index.php?controller=OutController&accion=iniciarSesion'>Login de Usuario</a><br>
        <a href='index.php?controller=OutController&accion=logout'>Logout</a><br>
        <?php if (isset($logged) && $logged == true): ?>
            <h2>Sesión iniciada</h2>
        <?php endif; ?>
        </nav>
</body>
</html>