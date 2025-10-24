<?php 
    use AgenciaPublicidad\Models\TipoPersonaEnum;
    
    require_once __DIR__ . '/../utils/auth_helper.php';
    require_once __DIR__ . '/../models/TipoPersonaEnum.php';
    
    // Extraer variables globales al scope local
    $currentUser = $GLOBALS['currentUser'] ?? null;
    $isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
    $isAdmin = $GLOBALS['isAdmin'] ?? false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/perfil.css"/>
    <title>Comerciantes Vitoria</title>
</head>
<body>
    <?php include __DIR__ . '/components/header.php'; ?>
    
    <main>
        <div class="contenido">
            <aside>
                <ul>
                    <li><b>Nombre: <?=$perfil["u.nombre"]?></b></li>
                    <li><b>Apellido: <?=$perfil["u.apellido"]?></b></li>
                    <li><b>Email: <?=$perfil["u.email"]?></b></li>
                    <?php if($currentUser["tipo"]==TipoPersonaEnum::COMERCIANTE):?>
                        <li><b>Nombre empresa:</b> <?=$perfil["c.nombre_empresa"]?></li>
                        <li><b>Nif empresa:</b><?=$perfil["c.nif_empresa"]?></li>
                        <li><b>Detalles de la empresa:</b><?=$perfil["c.comentario_empresa"]?></li>
                        <li><b>Telefonno de la empresa:</b><?=$perfil["c.num_telefono"]?></li>
                        <li><b>Comerciante desde:</b><?=$perfil["c.comerciante_desde"]?></li>
                    <?php endif?>
                </ul>
            </aside>
            <div id="perfil">
             <h2><img src="" alt="foto de perfil">Pako</h2>
            </div>
            <section>
                <a href="">Editar perfil</a>
                <a href="">Mis anuncios</a>
                <a href="" class="cerrar">Cerrar sesion</a>
            </section>
        </div>
    </main>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>