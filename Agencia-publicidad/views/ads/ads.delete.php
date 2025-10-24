<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    <form action="index.php?controller=AdsController&accion=delete" method="post">
        <h3>Selecciona el anuncio que quieres borrar:</h3>
        <?php foreach ($anunciosPorIdComerciante as $anuncio): ?>
            <label>
                <input type="radio" name="idAnuncio" value="<?= $anuncio['id'] ?>">
                <?= htmlspecialchars($anuncio['titulo']) ?>
            </label><br>
        <?php endforeach; ?>
    <button type="submit">Borrar anuncio</button>
</form>
</body>
</html>