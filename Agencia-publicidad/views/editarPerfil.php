<?php
require_once __DIR__ . '/../utils/auth_helper.php';

// Extraer variables globales al scope local
$currentUser = $GLOBALS['currentUser'] ?? null;
$isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
$isAdmin = $GLOBALS['isAdmin'] ?? false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/editarPerfil.css"/>

</head>
<body>
    <?php include __DIR__ . '/components/header.php'; ?>
    
    <main>
    <img src="" alt="fotoperfil"><h2>Editar usuario</h2>
    <h3>Campos a cambiar</h3>
    <div class="botones">
        <a href="">Nombre</a>
        <a href="">Apellido</a>
        <a href="">Contraseña</a>
        <a href="">Foto de perfil</a>
        <a href="">Nombre de la empresa</a>
        <a href="">Comentario de la empresa</a>
        <a href="">Numero de telefono</a>
        <a href="">Nif de la empresa</a>
    </div>
    </main>
    
    <script src="<?= BASE_URL ?>/js/index.js"></script>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>