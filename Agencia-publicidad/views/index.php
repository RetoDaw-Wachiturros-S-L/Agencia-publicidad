<?php
    require_once __DIR__ . '/../utils/auth_helper.php';
    require_once __DIR__ . '/../controllers/AdsController.php';
    //require_once 'views/header.php';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css?v=2.0"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css?v=2.0"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css?v=2.0"/>
</head>
<body>
    <?php include __DIR__ . '/components/header.php'; ?>
    
    <main>
        <div class="cards-row">
            <?php foreach($anuncios as $anuncio): ?>
                <div class="card-anuncio" data-id-anuncio="<?= $anuncio['id'] ?>">
                    <div class="div-tj-img">
                        <?php
                            // Mostrar foto de portada si existe
                            if (!empty($anuncio['url_foto'])) {
                                $rutaCompleta = BASE_URL . '/' . $anuncio['url_foto'];
                                echo "<img src='{$rutaCompleta}' alt='{$anuncio['titulo']}'>";
                            } else {
                                // Imagen por defecto
                                echo "<img src='" . BASE_URL . "/img/logo.png' alt='Sin imagen'>";
                            }
                        ?>
                        <!-- Botón de corazón para favoritos -->
                        <button class="btn-favorito <?= $anuncio['es_favorito'] ? 'favorito-activo' : '' ?>" 
                                data-anuncio-id="<?= $anuncio['id'] ?>" 
                                data-es-favorito="<?= $anuncio['es_favorito'] ?>"
                                data-is-logged-in="<?= $isLoggedIn ? '1' : '0' ?>"
                                title="<?= $isLoggedIn ? ($anuncio['es_favorito'] ? 'Quitar de favoritos' : 'Agregar a favoritos') : 'Iniciar sesión para agregar a favoritos' ?>">
                            <div class="heart-icon"></div>
                        </button>
                    </div>
                    <h2 id="titulo-anuncio"><?= htmlspecialchars($anuncio['titulo']) ?></h2>
                    <p id="desc-anuncio"><?= htmlspecialchars($anuncio['detalles'] ?? 'Sin detalles') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <script src="<?= BASE_URL ?>/js/index.js?v=2.0"></script>
    </main>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js?v=2.0" defer></script>
</body>
</html>