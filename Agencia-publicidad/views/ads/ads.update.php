<?php    
    require_once __DIR__ . '/../../utils/auth_helper.php';
    
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
    <title>Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/oneAd.css"/>
</head>
<body>

    <main>

        <div class="una-sola-card">
        <div class="card-anuncio">
            <!-- Imagen de portada del anuncio -->
            <div class="div-tj-img-unico">
            <?php
                $urlFoto = $anuncio->getUrlFotos();
                if (!empty($urlFoto)) {
                $rutaCompleta = BASE_URL . '/' . $urlFoto;
                echo "<img src='{$rutaCompleta}' alt='{$anuncio->getTitulo()}' class='portada-anuncio'>";
                } else {
                echo "<img src='" . BASE_URL . "/img/logo.png' alt='Sin imagen' class='portada-anuncio'>";
                }
            ?>
            </div>

                <form class="container-div-info" method="post" action="index.php?controller=AdsController&accion=update">

                <input type="hidden" name="id" value="<?= htmlspecialchars($anuncio->getId()) ?>">

                <div class="info-div">
                    <label for="titulo-anuncio">Título del anuncio:</label>
                    <input 
                        type="text" 
                        id="titulo-anuncio"
                        class="input-anuncio-upd" 
                        name="titulo" 
                        value="<?= $anuncio->getTitulo() ?>" 
                        required
                        minlength="2"
                        maxlength="150"
                    >

                    <label for="desc-anuncio">Descripción:</label>
                    <input 
                        type="text"
                        class="input-anuncio-upd"  
                        id="desc-anuncio" 
                        name="descripcion" 
                        value="<?= $anuncio->getDescripcion() ?? 'Sin detalles' ?>" 
                    >
                    <input type="submit" id="btn-guardar" class="submit-anuncio-upd">
                </div>

                <!-- Datos de la empresa -->
                <div class="info-div">
                    <h2>Datos de la empresa:</h2>
                    <ul>
                    <li><?= $anuncio->getAnunciante()->getNombreComercio() ?? 'Sin detalles' ?></li>
                    <li>Mail: <?= $anuncio->getAnunciante()->getEmail() ?? 'Sin detalles' ?></li>
                    <li>Telf: <?= $anuncio->getAnunciante()->getNumTelefono() ?? 'Sin detalles' ?></li>
                    </ul>
                    <div><span class="fecha-formateada">Publicado en: <?= $fechaFormateada ?></span></div>
                </div> 
            </form>
        </div>
        </div>
    </main>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>