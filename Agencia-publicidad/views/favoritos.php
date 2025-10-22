<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Favoritos</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css"/>
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
                    <h2 id="titulo-anuncio" ><?= $anuncio["a.titulo"]?></h2>
                    <p id="desc-anuncio"><?= $anuncio["a.detalles"]?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No tienes anuncios favoritos todavía.</p>
    <?php endif; ?>
</main>


</body>
</html>