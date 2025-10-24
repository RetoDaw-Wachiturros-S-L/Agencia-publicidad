<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/oneAd.css"/>
</head>
<body>
    <header>
        <img src="<?= BASE_URL ?>/img/logo_SSombra.png" alt="Logo de comerciantes vitoria" class="logo">
        
        <div id="buscar">
            <div class="search-container">
                <form action="index.php?controller=AdsController&accion=buscarByPalabra" method="post">
                    <input type="text" class="search" placeholder="Buscar..." name="buscar_palabra">
                </form>    
            </div>
        </div>
        
        <?php

                    use AgenciaPublicidad\Models\Anuncio;

 if (isset($isLoggedIn) && $isLoggedIn == false):?>
            <?= $isLoggedIn ?>
            <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=iniciarSesion" class="login">
                <img src="<?= BASE_URL ?>/img/login.png" alt="Boton de login" id="btnLogin">
            </a>
        <?php endif; ?>

        <?php if (isset($isLoggedIn) && $isLoggedIn == true):?>
            <div id="iconitos">
                <div class="user-menu-container">
                    <img src="<?= BASE_URL ?>/img/User.png" alt="persona" id="userMenuToggle" class="user-icon">
                
                    <!-- Menú desplegable -->
                    <div id="userDropdownMenu" class="user-dropdown-menu">
                        <a href="#" class="menu-item">Mis favoritos</a>
                        <a href="#" class="menu-item menu-item-notification">
                            Mis mensajes
                            <span class="notification-badge"></span>
                        </a>
                        <a href="#" class="menu-item">Mis anuncios</a>
                        <a href="#" class="menu-item">Mi perfil</a>
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=logout" class="menu-item menu-item-logout">Cerrar sesión</a>
                    </div>
                </div>
            
                <img src="<?= BASE_URL ?>/img/Bell.png" alt="campana">
                <img src="<?= BASE_URL ?>/img/Heart.png" alt="corazon">
                
                <?php if ($isAdmin):?>
                    <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=store" class="admin-register-btn" title="Registrar nuevo usuario">
                        <span class="admin-plus">+</span>
                        <span class="admin-tag">admin</span>
                    </a>
                <?php endif; ?>
                
            </div>            
        <?php endif; ?>

        <img src="<?= BASE_URL ?>/img/lampara.png" alt="Boton de cambio de tema" class="lampara">

    </header>


    <main>
        <div class="una-sola-card">            
            
            <div class="card-anuncio">
                <!-- Estilo para la foto solo -->
                <div class="div-tj-img-unico">
                    <img 
                        src="<?= $anuncio->getUrlFotos() ?? BASE_URL.'/img/logo.png' ?>" 
                        alt="<?= $anuncio->getTitulo() ?>" 
                        class="favorito-icono" 
                        data-id="<?= $anuncio->getId() ?>"
                    >
                </div>
                <div class="container-div-info">
                    <div class="info-div">
                        <h2 id="titulo-anuncio" > <?= $anuncio->getTitulo() ?> </h2>
                        <p id="desc-anuncio"> <?= $anuncio->getDescripcion() ?? 'Sin detalles' ?> </p>
                    
                    </div>
                    <div class="info-div">
                        <h2 id="titulo-anuncio" >Datos de la empresa:</h2>
                            <ul id="desc-anuncio">
                                <li>
                                    <?= $anuncio->getAnunciante()->getNombreComercio() ?? 'sin detalles' ?>
                                </li>
                                <li>
                                    Mail: <?= $anuncio->getAnunciante()->getEmail() ?? 'Sin detalles' ?> 
                                </li>
                                <li>
                                    Tel: <?= $anuncio->getAnunciante()->getNumTelefono() ?? 'Sin detalles' ?>
                                </li>
                            </ul>    
                            <p><span class="fecha-formateada">Publicado en: <?= $fechaFormateada ?></span></p> 
                    </div>              

                    <div class="div-icons">
                        <img 
                            src=" <?= BASE_URL ?>/img/Heart.png" alt="Favorito"
                            class="favorito-icono"
                            data-id="heart-icon" 
                        >
                        <img 
                        src="<?= BASE_URL?>/img/mensaje.png" 
                        alt="Bell">
                    </div>
                </div>
                  
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <script src="<?= BASE_URL ?>/js/one.ad.js"></script>
    </main>
</body>
</html>