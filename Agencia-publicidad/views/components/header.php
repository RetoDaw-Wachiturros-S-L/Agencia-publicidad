
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
    <a href="<?= BASE_URL ?>/index.php?accion=index" class="logo-link">
        <div class="logo" role="img" aria-label="Logo de comerciantes vitoria"></div>
    </a>
    
    <!-- Barra de búsqueda - CENTRO -->
    <div id="buscar">
        <div class="search-container">
            <form action="index.php?controller=AdsController&accion=buscarByPalabra" method="post" id="searchForm">
                <input type="text" class="search" placeholder="Buscar..." name="buscar_palabra">
                <button type="submit" class="search-button" aria-label="Buscar"></button>
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
                <div class="admin-menu-container">
                    <div id="adminMenuToggle" class="admin-register-btn" role="button" aria-label="Menú de administrador" tabindex="0" title="Administrador">
                        <span class="admin-plus">+</span>
                        <span class="admin-tag">admin</span>
                    </div>
                    
                    <!-- Menú desplegable de administrador -->
                    <div id="adminDropdownMenu" class="admin-dropdown-menu">
                        <a href="#" class="menu-item">Opción 1</a>
                        <a href="#" class="menu-item">Opción 2</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>            
    <?php endif; ?>

    <!-- Lámpara de cambio de tema - DERECHA -->
    <div class="lampara" role="button" aria-label="Cambiar tema" tabindex="0"></div>

</header>
<!-- <hr> -->
