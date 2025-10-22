<?php
    require_once __DIR__ . '/../utils/auth_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/header.css">
    <title>Document</title>
</head>
<body>
    <header>
        <img src="<?= BASE_URL ?>/img/Vector.png" alt="flecha">
        <div class="logo-contenedor">
             <h2><img src="<?= BASE_URL ?>/img/logo_SSombra.png" alt="">OMERCIO VITORIA</h2>
        </div>
        <p>aaaaa</p>

        <h3>        
            <?= htmlspecialchars($currentUser['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>
        </h3>

        <img src="<?= BASE_URL ?>/img/lampara.png" alt="">
    
    </header>
    <hr>
    
</body>
</html>