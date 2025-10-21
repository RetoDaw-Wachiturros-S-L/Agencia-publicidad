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
        <img src="https://images.unsplash.com/photo-1508921912186-1d1a45ebb3c1" alt="Creative workspace">
    </div>
    <h2 id="titulo-anuncio">Diseño que Inspira</h2>
    <p id="desc-anuncio">Transforma tu marca con diseños que capturan emociones. Nuestro equipo convierte ideas en experiencias visuales inolvidables.</p>
</div>

<div class="card-anuncio">
    <div class="div-tj-img">
        <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2" alt="Marketing strategy">
    </div>
    <h2 id="titulo-anuncio">Estrategias que Venden</h2>
    <p id="desc-anuncio">Impulsa tus ventas con campañas publicitarias pensadas para conectar con tu audiencia. Resultados medibles desde el primer día.</p>
</div>

<div class="card-anuncio">
    <div class="div-tj-img">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f" alt="Social media team">
    </div>
    <h2 id="titulo-anuncio">Redes Sociales al Máximo</h2>
    <p id="desc-anuncio">Gestionamos tus redes con contenido atractivo y estrategias de crecimiento. Conecta, fideliza y convierte seguidores en clientes.</p>
</div>

<div class="card-anuncio">
    <div class="div-tj-img">
        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085" alt="Web development">
    </div>
    <h2 id="titulo-anuncio">Tu Web, Tu Mundo</h2>
    <p id="desc-anuncio">Creamos sitios web modernos, rápidos y adaptados a tu negocio. Diseño responsive, optimización SEO y experiencia de usuario impecable.</p>
</div>

<div class="card-anuncio">
    <div class="div-tj-img">
        <img src="https://images.unsplash.com/photo-1559027615-5d5c6a1a3b4d" alt="Brand identity">
    </div>
    <h2 id="titulo-anuncio">Identidad de Marca Única</h2>
    <p id="desc-anuncio">Construimos marcas con personalidad. Desde el logo hasta el tono de voz, cada detalle comunica quién eres y qué representas.</p>
</div>

        </div>
                

    <script src="<?= BASE_URL ?>/js/index.js"></script>
    </main>

</body>
</html>