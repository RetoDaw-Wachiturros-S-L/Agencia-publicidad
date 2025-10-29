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
                    </div>

                    <h2 id="titulo-anuncio"><?= htmlspecialchars($anuncio['titulo']) ?></h2>

                    <p id="desc-anuncio"><?= $anuncio['detalles'] ?? 'Sin detalles' ?></p>
                    
                    <a
                        class="btn-editar-anuncio"
                        href="<?= BASE_URL ?>/index.php?controller=AdsController&accion=edit&id=<?= $anuncio['id'] ?>"
                    >
                        Editar Anuncio
                    </a>

                    <a 
                        href="<?= BASE_URL ?>/index.php?controller=AdsController&accion=delete&id=<?= $anuncio['id'] ?>"
                        class="btn-borrar-anuncio"
                    >
                    Borrar Anuncio
                    </a>
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