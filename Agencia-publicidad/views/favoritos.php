<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Favoritos</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css"/>
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
<main>
    <?php if (!empty($anuncios)): ?>
        <div class="cards-row">
            <?php foreach ($anuncios as $anuncio): ?>
                <div class="card-anuncio">
                    <div class="div-tj-img">
                        <img src="<?= BASE_URL ?>/img/logo.png" alt="logo">
                    </div>
                    <h2 id="titulo-anuncio" ><?= $anuncio["titulo"]?></h2>
                    <p id="desc-anuncio"><?= $anuncio["detalles"]?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No tienes anuncios favoritos todavía.</p>
    <?php endif; ?>
</main>

</body>
</html>
