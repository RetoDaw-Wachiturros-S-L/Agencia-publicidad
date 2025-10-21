<?php require_once __DIR__ . '/../utils/auth_helper.php';?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css"/>
</head>
<body>
    <header>
        <img src="<?= BASE_URL ?>/img/logo_SSombra.png" alt="Logo de comerciantes vitoria" class="logo">
        
        <div id="buscar">
            <div class="search-container">
                <input type="text" class="search" placeholder="Buscar...">
                <select name="fruta" id="filtros">
                    <option value="manzana">Manzana</option>
                    <option value="banana">Banana</option>
                    <option value="naranja">Naranja</option>
                    <option value="kiwi">Kiwi</option>
                </select>
            </div>
        </div>
        
        <?php if (isset($isLoggedIn) && $isLoggedIn == false):?>
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
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=favourites" class="menu-item">Mis favoritos</a>
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=misMensajes" class="menu-item menu-item-notification">
                            Mis mensajes
                            <span class="notification-badge"></span>
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=misAnuncios" class="menu-item">Mis anuncios</a>
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=miPerfil" class="menu-item">Mi perfil</a>
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
    <hr>
    <main>
        <div class="cards-row">
                <div class="card-anuncio">
        <div class="div-tj-img">
            <img src="<?= BASE_URL ?>/img/logo.png" alt="logo">
            <!-- Imagen que tendrá src autogenerado y alt igual -->
        </div>
        <h2 id="titulo-anuncio" >Titulo 1</h2>
        <p id="desc-anuncio">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellendus vero placeat reiciendis necessitatibus facilis reprehenderit nihil sunt omnis amet fuga assumenda, consequatur natus, blanditiis pariatur neque quam quas repellat qui!</p>
    </div>

        <div class="card-anuncio">
        <div class="div-tj-img">
            <img src="<?= BASE_URL ?>/img/logo.png" alt="logo">
            <!-- Imagen que tendrá src autogenerado y alt igual -->
        </div>
        <h2 id="titulo-anuncio" >Titulo 1</h2>
        <p id="desc-anuncio">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellendus vero placeat reiciendis necessitatibus facilis reprehenderit nihil sunt omnis amet fuga assumenda, consequatur natus, blanditiis pariatur neque quam quas repellat qui!</p>
    </div>

        <div class="card-anuncio">
        <div class="div-tj-img">
            <img src="<?= BASE_URL ?>/img/logo.png" alt="logo">
            <!-- Imagen que tendrá src autogenerado y alt igual -->
        </div>
        <h2 id="titulo-anuncio" >Titulo 1</h2>
        <p id="desc-anuncio">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellendus vero placeat reiciendis necessitatibus facilis reprehenderit nihil sunt omnis amet fuga assumenda, consequatur natus, blanditiis pariatur neque quam quas repellat qui!</p>
    </div>

        <div class="card-anuncio">
        <div class="div-tj-img">
            <img src="<?= BASE_URL ?>/img/logo.png" alt="logo">
            <a href=""></a>
            <!-- Imagen que tendrá src autogenerado y alt igual -->
        </div>
        <h2 id="titulo-anuncio" >Titulo 1</h2>
        <p id="desc-anuncio">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellendus vero placeat reiciendis necessitatibus facilis reprehenderit nihil sunt omnis amet fuga assumenda, consequatur natus, blanditiis pariatur neque quam quas repellat qui!</p>
    </div>
        </div>
                

    <script src="<?= BASE_URL ?>/js/index.js"></script>
    </main>

</body>
</html>