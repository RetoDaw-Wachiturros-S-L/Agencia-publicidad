<?php
    //Comprobar session
    require_once __DIR__ . '/../utils/auth_helper.php';
?>

<!DOCTYPE html>
<html lang="es">
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
        <a href='views/ads/ads.view.php'>Lo de los botones</a><br>
        <a href='views/ads/ads.create.php'>Nuevo Anuncio (Si estás loggeado)</a>
        <a href='index.php?controller=AdsController&accion=showAll'>Mostrar todos</a><br>
        <a href='index.php?controller=OutController&accion=logout'>Logout</a><br>
        <?php
                    echo "<pre>Contenido de \$_SESSION['usuario']:\n";
                    var_dump($_SESSION['usuario']);
                    echo "</pre>";
        ?>
        <?php if (isset($isLoggedIn) && $isLoggedIn == true):?>
            <h2>Sesión iniciada</h2>
                <?php var_dump($currentUser); ?>
            <?php if ($currentUser['tipo'] === 'COMERCIANTE'):?>
                <h2>Es comerciante</h2>
            <?php endif; ?>
        <?php endif; ?>
        </nav>
</body>
</html>