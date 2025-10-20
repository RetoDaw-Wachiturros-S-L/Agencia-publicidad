<?php
    //Comprobar session
    require_once __DIR__ . '/../utils/auth_helper.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
    <link rel="stylesheet" href="../css/layout.css"/>
    <link rel="stylesheet" href="../css/index.css"/>
</head>
<header>
    <img src="../img/logo_SSombra.png" alt="Logo de comerciantes vitoria" class="logo">
    <div id="buscar">
        <input type="text" class="search"> 
    </div>

    <?php if (isset($isLoggedIn) && $isLoggedIn == true):?>
        <?= $isLoggedIn ?>
        <a href="../index.php?controller=OutController&accion=iniciarSesion" class="login">
            <img src="../img/login.png" alt="Boton de login" id="btnLogin">
        </a>
    <?php endif; ?>

    <?php if (isset($isLoggedIn) && $isLoggedIn == false):?>
        <p>B1</p>
        <p>B2</p>
        <p>B3</p>
    <?php endif; ?>

    <img src="../img/lampara.png" alt="Boton de cambio de tema" class="lampara">
</header>
<main>
        <hr>


<div class="card-anuncio">
    <div class="div-tj-img">
        <img src="../" alt="">
        <!-- Imagen que tendrá src autogenerado y alt igual -->
    </div>
    <h2 id="titulo-anuncio" ><?php $anuncio['titulo'] ?? 'titulo anuncio generico' ?></h2>
</div>

<script src="../js/index.js"></script>
</main>
</html>