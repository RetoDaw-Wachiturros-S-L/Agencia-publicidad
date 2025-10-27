
 <!-- Componente Header
 
 Requisitos:
 - auth_helper.php debe estar cargado antes de incluir este componente
 - Variables necesarias: $isLoggedIn, $isAdmin, $currentUser
 - CSS del header se incluye automáticamente -->

<?php
// Incluir automáticamente el CSS del header si no se ha incluido ya
if (!isset($header_css_included)) {
    echo '<link rel="stylesheet" href="' . BASE_URL . '/css/header.css"/>';
    $header_css_included = true;
}
?>

<header>
    <?php if (isset($isLoggedIn) && $isLoggedIn == true):?>
    <!-- Menú hamburguesa para móvil - IZQUIERDA -->
    <div class="mobile-menu-container">
        <input type="checkbox" id="burger-input" class="burger-input">
        <label for="burger-input" class="burger-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </label>
        
        <!-- Menú desplegable móvil -->
        <div class="mobile-dropdown-menu">
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=favourites" class="mobile-menu-item">
                <span class="mobile-menu-icon heart-icon"></span>
                Mis favoritos
            </a>
            <a href="#" class="mobile-menu-item mobile-menu-item-notification">
                <span class="mobile-menu-icon message-icon"></span>
                Mis mensajes
                <span class="notification-badge"></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=verAnuncios" class="mobile-menu-item">
                <span class="mobile-menu-icon ads-icon"></span>
                Mis anuncios
            </a>
            <a href="<?= BASE_URL ?>/index.php?controller=AdsController&accion=create" class="mobile-menu-item">
                <span class="mobile-menu-icon create-icon"></span>
                Crear anuncio
            </a>
            <a href="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=miPerfil" class="mobile-menu-item">
                <span class="mobile-menu-icon user-icon"></span>
                Mi perfil
            </a>
            <?php if ($isAdmin):?>
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=store" class="mobile-menu-item mobile-menu-item-admin">
                <span class="mobile-menu-icon admin-icon">+</span>
                Registrar usuario
            </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=logout" class="mobile-menu-item mobile-menu-item-logout">
                <span class="mobile-menu-icon logout-icon"></span>
                Cerrar sesión
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Logo - Solo visible en desktop -->
    <a href="<?= BASE_URL ?>/index.php" class="logo-link">
        <div class="logo" role="img" aria-label="Logo de comerciantes vitoria"></div>
    </a>
    
    <!-- Barra de búsqueda - CENTRO -->
    <div id="buscar">
        <div class="search-container">
            <form action="index.php?controller=AdsController&accion=buscarByPalabra" method="post">
                <input type="text" class="search" placeholder="Buscar..." name="buscar_palabra">
            </form>    
        </div>
    </div>
    
    <!-- Botón de login - Solo cuando NO está logueado -->
    <?php if (isset($isLoggedIn) && $isLoggedIn == false):?>
        <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=iniciarSesion" class="login">
            <div class="login-icon" role="img" aria-label="Botón de login"></div>
        </a>
    <?php endif; ?>

    <!-- Iconos de escritorio (ocultos en móvil) -->
    <?php if (isset($isLoggedIn) && $isLoggedIn == true):?>
    <div id="iconitos-containter" class="desktop-icons">
        <div class="user-menu-container">
        <!-- Este es tu BOTÓN hamburguesa o icono para desplegar -->
        <div id="userMenuToggle" class="user-icon" role="button" aria-label="Menú de usuario" tabindex="0"></div>

        <!-- Menú desplegable oculto -->
        <div id="userDropdownMenu" class="user-dropdown-menu">
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=favourites" class="menu-item">Mis favoritos</a>
            <a href="#" class="menu-item menu-item-notification">
                Mis mensajes
                <span class="notification-badge"></span>
            </a>
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=verAnuncios" class="menu-item">Mis anuncios</a>
            <a href="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=miPerfil" class="menu-item">Mi perfil</a>
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=logout" class="menu-item menu-item-logout">Cerrar sesión</a>
        </div>
        </div>

        
        <div class="ads-menu-container">
            <div id="adsMenuToggle" class="ads-icon" role="button" aria-label="Menú de anuncios" tabindex="0"></div>
        
            <!-- Menú desplegable de anuncios -->
            <div id="adsDropdownMenu" class="ads-dropdown-menu">
                <a href="<?= BASE_URL ?>/index.php?controller=AdsController&accion=create" class="menu-item">Crear anuncio</a>
                <a href="#" class="menu-item">Editar mis anuncios</a>
            </div>
        </div>

        <div class="heart-icon" role="button" aria-label="Favoritos" tabindex="0"></div>
        
        <?php if ($isAdmin):?>
            <a href="<?= BASE_URL ?>/index.php?controller=AuthController&accion=store" class="admin-register-btn" title="Registrar nuevo usuario">
                <span class="admin-plus">+</span>
                <span class="admin-tag">admin</span>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Lámpara de cambio de tema - DERECHA -->
    <div class="lampara" role="button" aria-label="Cambiar tema" tabindex="0"></div>

</header>
<!-- <hr> -->
