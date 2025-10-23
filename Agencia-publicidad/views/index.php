<?php
    require_once __DIR__ . '/../utils/auth_helper.php';
    require_once __DIR__ . '/../controllers/AdsController.php';
    
    // Extraer variables globales al scope local
    $currentUser = $GLOBALS['currentUser'] ?? null;
    $isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
    $isAdmin = $GLOBALS['isAdmin'] ?? false;
    
    // DEBUG TEMPORAL - Eliminar después
    echo "<!-- DEBUG: isLoggedIn = " . var_export($isLoggedIn, true) . " -->";
    echo "<!-- DEBUG: isAdmin = " . var_export($isAdmin, true) . " -->";
    echo "<!-- DEBUG: SESSION = " . var_export($_SESSION['usuario'] ?? 'NO HAY', true) . " -->";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script>
(function (m, a, z, e) {
  var s, t;
  try {
    t = m.sessionStorage.getItem('maze-us');
  } catch (err) {}

  if (!t) {
    t = new Date().getTime();
    try {
      m.sessionStorage.setItem('maze-us', t);
    } catch (err) {}
  }

  s = a.createElement('script');
  s.src = z + '?apiKey=' + e;
  s.async = true;
  a.getElementsByTagName('head')[0].appendChild(s);
  m.mazeUniversalSnippetApiKey = e;
})(window, document, 'https://snippet.maze.co/maze-universal-loader.js', 'e76390a3-92da-44e0-9412-672022d0d84d');
</script>
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
                <form action="index.php?controller=AdsController&accion=buscarByPalabra" method="post">
                    <input type="text" class="search" placeholder="Buscar..." name="buscar_palabra">
                </form>    
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
                </p>
                <div class="user-menu-container">
                    <img src="<?= BASE_URL ?>/img/User.png" alt="persona" id="userMenuToggle" class="user-icon">
                
                    <!-- Menú desplegable -->
                    <div id="userDropdownMenu" class="user-dropdown-menu">
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=favourites" class="menu-item">Mis favoritos</a>
                        <a href="#" class="menu-item menu-item-notification">
                            Mis mensajes
                            <span class="notification-badge"></span>
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=verAnuncios" class="menu-item">Mis anuncios</a>
                        <a href="#" class="menu-item">Mi perfil</a>
                        <a href="<?= BASE_URL ?>/index.php?controller=OutController&accion=logout" class="menu-item menu-item-logout">Cerrar sesión</a>
                    </div>
                </div>
            
                <div class="ads-menu-container">
                    <img src="<?= BASE_URL ?>/img/ad.png" alt="anuncios" id="adsMenuToggle" class="ads-icon">
                
                    <!-- Menú desplegable de anuncios -->
                    <div id="adsDropdownMenu" class="ads-dropdown-menu">
                        <a href="<?= BASE_URL ?>/index.php?controller=AdsController&accion=create" class="menu-item">Crear anuncio</a>
                        <a href="#" class="menu-item">Editar mis anuncios</a>
                    </div>
                </div>

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
            <?php foreach($anuncios as $anuncio): ?>
            <div class="card-anuncio" action="index.php?controller=AdsController&accion=show">
                <div class="div-tj-img">
                    <img src="<?= BASE_URL ?>/img/logo.png" alt="logo">
                    <!-- Imagen que tendrá src autogenerado y alt igual -->
                </div>
                <h2 id="titulo-anuncio" > <?= $anuncio['titulo'] ?> </h2>
                <p id="desc-anuncio"> <?= $anuncio['detalles'] ?? 'Sin detalles' ?> </p>
            </div>
                
            
                <?php endforeach; ?>
        </div>
    <script src="<?= BASE_URL ?>/js/index.js"></script>
    </main>
</body>
</html>