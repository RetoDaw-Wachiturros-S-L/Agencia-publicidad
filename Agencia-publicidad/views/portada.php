<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Comercio Vitoria</title>
  <link rel="stylesheet" href="../css/layout.css"/>
  <link rel="stylesheet" href="../css/portada.css">
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
    <header></header>
    <main>
        <div class="titulo" >
            <h1>
                <img src="../img/logo.png" alt="comersio" class="comercio">
                OMERCIO VITORIA
            </h1>

        </div>
        
        <img src="../img/portada.png".png alt="" class="monumento">
        <div>
            <a href="../" class="acceder">Acceder</a>
        </div>
    </main>
    
    <footer>
    </footer>
</body>
</html>
