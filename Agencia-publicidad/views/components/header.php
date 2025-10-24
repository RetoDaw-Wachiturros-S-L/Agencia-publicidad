<?php
/**
 * Componente Header
 * 
 * Requisitos:
 * - auth_helper.php debe estar cargado antes de incluir este componente
 * - Variables necesarias: $isLoggedIn, $isAdmin, $currentUser
 * - CSS requerido en el <head>: layout.css (contiene todos los estilos del header)
 */
?>
<header>
    <a href="<?= BASE_URL ?>/index.php" class="logo-link">
        <div class="logo" role="img" aria-label="Logo de comerciantes vitoria"></div>
    </a>
    
    <div id="buscar">
        <div class="search-container">
            <form action="index.php?controller=AdsController&accion=buscarByPalabra" method="post">
                <input type="text" class="search" placeholder="Buscar..." name="buscar_palabra">
            </form>    
        </div>
    </div>
    
    <?php if (isset($isLoggedIn) && $isLoggedIn == false):?>
        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=iniciarSesion" class="login">
            <div class="login-icon" role="img" aria-label="Botón de login"></div>
        </a>
    <?php endif; ?>

    <?php if (isset($isLoggedIn) && $isLoggedIn == true):?>
        <div id="iconitos">
            <div class="user-menu-container">
                <div id="userMenuToggle" class="user-icon" role="button" aria-label="Menú de usuario" tabindex="0"></div>
            
                <!-- Menú desplegable de usuario -->
                <div id="userDropdownMenu" class="user-dropdown-menu">
                    <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=favourites" class="menu-item">Mis favoritos</a>
                    <a href="#" class="menu-item menu-item-notification">
                        Mis mensajes
                        <span class="notification-badge"></span>
                    </a>
                    <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=verAnuncios" class="menu-item">Mis anuncios</a>
                    <a href="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=miPerfil" class="menu-item">Mi perfil</a>
                    <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=logout" class="menu-item menu-item-logout">Cerrar sesión</a>
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
                <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=store" class="admin-register-btn" title="Registrar nuevo usuario">
                    <span class="admin-plus">+</span>
                    <span class="admin-tag">admin</span>
                </a>
            <?php endif; ?>

        </div>            
    <?php endif; ?>

    <div class="lampara" role="button" aria-label="Cambiar tema" tabindex="0"></div>

</header>
<!-- <hr> -->
