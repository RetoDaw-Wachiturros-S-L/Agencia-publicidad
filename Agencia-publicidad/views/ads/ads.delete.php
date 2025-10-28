<?php
require_once __DIR__ . '/../../utils/auth_helper.php';

// Extraer variables globales al scope local
$currentUser = $GLOBALS['currentUser'] ?? null;
$isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
$isAdmin = $GLOBALS['isAdmin'] ?? false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css">
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>
    
    <main>
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
    </main>
    
    <script src="<?= BASE_URL ?>/js/index.js"></script>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>