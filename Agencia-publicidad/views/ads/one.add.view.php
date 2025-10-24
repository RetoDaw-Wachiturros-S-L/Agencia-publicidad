<?php
    use AgenciaPublicidad\Models\Anuncio;
    
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
    <title>Pagina principal</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/oneAd.css"/>
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>

    <main>
        <div class="una-sola-card">            
            
            <div class="card-anuncio">
                <!-- Estilo para la foto solo -->
                <div class="div-tj-img-unico">
                    <?php
                        $urlFoto = $anuncio->getUrlFotos();
                        if (!empty($urlFoto)) {
                            $rutaCompleta = BASE_URL . '/' . $urlFoto;
                            echo "<img src='{$rutaCompleta}' alt='{$anuncio->getTitulo()}' class='favorito-icono' data-id='{$anuncio->getId()}'>";
                        } else {
                            echo "<img src='" . BASE_URL . "/img/logo.png' alt='Sin imagen' class='favorito-icono' data-id='{$anuncio->getId()}'>";
                        }
                    ?>
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
                        <img id="heart-icon" src="<?= BASE_URL?>/img/Heart.png" alt="Favorito">
                        <img src="<?= BASE_URL?>/img/mensaje.png" alt="Bell">
                    </div>
                </div>
                  
            </div>
        </div>
    <script src="https :// cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="<?= BASE_URL ?>/js/one.ad.js"></script>
    </main>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>