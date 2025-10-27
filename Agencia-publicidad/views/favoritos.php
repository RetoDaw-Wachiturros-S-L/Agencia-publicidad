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
    <title>Mis Favoritos</title>
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
                
                <div class="card-anuncio">
                    <div class="div-tj-img">
                        <a href="index.php?controller=AdsController&accion=show" name=<?= $anuncio['id'] ?>>
                            <img src="<?= BASE_URL ?>/img/logo.png" alt="logo">
                        </a>
                    </div>
                    <h2 id="titulo-anuncio" ><?= $anuncio["titulo"]?></h2>
                    <p id="desc-anuncio"><?= $anuncio["detalles"]?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h2>No tienes anuncios favoritos todavía.</h2>
    <?php endif; ?>
</main>

    <script src="<?= BASE_URL ?>/js/burger.js"></script>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>
