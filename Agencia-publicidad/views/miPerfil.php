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
<html lang="en">
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
                    <li><b>Nombre: <?=$perfil["nombre"]?></b></li>
                    <li><b>Apellido: <?=$perfil["apellido"]?></b></li>
                    <li><b>Email: <?=$perfil["email"]?></b></li>
                    <?php if($_SESSION["usuario"]["tipo"]=="COMERCIANTE"):?>
                        <li><b>Nombre empresa: </b> <?=$perfil["nombre_empresa"]?></li>
                        <li><b>Nif empresa: </b><?=$perfil["nif_empresa"]?></li>
                        <li><b>Detalles de la empresa: </b><?=$perfil["comentario_empresa"]?></li>
                        <li><b>Telefonno de la empresa: </b><?=$perfil["num_telefono"]?></li>
                        <li><b>Comerciante desde: </b><?=$perfil["comerciante_desde"]?></li>
                    <?php endif?>
                </ul>
            </aside>
            <div id="perfil">
                <?php if(empty($perfil["foto_perfil"])):?>
                    <h2><img src="<?= BASE_URL ?>/img/fotoperfil.png" alt="foto de perfil">  <?=$perfil["nombre"]?></h2>
                <?php else: ?>
                    <h2><img src="" alt="foto de perfil">  <?=$perfil["nombre"]?></h2>
                <?php endif?> 
            </div>
            <section>
                <a href="<?= BASE_URL ?>/views/editarPerfil.php">Editar perfil</a>
                <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=verAnuncios">Mis anuncios</a>
                <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=logout" class="cerrar">Cerrar sesion</a>
            </section>
        </div>
    </main>
    
    <script src="<?= BASE_URL ?>/js/index.js"></script>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
 
</body>
</html>