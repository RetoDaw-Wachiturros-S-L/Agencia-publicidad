<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Comercio Vitoria</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/portada.css">
</head>
<body>
    <header></header>
    <main>
        <div class="titulo" >
            <h1>
                <img src="<?= BASE_URL ?>/img/logo.png" alt="comersio" class="comercio">
                OMERCIO VITORIA
            </h1>

        </div>
        
        <img src="<?= BASE_URL ?>/img/portada.png" alt="" class="monumento">
        <div>
            <a href="<?= BASE_URL ?>/index.php?accion=index" class="acceder">Acceder</a>
        </div>
    </main>
    
    <footer>
    </footer>
</body>
</html>
