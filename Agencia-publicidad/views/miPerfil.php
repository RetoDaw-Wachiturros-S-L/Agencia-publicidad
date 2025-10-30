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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/miPerfil.css"/>
    <title>Mi Perfil - Comerciantes Vitoria</title>
</head>
<body>
    <?php include __DIR__ . '/components/header.php'; ?>
    
    <main>
        <div class="contenido">
            <div id="perfil">
                <?php if(empty($perfil["foto_perfil"])):?>
                    <img src="<?= BASE_URL ?>/img/fotoperfil.png" alt="foto de perfil" class="foto-perfil">
                <?php else: ?>
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($perfil["foto_perfil"]) ?>" alt="foto de perfil" class="foto-perfil">
                <?php endif?> 
                <h2><?= htmlspecialchars($perfil["nombre"]) ?> <?= htmlspecialchars($perfil["apellido"]) ?></h2>
            </div>
            
            <aside class="info-usuario">               
                <h3>Información Personal</h3>
                <ul>
                    <li><strong>Nombre:</strong> <?= htmlspecialchars($perfil["nombre"]) ?></li>
                    <li><strong>Apellido:</strong> <?= htmlspecialchars($perfil["apellido"]) ?></li>
                    <li><strong>Email:</strong> <?= htmlspecialchars($perfil["email"]) ?></li>
                    <?php if($_SESSION["usuario"]["tipo"] == "COMERCIANTE"):?>
                        <li><strong>Nombre empresa:</strong> <?= htmlspecialchars($perfil["nombre_empresa"] ?? 'No especificado') ?></li>
                        <li><strong>NIF empresa:</strong> <?= htmlspecialchars($perfil["nif_empresa"] ?? 'No especificado') ?></li>
                        <li><strong>Detalles de la empresa:</strong> <?= htmlspecialchars($perfil["comentario_empresa"] ?? 'No especificado') ?></li>
                        <li><strong>Teléfono de la empresa:</strong> <?= htmlspecialchars($perfil["num_telefono"] ?? 'No especificado') ?></li>
                        <li><strong>Comerciante desde:</strong> <?= htmlspecialchars($perfil["comerciante_desde"] ?? 'No especificado') ?></li>
                    <?php endif?>
                </ul>
            </aside>
            
            <section class="acciones">
                <a href="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=editarPerfil" class="btn-accion">Editar perfil</a>
                <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=verAnuncios" class="btn-accion">Mis anuncios</a>
                <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=logout" class="btn-accion btn-cerrar">Cerrar sesión</a>
            </section>
        </div>
    </main>
    
    <script src="<?= BASE_URL ?>/js/index.js"></script>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>