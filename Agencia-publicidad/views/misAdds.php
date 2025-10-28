<?php
    require_once __DIR__ . '/../utils/auth_helper.php';
    
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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/tituloVacio.css"/>

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
</head>
<body>
<?php include __DIR__ . '/components/header.php'; ?>

<main>
    <?php if (!empty($anuncios)): ?>
        <div class="cards-row">
            <?php foreach ($anuncios as $anuncio): ?>
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
                                data-is-logged-in="1"
                                title="<?= $anuncio['es_favorito'] ? 'Quitar de favoritos' : 'Agregar a favoritos' ?>">
                            <div class="heart-icon"></div>
                        </button>
                    </div>
                    <h2 id="titulo-anuncio"><?= htmlspecialchars($anuncio['titulo']) ?></h2>
                    <p id="desc-anuncio"><?= $anuncio['detalles'] ?? 'Sin detalles' ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h2>No tienes anuncios todavía.</h2>
        <a href="<?= BASE_URL ?>/index.php?controller=AdsController&accion=create">Crear mi primer anuncio</a>
    <?php endif; ?>
    <script src="<?= BASE_URL ?>/js/index.js"></script>
</main>

<script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>